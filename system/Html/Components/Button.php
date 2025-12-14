<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

namespace App\Libraries\Html\Bootstrap;

use App\Libraries\Html\HtmlTag;
use App\Libraries\Html\Html;
use InvalidArgumentException;

/**
 * Clase que genera un mensaje de alerta personalizado utilizando atributos.
 * @see https://getbootstrap.com/docs/5.0/components/alerts/
 * @see https://github.com/jalexiscv/Snipes/blob/master/Libraries/Bootstrap/Alerts/Info.php
 * @param array $attributes Un conjunto de atributos para personalizar la alerta.
 * @return string una cadena de texto correspondiente al mensaje de alerta personalizado.
 * @throws InvalidArgumentException Si el tipo de alerta no es uno de los tipos válidos.
 */
class Button
{
    private array $items = [];
    private string $id;
    private string $type;
    private string $content;
    private string $class;


    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->id = $this->get_Attribute($attributes, 'id', "", true);
        $this->type = $this->get_Attribute($attributes, 'type', "", true);
        $this->content = $this->get_Attribute($attributes, 'content', "", true);
        $this->class = $this->get_Attribute($attributes, 'class', "", true);
    }

    /**
     * Este método devuelve el valor del atributo especificado por el parámetro $name.
     * Si el atributo no está presente en el array $this->attributes, devuelve el valor
     * predeterminado proporcionado en el parámetro $default.
     * @param $attributes
     * @param string $key El nombre del atributo cuyo valor se desea obtener.
     * @param mixed $default El valor predeterminado que se devuelve si el atributo no está presente.
     * @param bool $required Si se establece en true, se lanzará una excepción si el atributo no está presente.
     * @return mixed El valor del atributo si está presente, de lo contrario, el valor predeterminado.
     * @note En esta versión del método, hemos utilizado el operador de fusión nula ??, que devuelve el valor del
     * atributo si está presente, y el valor predeterminado si no lo está. Esto simplifica aún más el código y hace
     * que sea más legible. Además, se han agregado tipos de argumento y retorno al método.
     */
    private function get_Attribute($attributes, string $key, mixed $default, bool $required): mixed
    {
        if (isset($attributes[$key])) {
            if (is_string($attributes[$key])) {
                $return = trim($attributes[$key]);
            } elseif (is_array($attributes[$key])) {
                $return = $attributes[$key];
            } else {
                $return = $attributes[$key];
            }
            return ($return);
        } else {
            if ($required) {
                throw new InvalidArgumentException("El atributo '$key' es obligatorio.");
            } else {
                return ($default);
            }
        }
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'b' con el contenido especificado.
     * @param array $args Un array asociativo que contiene los atributos de la etiqueta 'a'.
     * @return string La instancia de Tag representando una etiqueta HTML 'b' con los atributos especificados.
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'b' con el contenido especificado.
     * @return string
     */
    public function render(): string

    {
        $type = $this->type;
        $content = $this->content;
        $class = $this->class;
        $id = $this->id;
        $button = Html::get_Button(array('type' => $type, 'id' => $id, 'class' => $class, 'content' => $content));
        return ($button);
    }


}

?>