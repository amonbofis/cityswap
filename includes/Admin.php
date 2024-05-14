<?php
namespace es\ucm\fdi\aw;

class Admin {
    
    public static function login($nombre_usuario, $contrasena) {
        $result = static::buscaUsuario($nombre_usuario);
        $usuario = $result;
        if ($usuario && $usuario->compruebaPassword($contrasena)) {
            return $usuario;
        }
        return false;
    }

    public static function creaUsuario($nombre_usuario, $email, $contrasena) {
        // Creamos una instancia de Usuario con los datos proporcionados
        $usuario = new Admin($nombre_usuario, $email, self::hashPassword($contrasena));
        // Insertamos el usuario en la base de datos
        return self::insertaUsuario($usuario);
    }

    public static function buscaUsuario($nombre_usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = false;
        
        $query = sprintf("SELECT * FROM Administrador WHERE nombre_usuario='%s'", $conn->real_escape_string($nombre_usuario));
        $rs = $conn->query($query);
        
        if ($rs && $rs->num_rows > 0) {
            $fila = $rs->fetch_assoc();
            $result = new Admin($fila['nombre_usuario'],  $fila['email'], $fila['contrasena'], $fila['id']);
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
    
    private static function hashPassword($contrasena) {
        return password_hash($contrasena, PASSWORD_DEFAULT);
    }

    private static function insertaUsuario($usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO ADMINISTRADOR (nombre_usuario, email, contrasena) VALUES ('%s', '%s', '%s')",
            $conn->real_escape_string($usuario->getNombreUsuario()),
            $conn->real_escape_string($usuario->getEmail()),
            $conn->real_escape_string($usuario->getContrasena())
        );

        if ($conn->query($query)) {
            $usuario->setId($conn->insert_id);
            return $usuario;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    // Getters y Setters
    private $id;
    private $nombre_usuario;
    private $email;
    private $contrasena;

    public function __construct($nombre_usuario, $email, $contrasena, $id = null) {
        $this->id = $id;
        $this->nombre_usuario = $nombre_usuario;
        $this->email = $email;
        $this->contrasena = $contrasena;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombreUsuario($nombre_usuario) {
        $this->nombre_usuario = $nombre_usuario;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function getNombreUsuario() {
        return $this->nombre_usuario;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function compruebaPassword($contrasena) {
        return password_verify($contrasena, $this->contrasena);
    }

    public function guarda() {
        if ($this->id !== null) {
            return self::actualizaUsuario($this);
        }
        return self::insertaUsuario($this);
    }

    public function getId() {
        return $this->id;
    }
}
?>
