<?php
namespace es\ucm\fdi\aw;
class Empresa {
    
    public static function login($nombre_empresa, $contrasena) {
        $result = static::buscaEmpresa($nombre_empresa);
        $empresa = $result;
        if ($empresa && $empresa->compruebaPassword($contrasena)) {
            return $empresa;
        }
        return false;
    }
    public static function creaEmpresa( $nombre_empresa, $email, $contrasena) {
        $user = new Empresa($nombre_empresa, $email, self::hashPassword($contrasena));
        return $user->guarda();
    }
    public static function buscaEmpresa($nombre_empresa) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = false;
        
        $query = sprintf("SELECT * FROM EMPRESA WHERE nombre_empresa='%s'", $conn->real_escape_string($nombre_empresa));
        $rs = $conn->query($query);
        
        if ($rs && $rs->num_rows > 0) {
            $fila = $rs->fetch_assoc();
            $result = new Empresa($fila['nombre_empresa'], $fila['email'], $fila['contrasena']);
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
    
    private static function hashPassword($contrasena) {
        return password_hash($contrasena, PASSWORD_DEFAULT);
    }

    public static function insertaEmpresa($empresa) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO EMPRESA (nombre_empresa, email, contrasena) VALUES ('%s', '%s', '%s', '%s')",
            $conn->real_escape_string($empresa->nombre_empresa),
            $conn->real_escape_string($empresa->email),
            $conn->real_escape_string($empresa->contrasena)
        );

        if ($conn->query($query)) {
            $empresa->id = $conn->insert_id;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $empresa;
    }
    
    public static function actualizaEmpresa($empresa) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE EMPRESA E SET nombre_empresa = '%s',  email='%s', password='%s' WHERE E.id_empresa=%d"
            , $conn->real_escape_string($empresa->nombre_empresa)
            , $conn->real_escape_string($empresa->email)
            , $conn->real_escape_string($empresa->password)
            , $empresa->id
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $empresa;
    }
   
    public static function borraEmpresa($empresa) {
        if ($empresa->id !== null) {
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("DELETE FROM Empresa WHERE id_empresa = %d", $empresa->id);
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    private $id;
    private $nombre_empresa;
    private $email;
    private $contrasena;
    public function __construct($nombre_empresa, $email, $contrasena, $id = null) {
        $this->id = $id;
        $this->nombre_empresa = $nombre_empresa;
        $this->email = $email;
        $this->contrasena = $contrasena;
    }
    public function compruebaPassword($contrasena) {
        return password_verify($contrasena, $this->contrasena);
    }
    public function guarda() {
        if ($this->id !== null) {
            return self::actualizaEmpresa($this);
        }
        return self::insertaImpresa($this);
    }
    public function getId() {
        return $this->id;
    }
    public function getNombreEmpresa() {
        return $this->nombre_empresa;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public static function getEmpresa($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Empresa WHERE id_empresa = %d", $id);
        $res = $conn->query($query);
        return $res;
    }
}