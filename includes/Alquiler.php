<?php
namespace es\ucm\fdi\aw;

class Alquiler {

    private $id_alquiler;
    private $id_usuario;
    private $id_viaje;

    /**
     * Constructor de la clase Alquiler
     */
    public function __construct($id_usuario, $id_viaje) {
        $this->id_alquiler = null;
        $this->id_usuario = $id_usuario;
        $this->id_viaje = $id_viaje;
    }

    /**
     * Crea un nuevo alquiler
     */
    public static function crea($id_usuario, $id_viaje) {
        $alquiler = new Alquiler($id_usuario, $id_viaje);
        return self::inserta($alquiler);
    }

    /**
     * Inserta un nuevo alquiler en la base de datos
     * @return boolean true si se ha insertado correctamente, false en caso contrario
     */
    private static function inserta($alquiler){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Alquiler(id_usuario, id_viaje) VALUES ('%d', '%d')",
            $conn->real_escape_string($alquiler->id_usuario),
            $conn->real_escape_string($alquiler->id_viaje)
        );

        if ($conn->query($query)) {
            $alquiler->setId_alquiler($conn->insert_id);
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $alquiler;
    }

    static public function misAlquileres($id_usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT a.id_viaje FROM ALquiler a WHERE a.id_usuario = %d", $id_usuario);
        $tmp = $conn->query($query);
        
        $result = false;
        if ($tmp) {
            $result = [];
            while ($row1 = $tmp->fetch_assoc()) {
                $queryViaje = sprintf("SELECT * FROM VIAJE WHERE id_viaje = %d", $row1['id_viaje']);
                $res = $conn->query($queryViaje);
                $row = $res->fetch_assoc();
                $viaje = new Viaje(
                    $row['id_empresa'],
                    $row['ciudad_origen'],
                    $row['ciudad_destino'],
                    $row['fecha_inicio'],
                    $row['fecha_final'],
                    $row['free']);
                $viaje->setId($row['id_viaje']);
                $result[] = $viaje;
            }
            $tmp->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $result;
    }

    public function setId_alquiler($id){
        $this->id_alquiler = $id;
    }

    public function getId_alquiler(){
        return $this->id_alquiler;
    }
    /**
     * Devuelve el id del usuario
     */
    public function getIdUsuario() {
        return $this->id_usuario;
    }

    /**
     * Devuelve el id del viaje
     */
    public function getIdViaje() {
        return $this->id_viaje;
    }

}
?>
