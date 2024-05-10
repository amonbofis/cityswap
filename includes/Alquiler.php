<?php
namespace es\ucm\fdi\aw;

class Alquiler {

    private $id_usuario;
    private $id_viaje;

    /**
     * Constructor de la clase Alquiler
     */
    public function __construct($id_usuario, $id_viaje) {
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
        $query = sprintf("INSERT INTO Alquiler(id_usuario, id_viaje) VALUES ('%s', '%s')",
            $conn->real_escape_string($alquiler->id_usuario),
            $conn->real_escape_string($alquiler->id_viaje)
        );

        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
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
