<?php
namespace es\ucm\fdi\aw;
class Alquiler {

    private $id;
    private $id_empresa;
    private $id_alquiler;
    private $ciudad_origen;
    private $ciudad_destino;
    private $fecha_inicio;
    private $fecha_final;
    public function __construct($id_empresa, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final, $id = null) {
        $this->id = $id;
        $this->id_empresa = $id_empresa;
        $this->id_alquiler = null;
        $this->ciudad_origen = $ciudad_origen;
        $this->ciudad_destino = $ciudad_destino;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_final = $fecha_final;
    }
    public static function creaAlquiler( $id_empresa, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final) {
        $alquiler = new Alquiler($id_empresa, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final);
        return $alquiler->guarda();
    }

    public function guarda() {
        if ($this->id !== null) {
            return self::actualizaAlquiler($this);
        }
        return self::insertaALquiler($this);
    }

    public static function insertaAlquiler($alquiler) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO ALQUILER (id_empresa,
                                                id_usuario, 
                                                ciudad_origen, 
                                                ciudad_destino, 
                                                fecha_inicio,
                                                fecha_final) 
            VALUES ('%s', '%s', '%s', '%s')",
            $conn->real_escape_string($alquiler->getId_empresa()),
            $conn->real_escape_string($alquiler->getId_usuario()),
            $conn->real_escape_string($alquiler->getCiudad_origen()),
            $conn->real_escape_string($alquiler->getCiudad_destino()),
            $conn->real_escape_string($alquiler->getFecha_inicio()),
            $conn->real_escape_string($alquiler->getFecha_final())

        );

        if ($conn->query($query)) {
            $alquiler->setId($conn->insert_id);
            return $alquiler;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    public static function actualizaAlquiler($alquiler) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE ALQUILER A SET ciudad_origen = '%s', ciudad_destino = '%s', fecha_inicio='%s', fecha_final='%s' WHERE A.id=%d"
            , $conn->real_escape_string($alquiler->ciudad_origen)
            , $conn->real_escape_string($alquiler->ciudad_destino)
            , $conn->real_escape_string($alquiler->fecha_inicio)
            , $conn->real_escape_string($alquiler->fecha_final)
            , $alquiler->id
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $alquiler;
    }

    static public function obtenerAlquilers() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Alquiler");
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = [];
            while ($row = $rs->fetch_assoc()) {
                $alquiler = new Alquiler(
                    $row['id_empresa'],
                    $row['ciudad_origen'],
                    $row['ciudad_destino'],
                    $row['fecha_inicio'],
                    $row['fecha_final']);
                $result[] = $alquiler;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getId_empresa(){
        return $this->id_empresa;
    }

    public function getId_usuario(){
        return $this->id_usuario;
    }

    public function setId_usuario($id){
        $this->id_usuario = $id;
    }

    public function getCiudad_origen(){
        return $this->ciudad_origen;
    }

    public function getCiudad_destino(){
        return $this->ciudad_destino;
    }

    public function getFecha_inicio(){
        return $this->fecha_inicio;
    }

    public function getFecha_final(){
        return $this->fecha_final;
    }
    
}