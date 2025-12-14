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
 * @package App\Libraries\Html\Bootstrap
 * @version 1.5.0
 * @since PHP 7, PHP 8
 * @see https://getbootstrap.com/docs/5.0/components/list-group/
 * @see https://getbootstrap.com/docs/5.0/components/list-group/#javascript-behavior
 * @see https://getbootstrap.com/docs/5.0/components/list-group/#flush
 * @see https://getbootstrap.com/docs/5.0/components/list-group/#horizontal
 * @see https://getbootstrap.com/docs/5.0/components/list-group/#contextual-classes
 * @see https://getbootstrap.com/docs/5.0/components/list-group/#custom-content
 * @see https://getbootstrap.com/docs/5.0/components/list-group/#with-badges
 * $listGroup = new ListGroup();
 * $listGroup->add_Item(new ListGroupItem('#', 'assets/images/social/facebook.svg', 'Bootstrap Gallery', 'List group item heading', 'Some placeholder content in a paragraph.', 'now'));
 * $listGroup->add_Item(new ListGroupItem('#', 'assets/images/social/linkedin.svg', 'Bootstrap Gallery', 'Another title here', 'Some placeholder content in a paragraph that goes a little longer so it wraps to a new line.', '3d'));
 * $listGroup->add_Item(new ListGroupItem('#', 'assets/images/social/twitter.svg', 'Bootstrap Gallery', 'Third heading', 'Some placeholder content in a paragraph.', '1w'));
 * echo $listGroup->render();
 */
class ListGroup
{
    private array $items = [];
    private string $class;


    public function __construct(array $attributes = [])
    {
        $this->class = $this->get_Attribute($attributes, 'class', "#", false);
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
     *
     * @param ListGroupItem $item
     * @return void
     */
    public function add_Item(ListGroupItem $item): void
    {
        $this->items[] = $item;
    }

    /**
     *
     * @return string
     */
    public function __toString(): string
    {
        $itemsHtml = array_map(fn($item) => $item, $this->items);
        return '<div class="list-group w-auto">' . implode('', $itemsHtml) . '</div>';
    }
}

?>