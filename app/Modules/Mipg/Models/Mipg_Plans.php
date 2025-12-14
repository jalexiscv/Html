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

namespace App\Modules\Mipg\Models;

use App\Modules\Plans\Models\Plans_Plans;

/**
 * Ej: $mplans = model('App\Modules\Mipg\Models\Mipg_Plans');
 * @method where(mixed $primaryKey, string $id) : \Higgs\Database\BaseBuilder
 * @method groupStart() : \Higgs\Database\BaseBuilder
 */
class Mipg_Plans extends Plans_Plans
{
    /**
     * Obtiene una lista de registros con un rango especificado y opcionalmente filtrados por un término de búsqueda.
     * con opciones de filtrado y paginación.
     * @param int $limit El número máximo de registros a obtener por página.
     * @param int $offset El número de registros a omitir antes de comenzar a seleccionar.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return array|false        Un arreglo de registros combinados o false si no se encuentran registros.
     */
    public function get_ListByActivity($activity, int $limit, int $offset, string $search = ""): array|false
    {
        $result = $this
            ->where("activity", $activity)
            ->groupStart()
            ->like("plan", "%{$search}%")
            ->orLike("plan_institutional", "%{$search}%")
            ->orLike("manager", "%{$search}%")
            ->orLike("manager_subprocess", "%{$search}%")
            ->orLike("manager_position", "%{$search}%")
            ->orLike("order", "%{$search}%")
            ->orLike("description", "%{$search}%")
            ->orLike("formulation", "%{$search}%")
            ->orLike("value", "%{$search}%")
            ->orLike("start", "%{$search}%")
            ->orLike("end", "%{$search}%")
            ->orLike("evaluation", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->orderBy("created_at", "DESC")
            ->findAll($limit, $offset);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * @param $activity
     * @return array|false
     */
    public function get_LastPlan($activity): array|false
    {
        $result = $this
            ->where("activity", $activity)
            ->orderBy("created_at", "DESC")
            ->first();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Obtiene el número total de registros que coinciden con un término de búsqueda.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int Devuelve el número total de registros que coinciden con el término de búsqueda.
     */
    function get_TotalByActivity($activity, string $search = ""): int
    {
        $result = $this
            ->where("activity", $activity)
            ->groupStart()
            ->orLike("plan_institutional", "%{$search}%")
            ->orLike("activity", "%{$search}%")
            ->orLike("manager", "%{$search}%")
            ->orLike("manager_subprocess", "%{$search}%")
            ->orLike("manager_position", "%{$search}%")
            ->orLike("order", "%{$search}%")
            ->orLike("description", "%{$search}%")
            ->orLike("formulation", "%{$search}%")
            ->orLike("value", "%{$search}%")
            ->orLike("start", "%{$search}%")
            ->orLike("end", "%{$search}%")
            ->orLike("evaluation", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->countAllResults();
        return ($result);
    }


}

?>