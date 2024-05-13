<?php
namespace es\ucm\fdi\aw;
class FormularioReserva extends Formulario {

    private $id_viaje;

    public function __construct($id_viaje) {
        parent::__construct('formReserva', ['urlRedireccion' => 'index.php']);
        $this->id_viaje = $id_viaje;
    }    

    protected function generaCamposFormulario(&$datos) {
        // Obtener datos del usuario actual si está autenticado
        $nombre_usuario = '';
        if (isset($_SESSION['login']) && $_SESSION['login']) {
            $usuarioActual = Usuario::buscaUsuario($_SESSION['nombre']);
            $nombre_usuario = $usuarioActual->getNombreUsuario();
        }

        $id_viaje = $this->id_viaje;

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        $html = <<<EOF
            <h1>Formulario de Reserva</h1>
            $htmlErroresGlobales
            <fieldset>
                <div class="legenda">
                    Datos para la reserva
                </div>
                <div>
                    <label for="nombre_usuario">Nombre de usuario:</label>
                    <input id="nombre_usuario" type="text" name="nombre_usuario" required value="{$nombre_usuario}" readonly>
                </div>
                <input type="hidden" name="id_viaje" value="$id_viaje">
                <div class="boton">
                    <button type="submit">Confirmar Reserva</button>
                </div>
            </fieldset>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        $nombre_usuario = trim($datos['nombre_usuario'] ?? '');
        $id_viaje = $datos['id_viaje'] ?? '';
        
        // Verificar existencia de usuario y viaje
        $usuario = Usuario::buscaUsuario($nombre_usuario);
        if (!$usuario) {
            $this->errores['nombre_usuario'] = "Usuario no existente";
        }
        
        $viaje = Viaje::buscaViajePorId($id_viaje);
        if (!$viaje) {
            $this->errores['id_viaje'] = "Viaje no existente";
        }
        
        // Si no hay errores, crear la reserva
        if (empty($this->errores)) {
            $reserva = Alquiler::crea($usuario->getId(), $viaje->getId());
            
            if ($reserva) {
                
                $viaje->setFree(false);
                return 'index.php';

            } else {
                $this->errores['global'] = "Error al realizar la reserva.";
            }
        }
    }
}
?>
