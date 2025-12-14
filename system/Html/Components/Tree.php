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
/**
 * Representa el árbol entero y maneja la construcción y renderización del mismo.
 * Esta clase utiliza instancias de TreeNode para construir la estructura del árbol
 * y proporciona un método para generar un marcado HTML que representa visualmente
 * el árbol utilizando Bootstrap 5.
 */
class Tree
{
    /**
     * El nodo raíz del árbol.
     * @var TreeNode
     */
    protected TreeNode $root;


    /**
     * Constructor de la clase Tree.
     * @param TreeNode $root El nodo que actuará como raíz del árbol.
     */
    public function __construct(TreeNode $root)
    {
        $this->root = $root;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Genera el marcado HTML para representar el árbol o subárbol especificado.
     *
     * Este método es recursivo, llamándose a sí mismo para cada nodo hijo, permitiendo así generar la
     * estructura completa del árbol. Genera una estructura de listas y tarjetas de Bootstrap para cada nodo.
     *
     * @param TreeNode|null $node El nodo actual que se está procesando. Si es null, se utiliza el nodo raíz.
     * @param bool $isRoot Indica si el nodo actual es el nodo raíz del árbol.
     * @return string El marcado HTML generado para el árbol o subárbol.
     */
    public function render(TreeNode $node = null, bool $isRoot = true): string
    {
        if ($node === null) {
            $node = $this->root;
        }
        $html = "";
        if ($isRoot) {
            $html .= "<div class='container easy-tree'>";
        }
        $html .= "<ul><li class=\"" . (!$isRoot ? " parent_li" : "") . " w-100\">";

        $html .= "\t <span class=\"w-100\">\n";
        //$html .= "\t\t <span class=\"fa-light fa-folder\"></span>\n";
        $html .= "\t\t <span class=\"title\">{$node->title}: </span>\n";
        $html .= $node->value;
        $html .= "\t </span>\n";

        foreach ($node->children as $child) {
            $html .= $this->render($child, false);
        }

        $html .= "</li></ul>";

        if ($isRoot) {
            $html .= "</div>";
        }

        return $html;
    }

}