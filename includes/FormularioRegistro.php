<?php
namespace es\ucm\fdi\aw;

class FormularioRegistro extends Formulario {

    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => 'index.php']);
    }

    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $nombre_usuario = $datos['nombre_usuario'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre_usuario', 'contrasena', 'email'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        <h2>Registro</h2>
        $htmlErroresGlobales
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" required value="$nombre_usuario">
                {$erroresCampos['nombre_usuario']}
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="contrasena" name="contrasena" required >
                {$erroresCampos['contrasena']}
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required >
                {$erroresCampos['email']}
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Register</button>
            </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $nombre_usuario = trim($datos['nombre_usuario'] ?? '');
        $nombre_usuario = filter_var($nombre_usuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre_usuario || empty($nombre_usuario) ) {
            $this->errores['nombre_usuario'] = 'El nombre de usuario no puede estar vacío';
        }

        $contrasena = trim($datos['contrasena'] ?? '');
        $contrasena = filter_var($contrasena, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $contrasena || empty($contrasena) ) {
            $this->errores['contrasena'] = 'La contraseña no puede estar vacía';
        }

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if ( ! $email || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errores['email'] = 'El email proporcionado no es válido';
        }

        if (count($this->errores) === 0) {
            $usuario = Usuario::creaUsuario($nombre_usuario, '', $email, $contrasena);
            if ($usuario) {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombre_usuario;
                $_SESSION['email'] = $email;
                header('Location: index.php');
                exit;
            } else {
                $this->errores[] = "Ha ocurrido un error al crear el usuario. Por favor, inténtalo de nuevo más tarde.";
            }
        }
    }
}
?>
