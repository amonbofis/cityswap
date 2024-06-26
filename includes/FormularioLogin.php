<?php
namespace es\ucm\fdi\aw;

class FormularioLogin extends Formulario {

    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
    }
    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $nombre_usuario = $datos['nombre_usuario'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre_usuario', 'contrasena'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        <h2>Log In</h2>
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
                <button type="submit" class="btn">Login</button>
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
            $this->errores['contrasena'] = 'La contrasena no puede estar vacío.';
        }

        if (count($this->errores) === 0) {
            $usuario = Usuario::login($nombre_usuario,$contrasena);
            if (!$usuario) {
                $empresa = Empresa::login($nombre_usuario,$contrasena);
                if (!$empresa) {
                    $this->errores[] = "El usuario o el password no coinciden";
                }else{
                    $_SESSION['login'] = true;
                    $_SESSION['nombre'] = $nombre_usuario;
                    $_SESSION['email'] = $empresa->getEmail();
                    $_SESSION['id'] = $empresa->getId();
                    $_SESSION['empresa'] = true; 
                }
            } else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombre_usuario;
                $_SESSION['apellido'] = $usuario->getApellido();
                $_SESSION['email'] = $usuario->getEmail();
                $_SESSION['id'] = $usuario->getId();
            }
        }
    }
}