<?php
namespace es\ucm\fdi\aw;
class Viaje {

    private $id;
    private $id_empresa;
    private $ciudad_origen;
    private $ciudad_destino;
    private $fecha_inicio;
    private $fecha_final;
    private $free;
    public function __construct($id_empresa, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final, $id = null) {
        $this->id = $id;
        $this->id_empresa = $id_empresa;
        $this->ciudad_origen = $ciudad_origen;
        $this->ciudad_destino = $ciudad_destino;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_final = $fecha_final;
        $this->free = true;
    }
    public static function creaViaje($id_empresa, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final) {
        $viaje = new Viaje($id_empresa, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final);
        return $viaje->guarda();
    }

    public function guarda() {
        if ($this->id !== null) {
            return self::actualizaViaje($this);
        }
        return self::insertaViaje($this);
    }

    public static function insertaViaje($viaje) {
        print("inserta called");
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Viaje (id_empresa,
                                                ciudad_origen, 
                                                ciudad_destino, 
                                                fecha_inicio,
                                                fecha_final) 
            VALUES ('%s', '%s', '%s', '%s', '%s', '%d')",
            $conn->real_escape_string($viaje->getId_empresa()),
            $conn->real_escape_string($viaje->getCiudad_origen()),
            $conn->real_escape_string($viaje->getCiudad_destino()),
            $conn->real_escape_string($viaje->getFecha_inicio()),
            $conn->real_escape_string($viaje->getFecha_final()),
            1
        );
        if ($conn->query($query)) {
            $viaje->setId($conn->insert_id);
            
            return $viaje;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    public static function actualizaViaje($viaje) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Viaje A SET ciudad_origen = '%s', ciudad_destino = '%s', fecha_inicio='%s', fecha_final='%s' WHERE A.id=%d"
            , $conn->real_escape_string($viaje->ciudad_origen)
            , $conn->real_escape_string($viaje->ciudad_destino)
            , $conn->real_escape_string($viaje->fecha_inicio)
            , $conn->real_escape_string($viaje->fecha_final)
            , $viaje->id
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $viaje;
    }

    static public function obtenerViajes() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Viaje where free = 1");
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = [];
            while ($row = $rs->fetch_assoc()) {
                $viaje = new Viaje(
                    $row['id_empresa'],
                    $row['ciudad_origen'],
                    $row['ciudad_destino'],
                    $row['fecha_inicio'],
                    $row['fecha_final']);
                $viaje->setId($row['id_viaje']);
                $result[] = $viaje;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $result;
    }

    static public function buscaViajePorId($id_viaje) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Viaje WHERE id_viaje = %d", $id_viaje);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ($rs->num_rows == 1) {
                $row = $rs->fetch_assoc();
                $viaje = new Viaje(
                    $row['id_empresa'],
                    $row['ciudad_origen'],
                    $row['ciudad_destino'],
                    $row['fecha_inicio'],
                    $row['fecha_final']);
                $viaje->setId($row['id_viaje']);
                $result = $viaje;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $result;
    }

    static public function viajesRes($id_usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Viaje WHERE id_usuario = %d", $id_usuario);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = [];
            while ($row = $rs->fetch_assoc()) {
                $viaje = new Viaje(
                    $row['id_empresa'],
                    $row['ciudad_origen'],
                    $row['ciudad_destino'],
                    $row['fecha_inicio'],
                    $row['fecha_final']);
                $result[] = $viaje;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
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

    public function getFree(){
        return $this->free;
    }

    public function setFree($bool){
        $this->free = $bool;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $boolValue = $bool ? 1 : 0; // Convert boolean value to integer (1 for true, 0 for false)
        $query = sprintf("UPDATE Viaje SET free = %d WHERE id_viaje = %d", $boolValue, $this->id);
        $rs = $conn->query($query);
    }
    
}