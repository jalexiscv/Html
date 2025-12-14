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

namespace App\Modules\Helpdesk\Controllers;

use Higgs\Controller;

/**
 * Clase RouterController
 * Controlador personalizado para implementar un enfoque de enrutamiento "lazy".
 */
class Router extends Controller
{
    /**
     * Método para enrutar las solicitudes de manera dinámica
     * Este método toma dos parámetros de la URL, los trata como el nombre del controlador y el método,
     * y luego intenta llamar a ese método del controlador. Si el controlador o el método no existen,
     * se lanza un error 404.
     * @param string $controller El primer segmento de la URL, tratado como el nombre del controlador.
     * @param string $method El segundo segmento de la URL, tratado como el nombre del método.
     * @return mixed El resultado de llamar al método del controlador.
     * @throws \Higgs\Exceptions\PageNotFoundException Si el controlador o el método no existen.
     */
    public function route($controller, $method)
    {
        // Convierte los nombres de la URL a la convención de nombres de las clases y los métodos
        $module = "Helpdesk";
        $controller = ucfirst($controller);
        $method = strtolower($method);
        // Construye el nombre de clase completo con su espacio de nombres
        $class = "\\App\\Modules\\{$module}\\Controllers\\$controller";
        // Verifica si la clase y el método existen
        if (class_exists($class) && method_exists($class, $method)) {
            // Si existen, crea una nueva instancia de la clase
            $instance = new $class;
            // Obtiene los argumentos adicionales
            $args = array_slice(func_get_args(), 2);
            // Llama al método con los argumentos
            return call_user_func_array([$instance, $method], $args);
        } else {
            // Si no existen, muestra un error 404
            throw \Higgs\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}

?>