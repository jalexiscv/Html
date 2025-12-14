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

use InvalidArgumentException;

/**
 * Class HtmlTag.
 */
class Shortcut
{
    public string $href;
    public string $icon;
    public string $value;
    public string $description;
    public string $class;
    public string $target;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        $this->href = $this->get_Attribute($attributes, "href", "#", true);
        $this->icon = $this->get_Attribute($attributes, "icon", "icon-home", true);
        $this->value = $this->get_Attribute($attributes, "value", "0", true);
        $this->description = $this->get_Attribute($attributes, "description", "");
        $this->class = $this->get_Attribute($attributes, "class", "");
        $this->target = $this->get_Attribute($attributes, "target", "_self");
    }

    /**
     * Este método devuelve el valor del atributo especificado por el parámetro $name.
     * Si el atributo no está presente en el array $this->attributes, devuelve el valor
     * predeterminado proporcionado en el parámetro $default.
     * @param array $attributes
     * @param string $key
     * @param mixed $default El valor predeterminado que se devuelve si el atributo no está presente.
     * @param bool $required
     * @return mixed El valor del atributo si está presente, de lo contrario, el valor predeterminado.
     * @note En esta versión del método, hemos utilizado el operador de fusión nula ??, que devuelve el valor del
     * atributo si está presente, y el valor predeterminado si no lo está. Esto simplifica aún más el código y hace
     * que sea más legible. Además, se han agregado tipos de argumento y retorno al método.
     */
    private function get_Attribute(array $attributes, string $key, string $default, bool $required = false): string
    {
        if (isset($attributes[$key])) {
            return $attributes[$key];
        } else {
            if ($required) {
                throw new InvalidArgumentException("El atributo '$key' es obligatorio.");
            } else {
                return $default;
            }
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $code = "\n<!--[shortcut]//-->";
        $code .= "<a href=\"$this->href\" class=\"shortcut border w-100\" target=\"$this->target\">";
        $code .= "<div class=\"container-icon $this->class\">";
        $code .= "<i class=\"icon $this->icon\"></i>";
        $code .= "</div>";
        $code .= "<h5>$this->value</h5>";
        if (!empty($this->description)) {
            $code .= "<p>$this->description</p>";
        }
        $code .= "</a>";
        return ($code);
    }
}