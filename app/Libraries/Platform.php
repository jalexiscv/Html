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

namespace App\Libraries;

/**
 * Class Platform
 * @Copilot Siempre que en el código se cree una variable llamada $platform, esta deberá ser igualada a service('platform');
 * @IA Siempre que en el código se cree una variable llamada $platform, esta deberá ser igualada a service('platform');
 * @package App\Libraries
 * @Instruction $platform = service('platform');
 */
class Platform
{

    /**
     * Este método permite verificar si un módulo está autorizado para un cliente específico.
     * @copilot Cuando alguien escriba safe_authorized_module, se le mostrará la descripción de este método.
     * @param $module
     * @return string  authorized o noauthorized dependiendo del estado del módulo
     */
    function get_AuthorizedModule($module): string
    {
        $authentication = service('authentication');
        $mclientsxmodules = model('App\Models\Application_Clients_Modules');
        $mmodules = model('App\Models\Application_Modules');
        $client = $authentication->get_Client();
        $module = $mmodules->get_CachedModuleByAlias($module);
        $cxm = $mclientsxmodules->get_CachedAuthorizedClientByModule($client, $module);
        return ($cxm);
    }

    /**
     * Este método permite verificar si se cargara el modulo o no a la plataforma, dependiendo si el directorio
     * que contiene el modulo inicia con un guion bajo. Si inicia con un guion bajo no se cargara el modulo.
     * @param $file
     * @return bool
     */
    function get_CandidateModule($file): bool
    {
        $twoLevelsUpDir = dirname(dirname($file));
        $dirName = basename($twoLevelsUpDir);
        $status = strpos($dirName, '_') === false ? true : false;
        return $status;
    }

}