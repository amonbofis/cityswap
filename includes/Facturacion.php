<?php
namespace es\ucm\fdi\aw;
class Facturacion {

    private $id_alquiler;
    private $monto;
    private $fecha;
    public function __construct($id_alquiler, $monto) {
        $this->id_alquiler = $id_alquiler;
        $this->monto = $monto;       
    }
    public static function creaFacturacion( $id_alquiler, $monto) {
        $alquiler = new Facturacion($id_alquiler, $monto);
        return $alquiler->guarda();
    }

    public function guarda() {
        if ($this->id !== null) {
            return self::actualizaFacturacion($this);
        }
        return self::insertaFacturacion($this);
    }

    public static function insertaFacturacion($facturacion) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO FACTURACION (id_alquiler,
                                                monto, 
                                                fecha) 
            VALUES ('%d', '%d', '%s')",
            $conn->real_escape_string($facturacion->getId_alquiler()),
            $conn->real_escape_string($facturacion->getMonto()),
            date('Y-m-d'),
        );

        if ($conn->query($query)) {
            return $facturacion;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    static public function obtenerFacturacion() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Facturacion");
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = [];
            while ($row = $rs->fetch_assoc()) {
                $facturacion = new Facturacion(
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
            return false;
        }
        return $result;
    }

    static public function factPorAlq($id_alquiler) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Facturacion WHERE id_alquiler = %d", $id_alquiler);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $result = [];
            while ($row = $rs->fetch_assoc()) {
                $facturacion = new Facturacion(
                    $row['id_alquiler'],
                    $row['monto'],);
                $result[] = $facturacion;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $result;
    }

    public function getId_alquiler(){
        return $this->id_alquiler;
    }

    public function getMonto(){
        return $this->monto;
    }

    public function getFecha(){
        return $this->fecha;
    }
    
}