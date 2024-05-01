<?php
namespace es\ucm\fdi\aw;
class Usuario {
    
    public static function login($nombre_usuario, $contrasena) {
        $result = static::buscaUsuario($nombre_usuario);
        $usuario = $result;
        if ($usuario && $usuario->compruebaPassword($contrasena)) {
            return $usuario;
        }
        return false;
    }
    public static function creaUsuario( $nombre_usuario, $apellido, $email, $contrasena) {
        $user = new Usuario($nombre_usuario, $apellido, $email, self::hashPassword($contrasena));
        return $user->guarda();
    }
    public static function buscaUsuario($nombre_usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = false;
        
        $query = sprintf("SELECT * FROM USUARIO WHERE nombre_usuario='%s'", $conn->real_escape_string($nombre_usuario));
        $rs = $conn->query($query);
        
        if ($rs && $rs->num_rows > 0) {
            $fila = $rs->fetch_assoc();
            $result = new Usuario($fila['nombre_usuario'], $fila['apellido'], $fila['email'], $fila['contrasena'],  $fila['id']);
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
    
    private static function hashPassword($contrasena) {
        return password_hash($contrasena, PASSWORD_DEFAULT);
    }

    public static function insertaUsuario($usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO USUARIO (nombre_usuario, apellido, email, contrasena) VALUES ('%s', '%s', '%s', '%s')",
            $conn->real_escape_string($usuario->nombre_usuario),
            $conn->real_escape_string($usuario->apellido),
            $conn->real_escape_string($usuario->email),
            $conn->real_escape_string($usuario->contrasena)
        );

        if ($conn->query($query)) {
            $usuario->id = $conn->insert_id;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }
    
    public static function actualizaUsuario($usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Usuario U SET nombre_usuario = '%s', apellido = '%s', email='%s', password='%s' WHERE U.id=%d"
            , $conn->real_escape_string($usuario->nombre_usuario)
            , $conn->real_escape_string($usuario->apellido)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->password)
            , $usuario->id
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }
   
    public static function borraUsuario($usuario) {
        if ($usuario->id !== null) {
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("DELETE FROM Usuario WHERE id = %d", $usuario->id);
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
    private $nombre_usuario;
    private $apellido;
    private $email;
    private $contrasena;
    public function __construct($nombre_usuario, $apellido, $email, $contrasena, $id = null) {
        $this->id = $id;
        $this->nombre_usuario = $nombre_usuario;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->contrasena = $contrasena;
    }
    public function compruebaPassword($contrasena) {
        return password_verify($contrasena, $this->contrasena);
    }
    public function guarda() {
        if ($this->id !== null) {
            return static::actualiza($this);
        }
        return static::inserta($this);
    }
    public function getId() {
        return $this->id;
    }
    public function getNombreUsuario() {
        return $this->nombre_usuario;
    }
    public function getApellido() {
        return $this->apellido;
    }
    public function getEmail() {
        return $this->email;
    }
}