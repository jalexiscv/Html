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

class Tabs
{
    private $tabs;

    public function __construct($tabs)
    {
        $this->tabs = $tabs;
    }

    public function __toString()
    {
        $code = "<ul class=\"higgs-tabs nav nav-tabs\" id=\"myTab\" role=\"tablist\">\n";
        $code .= "\t<li class=\"nav-item\" role=\"presentation\">\n";
        foreach ($this->tabs as $tab) {
            $code .= '<li class="nav-item" role="presentation">';
            if (!empty($tab['text'])) {
                $code .= $this->create_Button(array(
                        'id' => @$tab['id'],
                        'text' => @$tab['text'],
                        'active' => @$tab['active'],
                        'class' => @$tab['class']
                    )
                );
            } elseif (!empty($tab['icon'])) {
                $code .= $this->create_Button(array(
                        'id' => @$tab['id'],
                        'icon' => @$tab['icon'],
                        'active' => @$tab['active'],
                        'class' => @$tab['class']
                    )
                );
            }
            $code .= '</li>';
        }
        $code .= "</ul>\n";
        $code .= "<div class=\"tabs-tabs-content tab-content p-3 \" id=\"myTabContent\">\n";
        foreach ($this->tabs as $tab) {
            $code .= $this->create_TabPane($tab['id'], $tab['content'], $tab['active']);
        }
        $code .= "</div>\n";
        $code .= $this->_JS();
        return $code;
    }

    /**
     * Esta función crea un botón de pestaña. Se le pasa el id, el texto y si está activo o no.
     * @param $id
     * @param $text
     * @param $active
     * @return string
     */
    private function create_Button($attributes): string
    {
        $active = $attributes['active'] ? 'active' : '';
        $class = isset($attributes['class']) ? $attributes['class'] : '';
        $button = html()::tag('button');
        $button->attr('class', "tabs-nav-link nav-link x {$class} {$active}");
        $button->attr('id', $attributes['id'] . '-tab');
        $button->attr('data-bs-toggle', 'tab');
        $button->attr('data-bs-target', '#' . $attributes['id']);
        $button->attr('type', 'button');
        $button->attr('role', 'tab');
        $button->attr('aria-controls', $attributes['id']);
        $button->attr('aria-selected', $attributes['active'] ? 'true' : 'false');
        if (!empty($attributes['icon'])) {
            $button->content('<i class="' . $attributes['icon'] . '"></i>');
        } else {
            $button->content($attributes['text']);
        }
        return ($button->render());
    }


    /**
     * Esta función crea un panel de pestañas, con el contenido que se le pase.
     * @param $id
     * @param $content
     * @param $active
     * @return string
     */
    private function create_TabPane($id, $content, $active = false): string
    {
        $html = '<div class="tab-pane fade' . ($active ? ' show active' : '') . '" id="' . $id . '" role="tabpanel" aria-labelledby="' . $id . '-tab">' . $content . '</div>';
        return $html;
    }


    public function _JS()
    {
        $code = "<script>\n";
        $code .= "window.addEventListener('load', () => {\n";
        $code .= "\t try {\n";
        $code .= "\t\t var url = window.location.href.split('#').pop();\n";
        $code .= "\t\t console.log(url);document.querySelector('#'+url+'-tab').click();\n";
        $code .= "\t }catch {\n";
        $code .= "\t}\n";
        $code .= "});\n";
        $code .= "</script>\n";
        return ($code);
    }


}

?>