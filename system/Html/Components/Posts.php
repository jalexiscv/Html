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
 * $postsPanel = new Posts();
 * $postsPanel->add(new Post('#', 'shopping-cart2', '2540', 'Items Sold'));
 * $postsPanel->add(new Post('#', 'thumbs-up2', '763', 'Likes'));
 * $postsPanel->add(new Post('#', 'bell3', '218', 'Alerts'));
 * $postsPanel->add(new Post('#', 'location4', '549', 'Locations'));
 * $postsPanel->add(new Post('#', 'archive3', '367', 'Pages'));
 * $postsPanel->add(new Post('#', 'download5', '854', 'Downloads', 'secondary'));
 * echo $postsPanel->toHtml();
 * @package App\Libraries\Html\Bootstrap
 * @version 1.5.0
 * @since PHP 7, PHP 8
 * @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @link https://www.codehiggs.com
 * @Version 1.5.0
 */
class Posts
{

    private array $posts = [];
    private $id;
    private $class;


    public function __construct($attributes = [])
    {
        $this->id = $this->get_Attribute($attributes, 'id', "posts-" . uniqid());
        $this->class = $this->get_Attribute($attributes, 'class', "posts");
    }

    /**
     * Este método devuelve el valor del atributo especificado por el parámetro $name.
     * Si el atributo no está presente en el array $this->attributes, devuelve el valor
     * predeterminado proporcionado en el parámetro $default.
     * @param string $name El nombre del atributo cuyo valor se desea obtener.
     * @param mixed $default El valor predeterminado que se devuelve si el atributo no está presente.
     * @return mixed El valor del atributo si está presente, de lo contrario, el valor predeterminado.
     * @note En esta versión del método, hemos utilizado el operador de fusión nula ??, que devuelve el valor del
     * atributo si está presente, y el valor predeterminado si no lo está. Esto simplifica aún más el código y hace
     * que sea más legible. Además, se han agregado tipos de argumento y retorno al método.
     */
    private function get_Attribute($attributes, $key, $default, $required = false)
    {
        if (isset($attributes[$key])) {
            return $attributes[$key];
        } else {
            if ($required) {
                throw new InvalidArgumentException("El atributo '{$key}' es obligatorio.");
            } else {
                return $default;
            }
        }
    }

    public function add(Post $post)
    {
        $this->posts[] = $post;
    }

    public function __toString(): string
    {
        $html = "<div class=\"row $this->class\">";
        foreach ($this->posts as $post) {
            $html .= "<div class=\"col-md-12 col-lg-6 col-xxl-4 mb-4\">\n";
            $html .= $post;
            $html .= "</div>";
        }
        $html .= "</div>";
        return $html;
    }
}
