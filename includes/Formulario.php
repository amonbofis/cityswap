<?php
namespace es\ucm\fdi\aw;
// Clase base para la gestión de formularios.
 
abstract class Formulario
{

    /**
     * Genera la lista de mensajes de errores globales (no asociada a un campo) a incluir en el formulario.
     *
     * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     *
     * @param string $classAtt (opcional) Valor del atributo class de la lista de errores.
     *
     * @return string El HTML asociado a los mensajes de error.
     */
    protected static function generaListaErroresGlobales($errores = array(), $classAtt = '')
    {
        $clavesErroresGlobales = array_filter(array_keys($errores), function ($elem) {
            return is_numeric($elem);
        });

        $numErrores = count($clavesErroresGlobales);
        if ($numErrores == 0) {
            return '';
        }

        $html = "<ul class=\"$classAtt\">";
        foreach ($clavesErroresGlobales as $clave) {
            $html .= "<li>$errores[$clave]</li>";
        }
        $html .= '</ul>';

        return $html;
    }

    /**
     * Crea una etiqueta para mostrar un mensaje de error. Sólo creará el mensaje de error
     * si existe una clave <code>$idError</code> dentro del array <code>$errores</code>.
     * 
     * @param string[] $errores     (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     * @param string   $idError     (opcional) Clave dentro de <code>$errores</code> del error a mostrar.
     * @param string   $htmlElement (opcional) Etiqueta HTML a crear para mostrar el error.
     * @param array    $atts        (opcional) Tabla asociativa con los atributos a añadir a la etiqueta que mostrará el error.
     */
    protected static function createMensajeError($errores = [], $idError = '', $htmlElement = 'span', $atts = [])
    {
        if (! isset($errores[$idError])) {
            return '';
        }

        $att = '';
        foreach ($atts as $key => $value) {
            $att .= "$key=\"$value\" ";
        }
        $html = "<$htmlElement $att>{$errores[$idError]}</$htmlElement>";

        return $html;
    }

    protected static function generaErroresCampos($campos, $errores, $htmlElement = 'span', $atts = []) {
        $erroresCampos = [];
        foreach($campos as $campo) {
            $erroresCampos[$campo] = self::createMensajeError($errores, $campo, $htmlElement, $atts);
        }
        return $erroresCampos;
    }

    /**
     * @var string Identificador único utilizado para &quot;id&quot; de la etiqueta &lt;form&gt; y para comprobar que se ha enviado el formulario.
     */
    protected $formId;

    /**
     * @var string Método HTTP utilizado para enviar el formulario.
     */
    protected $method;

    /**
     * @var string URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará el 
     * envío del formulario.
     */
    protected $action;

    /**
     * @var string Valor del atributo "class" de la etiqueta &lt;form&gt; asociada al formulario. Si este parámetro incluye la cadena "nocsrf" no se generá el token CSRF para este formulario.
     */
    protected $classAtt;

    /**
     * @var string Valor del parámetro enctype del formulario.
     */
    protected $enctype;

    /**
     * @var string Url a la que redirigir en caso de que el formulario se procese exitosamente.
     */
    protected $urlRedireccion;

    /**
     * @param string[] Array con los mensajes de error de validación y/o procesamiento del formulario.
     */
    protected $errores;

    
    public function __construct($formId, $opciones = array())
    {
        $this->formId = $formId;

        $opcionesPorDefecto = array('action' => null, 'method' => 'POST', 'class' => null, 'enctype' => null, 'urlRedireccion' => null);
        $opciones = array_merge($opcionesPorDefecto, $opciones);

        $this->action = $opciones['action'];
        $this->method = $opciones['method'];
        $this->classAtt = $opciones['class'];
        $this->enctype  = $opciones['enctype'];
        $this->urlRedireccion = $opciones['urlRedireccion'];

        if (!$this->action) {
            $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
        }
    }

    public function gestiona()
    {
        $datos = &$_POST;
        if (strcasecmp('GET', $this->method) == 0) {//just to ensure that we use the good method, but we should be every time in the case of POST 
            $datos = &$_GET;
        }
        $this->errores = [];

        if (!$this->formularioEnviado($datos)) {
            return $this->generaFormulario();
        }

        $this->procesaFormulario($datos);
        $esValido = count($this->errores) === 0;

        if (! $esValido ) {
            return $this->generaFormulario($datos);
        }

        if ($this->urlRedireccion !== null) {
            header("Location: {$this->urlRedireccion}");
            exit();
        }
    }

    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     * 
     * Si el formulario ya ha sido enviado y hay errores en {@see Form::procesaFormulario()} se llama a este método
     * nuevamente con los datos que ha introducido el usuario en <code>$datos</code> y los errores al procesar
     * el formulario en <code>$errores</code>
     *
     * @param string[] &$datos Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
     *
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generaCamposFormulario(&$datos)
    {
        return '';
    }

    /**
     * Procesa los datos del formulario.
     *
     * @param string[] $datos Datos enviado por el usuario.
     *
     */
    protected function procesaFormulario(&$datos)
    {
    }

   
    protected function formularioEnviado(&$datos)
    {
        return isset($datos['formId']) && $datos['formId'] == $this->formId;
    }

    /**
     * Función que genera el HTML necesario para el formulario.
     *
     * @param string[] &$datos (opcional) Array con los valores por defecto de los campos del formulario.
     *
     * @return string HTML asociado al formulario.
     */
    protected function generaFormulario(&$datos = array())
    {
        $htmlCamposFormularios = $this->generaCamposFormulario($datos);

        $classAtt = $this->classAtt != null ? "class=\"{$this->classAtt}\"" : '';

        $enctypeAtt = $this->enctype != null ? "enctype=\"{$this->enctype}\"" : '';

        $htmlForm = <<<EOS
        <form method="{$this->method}" action="{$this->action}" id="{$this->formId}" {$classAtt} {$enctypeAtt}>
            <input type="hidden" name="formId" value="{$this->formId}">
            $htmlCamposFormularios
        </form>
        EOS;
        return $htmlForm;
    }
}
