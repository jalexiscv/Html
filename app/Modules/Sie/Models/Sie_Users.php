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

namespace App\Modules\Sie\Models;

use App\Modules\Security\Models\Security_Users;

/**
 *
 */
class Sie_Users extends Security_Users
{


    public function get_TeacherPhoto($teacher)
    {
        $avatar = "/themes/assets/images/profile-portrait.png";
        $mattachments = model('App\Modules\Sie\Models\Sie_Attachments');
        $avatar = $mattachments->get_Avatar($teacher);
        $src = cdn_url($avatar);
        return ($src);
    }


    /**
     * Obtiene todos los usuarios con el perfil de 'TEACHER'.
     *
     * Este método realiza una consulta a la base de datos para encontrar todos los usuarios
     * que tienen un campo 'type' con el valor 'TEACHER' en la tabla `security_users_fields`.
     * Devuelve un array de arrays asociativos con los datos de los usuarios encontrados o `false` si no hay resultados.
     *
     * @return array|false Un array de arrays asociativos con los usuarios o `false` si no se encuentran coincidencias.
     */
    public function get_Teachers(): array|false
    {
        $result = $this->select('security_users_fields.name, security_users_fields.value, security_users.user, security_users.created_at')
            ->join('security_users_fields', 'security_users.user = security_users_fields.user')
            ->where('security_users_fields.name', 'type')
            ->where('security_users_fields.value', 'TEACHER')
            ->where('security_users.created_at IS NOT NULL')
            ->groupBy(['security_users_fields.name', 'security_users_fields.value', 'security_users.user', 'security_users.created_at'])
            ->get()
            ->getResultArray();

        if (empty($result)) {
            return false;
        }
        return $result;
    }


}

?>