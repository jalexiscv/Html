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

namespace Higgs\Debug\Toolbar\Collectors;

use Config\Services;

/**
 *
 */
class Caches extends BaseCollector
{
    protected static $items = [];
    protected $hasTimeline = true;
    protected $hasTabContent = true;

    // Contenedor para almacenar los mensajes
    protected $title = 'Caches';

    // Método estático para añadir mensajes al colector

    public static function addMessage(string $action, string $message, string $remaining)
    {
        self::$items[] = array("action" => $action, "message" => $message, "remaining" => $remaining);
    }

    public function display(): string
    {
        // Crea el HTML que será mostrado en la barra de herramientas
        $output = '<table>';
        $output .= '<tr>';
        $output .= "<td>Acción</td>";
        $output .= "<td>Mensaje</td>";
        $output .= "<td>Remanente</td>";
        $output .= '</tr>';
        foreach (self::$items as $item) {
            $remaining = $item['remaining'];
            $output .= '<tr>';
            $output .= "<td>" . esc($item['action']) . "</td>";
            $output .= "<td>" . esc($item['message']) . "</td>";
            if ($remaining >= 3600) {// Más de 3600 segundos en una hora
                $horas = floor($remaining / 3600);
                $time = esc($horas) . " Horas";
            } elseif ($remaining >= 60) {// Más de 60 segundos en un minuto
                $minutos = floor($remaining / 60);
                $time = esc($minutos) . " Minutos";
            } else {// Menos de 60 segundos.
                $time = esc($remaining) . " Segundos";
            }
            $output .= "<td>{$time}</td>";
            $output .= '</tr>';
        }
        $output .= '</table>';
        return $output;
    }

    // Opcionalmente podrías definir el método "getTitleDetails" para proporcionar más información en el título de la pestaña
    public function getTitleDetails(): string
    {
        return '(' . count(self::$items) . ')';
    }

    public function icon(): string
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAADMSURBVEhLY6A3YExLSwsA4nIycQDIDIhRWEBqamo/UNF/SjDQjF6ocZgAKPkRiFeEhoYyQ4WIBiA9QAuWAPEHqBAmgLqgHcolGQD1V4DMgHIxwbCxYD+QBqcKINseKo6eWrBioPrtQBq/BcgY5ht0cUIYbBg2AJKkRxCNWkDQgtFUNJwtABr+F6igE8olGQD114HMgHIxAVDyAhA/AlpSA8RYUwoeXAPVex5qHCbIyMgwBCkAuQJIY00huDBUz/mUlBQDqHGjgBjAwAAACexpph6oHSQAAAAASUVORK5CYII=';
    }

}