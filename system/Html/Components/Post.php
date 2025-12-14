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
class Post
{
    public string $post;
    public string $title;
    public string $description;
    public string $content;
    public string $cover;
    public string $semantic;
    public string $type;
    public string $author;
    public string $alias;
    public string $date;
    public string $time;
    public string $keywords;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        $this->post = $this->get_Attribute($attributes, "post", "", true);
        $title = $this->get_Attribute($attributes, "title", "", true);
        $description = $this->get_Attribute($attributes, "description", "Sin descripción", true);
        $content = $this->get_Attribute($attributes, "content", "", true);
        $cover = $this->get_Attribute($attributes, "cover", "", true);
        $this->semantic = $this->get_Attribute($attributes, "semantic", "", true);
        $this->type = $this->get_Attribute($attributes, "type", "", false);
        $this->author = $this->get_Attribute($attributes, "author", "", true);
        $alias = $this->get_Attribute($attributes, "alias", "", true);
        $this->date = $this->get_Attribute($attributes, "date", "", true);
        $this->time = $this->get_Attribute($attributes, "time", "", true);
        $this->keywords = $this->get_Attribute($attributes, "keywords", "", true);
        //[sets]--------------------------------------------------------------------------------------------------------
        $this->set_Title($title);
        $this->set_Description($description);
        $this->set_Content($content);
        $this->set_Alias($alias);
        $this->set_Cover($cover);
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
     * Permite establecer el valor del atributo title.
     * @param $title
     * @return void
     */
    public function set_Title($title): void
    {
        $strings = service('strings');
        $this->title = $strings->get_URLDecode($title);
    }

    /**
     * Permite establecer el valor del atributo description.
     * @param $title
     * @return void
     */
    public function set_Description($description): void
    {
        $strings = service('strings');
        $description = $strings->get_URLDecode($description);
        $this->description = $description;
    }

    /**
     * Permite establecer el valor del atributo content.
     * @param $title
     * @return void
     */
    public function set_Content($content): void
    {
        $strings = service('strings');
        $this->content = $strings->get_URLDecode($content);
    }

    /**
     * Permite establecer el valor del atributo alias.
     * @param $title
     * @return void
     */
    public function set_Alias($alias): void
    {
        $strings = service('strings');
        $this->alias = $strings->get_URLDecode($alias);
    }

    private function set_Cover($cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $dates = service('dates');
        $daterfc822 = $dates->get_DateRFC822($this->date, $this->time);
        $code = "\n<!--[post]//-->";
        $code .= "\t<div class=\"card h-100\">\n";
        $code .= "\t\t<a href=\"/social/semantic/post/{$this->semantic}.html\">\n";
        $code .= "\t\t\t<img width=\"300\" height=\"225\" src=\"{$this->cover}\" class=\"card-img-top wp-post-image\" alt=\"page-post-default\">\n";
        $code .= "\t\t</a>\n";
        $code .= "\t\t<div class=\"card-body d-flex flex-column\">\n";
        //$code .= "\t\t\t<p class=\"category-badge\">\n";
        //$code .= "\t\t\t\t<a href=\"https://bootscore.me/archives/category-default/\" class=\"badge bg-primary-subtle text-primary-emphasis text-decoration-none\">Default</a>\n";
        //$code .= "\t\t\t\t<a href=\"https://bootscore.me/archives/equal-height/\" class=\"badge bg-primary-subtle text-primary-emphasis text-decoration-none\">Equal Height</a>\n";
        //$code .= "\t\t\t\t<a href=\"https://bootscore.me/archives/equal-height-sidebar-right/\" class=\"badge bg-primary-subtle text-primary-emphasis text-decoration-none\">Equal Height Sidebar Right</a>\n";
        //$code .= "\t\t\t\t<a href=\"https://bootscore.me/archives/masonry/\" class=\"badge bg-primary-subtle text-primary-emphasis text-decoration-none\">Masonry</a>\n";
        //$code .= "\t\t\t\t<a href=\"https://bootscore.me/archives/sidebar-left/\" class=\"badge bg-primary-subtle text-primary-emphasis text-decoration-none\">Sidebar Left</a>\n";
        //$code .= "\t\t\t</p>\n";
        $code .= "\t\t\t<a class=\"text-body text-decoration-none\" href=\"/social/semantic/post/{$this->semantic}.html\">\n";
        $code .= "\t\t\t\t<h2 class=\"blog-post-title h5\">{$this->title}</h2>\n";
        $code .= "\t\t\t</a>\n";
        $code .= "\t\t\t<p class=\"meta small mb-2 text-body-secondary\">\n";
        $code .= "\t\t\t\t<span class=\"posted-on\">\n";
        $code .= "\t\t\t\t\t<span rel=\"bookmark\">\n";
        $code .= "\t\t\t\t\t\t Publicado el: <time class=\"entry-date published\" datetime=\"{$daterfc822}\">{$this->date}</time>\n";
        $code .= "\t\t\t\t\t</span>\n";
        $code .= "\t\t\t\t</span>\n";
        $code .= "\t\t\t\t<span class=\"byline\"> Por <span class=\"author vcard\">\n";
        $code .= "\t\t\t\t\t\t<a class=\"url fn n\" href=\"/social/users/view/{$this->author}\">@{$this->alias}</a>\n";
        $code .= "\t\t\t\t\t</span>\n";
        $code .= "\t\t\t\t</span>\n";
        $code .= "\t\t\t\t<span class=\"comment-divider\">|</span>\n";
        $code .= "\t\t\t</p>\n";
        $code .= "\t\t\t<p class=\"card-text\">\n";
        $code .= "\t\t\t\t<a class=\"text-body text-decoration-none\" href=\"/social/semantic/post/{$this->semantic}.html\">{$this->description}</a>\n";
        $code .= "\t\t\t</p>\n";
        $code .= "\t\t\t<p class=\"card-text mt-auto\">\n";
        $code .= "\t\t\t\t<a class=\"read-more\" href=\"/social/semantic/post/{$this->semantic}.html\">" . lang("App.Read-More") . "» </a>\n";
        $code .= "\t\t\t</p>\n";
        $code .= "\t\t</div>\n";
        $code .= "\t</div>\n";
        return ($code);
    }
}