<?php
namespace es\ucm\fdi\aw;

class FormularioNewViaje extends Formulario {

    public function __construct() {
        parent::__construct('formNewViaje', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos) {
        // Reutiliza los valores introducidos previamente o deja los campos en blanco
        $ciudad_origen = $datos['ciudad_origen'] ?? '';
        $ciudad_destino = $datos['ciudad_destino'] ?? '';
        $fecha_inicio = $datos['fecha_inicio'] ?? '';
        $fecha_final = $datos['fecha_final'] ?? '';
        $precio = $datos['precio'] ?? '';

        // Genera mensajes de error si existen
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['ciudad_origen', 'ciudad_destino', 'fecha_inicio', 'fecha_final', 'precio'], $this->errores, 'span', array('class' => 'error'));

        // Genera el HTML de los campos del formulario y los mensajes de error
        $html = <<<EOF
        <h2>Añadir Viaje</h2>
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
                <label for="precio">Precio (en euro):</label>
                <input type="number" id="precio" name="precio" required value="$precio">
                {$erroresCampos['precio']}
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Añadir Viaje</button>
            </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        // Obtén los datos del formulario
        $ciudad_origen = trim($datos['ciudad_origen'] ?? '');
        $ciudad_destino = trim($datos['ciudad_destino'] ?? '');
        $fecha_inicio = $datos['fecha_inicio'] ?? '';
        $fecha_final = $datos['fecha_final'] ?? '';
        $currentDate = date('Y-m-d');
        $precio = $datos['precio'] ?? '';
        // Suponiendo que el ID de la empresa está almacenado en la sesión
        $empresaActual = Empresa::buscaEmpresa($_SESSION['nombre']);
        
        $id_empresa = $empresaActual->getId();
        

        // Validar los datos
        if (empty($ciudad_origen)) {
            $this->errores['ciudad_origen'] = 'El campo Ciudad de origen es obligatorio.';
        }

        if (empty($ciudad_destino)) {
            $this->errores['ciudad_destino'] = 'El campo Ciudad de destino es obligatorio.';
        }

        if (empty($fecha_inicio)) {
            $this->errores['fecha_inicio'] = 'El campo Fecha de inicio es obligatorio.';
        } elseif ($fecha_inicio < $currentDate) {
            $this->errores['fecha_inicio'] = 'La fecha de inicio debe ser posterior a la fecha actual.';
        }

        if (empty($fecha_final)) {
            $this->errores['fecha_final'] = 'El campo Fecha de fin es obligatorio.';
        } elseif ($fecha_final <= $fecha_inicio) {
            $this->errores['fecha_final'] = 'La fecha de fin debe ser posterior a la fecha de inicio.';
        }

        if (empty($precio)) {
            $this->errores['precio'] = 'El campo precio es obligatorio, supongo que no quieres trabajar sin estar pagado.';
        }

        // Si no hay errores, añade el viaje a la base de datos
        if (empty($this->errores)) {
            $viaje = Viaje::creaViaje($id_empresa, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final, $precio, 1);
            if (!$viaje) {
                $this->errores[] = 'Error al añadir el viaje.';
            }
        }
    }
}
?>
