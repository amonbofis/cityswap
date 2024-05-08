<?php
namespace es\ucm\fdi\aw;

class FormularioNewViaje extends Formulario {

    public function __construct() {
        parent::__construct('formNewViaje', ['urlRedireccion' => 'index.php']);
    }
    protected function generaCamposFormulario(&$datos) {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $ciudad_origen = $datos['ciudad_origen'] ?? '';
        $ciudad_destino = $datos['ciudad_destino'] ?? '';
        $fecha_inicio = $datos['fecha_inicio'] ?? '';
        $fecha_final = $datos['fecha_final'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['ciudad_origen', 'ciudad_destino', 'fecha_inicio', 'fecha_final'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        <h2>Log In</h2>
        $htmlErroresGlobales
            <div class="form-group">
                <label for="ciudad_origen">Ciudad de origen:</label>
                <input type="text" id="ciudad_origen" name="ciudad_origen" required value="$ciudad_origen">
                {$erroresCampos['ciudad_origen']}
            </div>
            <div class="form-group">
                <label for="ciudad_destino">Ciudad de destino:</label>
                <input type="text" id="ciudad_destino" name="ciudad_destino" required value="$ciudad_destino" >
                {$erroresCampos['ciudad_destino']}
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required value="$fecha_inicio">
                {$erroresCampos['fecha_inicio']}
            </div>
            <div class="form-group">
                <label for="fecha_final">Fecha de fin:</label>
                <input type="date" id="fecha_final" name="fecha_final" required value="$fecha_final">
                {$erroresCampos['fecha_final']}
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Crear este alquiler</button>
            </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $ciudad_origen = trim($datos['ciudad_origen'] ?? '');
        $ciudad_origen = filter_var($ciudad_origen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $ciudad_origen || empty($ciudad_origen) ) {
            $this->errores['ciudad_origen'] = 'El nombre de usuario no puede estar vacío';
        }

        $ciudad_destino = trim($datos['ciudad_destino'] ?? '');
        $ciudad_destino = filter_var($ciudad_destino, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $ciudad_destino || empty($ciudad_destino) ) {
            $this->errores['ciudad_destino'] = 'La contrasena no puede estar vacío.';
        }

        $fecha_inicio = $datos['fecha_inicio'];
        $fecha_final = $datos['fecha_final'];
        $currentDate = date('Y-m-d');
        //doesn't work because says $id_empresa is null. how to recover the id from the session?
        $id_empresa = $_SESSION['id'];

        if ($fecha_inicio < $currentDate) {
            $this->errores['fecha_inicio'] = 'La fecha de inicio debe estar mas tarde que hoy.';
        }
    
        if ($fecha_final <= $fecha_inicio) {
            $this->errores['fecha_final'] = 'La fecha de fin debe estar mas tarde que la fecha de inicio.';
        }

        if (count($this->errores) === 0) {
            $alquiler = Alquiler::creaAlquiler($id_empresa, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final);
        }
    }
}