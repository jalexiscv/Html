<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-19 21:08:28
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Helpdesk\Views\Conversations\List\json.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

//[Uses]----------------------------------------------------------------------------------------------------------------
use App\Libraries\Html\HtmlTag;
use App\Libraries\Authentication;
use Config\Services;

//[Services]-------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]---------------------------------------------------------------------------------------------------------------
$model = model('App\Modules\Helpdesk\Models\Helpdesk_Conversations');
$mconversations = model('App\Modules\Helpdesk\Models\Helpdesk_Conversations');
$mservices = model('App\Modules\Helpdesk\Models\Helpdesk_Services');
$magents = model('App\Modules\Helpdesk\Models\Helpdesk_Agents');
$musers = model('App\Modules\Helpdesk\Models\Helpdesk_Users');
$mfields = model('App\Modules\Helpdesk\Models\Helpdesk_Users_Fields');
//[Requests]------------------------------------------------------------------------------------------------------------
$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = $request->getGet("search");
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
//[Query]---------------------------------------------------------------------------------------------------------------
$list = $model->get_List($limit, $offset, $search);
$recordsTotal = $model->get_Total($search);
//$sql=$model->getLastQuery()->getQuery();
//[Asignations]---------------------------------------------------------------------------------------------------------
$data = array();
$component = '/helpdesk/conversations';
foreach ($list as $item) {
    if ($musers->has_Permission(safe_get_user(), "helpdesk-conversations-view-all")) {
        $access = true;
    } else {
        $access = false;
    }
    //Debo analizar el servicio al cual fue enviada la conversacion $item["service"]
    //Determinar si yo como usuario activo pertenezco a ese servicio
    $service = $mservices->where("service", $item["service"])->first();
    $user = safe_get_user();
    $axs = $magents->where("user", $user)->where("service", $service["service"])->first();
    $agent_name = "";
    if (is_array($axs) && isset($axs["agent"])) {
        //Se debe determinar si el servicio es de soporte directo o de soporte por area
        if ($service["direct"] == "N") {
            //Si es de soporte no directo, entonces el usuario puede ver todas las conversaciones asociadas al serivicio
            $access = true;
        } else {
            //Si es de soporte directo, entonces el usuario solo puede ver las que le fueron enviadas
            if ($item["agent"] == $user) {
                $access = true;
                $profile = $mfields->get_Profile($item["agent"]);
                $agent_name = $profile["name"];
            }
        }
    }
    if ($access) {
        //[Buttons]---------------------------------------------------------------------------------------------------------
        $viewer = "{$component}/view/{$item["conversation"]}";
        $editor = "{$component}/edit/{$item["conversation"]}";
        $deleter = "{$component}/delete/{$item["conversation"]}";
        $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary'));
        $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'text' => lang("App.Edit"), 'class' => 'btn-secondary'));
        $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
        $options = $bootstrap::get_BtnGroup('options', array('content' => array($lviewer, $ldeleter)));
        $subject = "<b>Asunto</b>: {$item["title"]} <b>Recibido</b>: {$item["created_at"]}";
        $subject .= "<br><b>Descripción</b>: {$item["description"]}";
        $subject .= "<br><b>Servicio(Area)</b>: {$service["name"]}";
        if (!empty($agent_name)) {
            $subject .= "<br><b>Destinatario</b>: {$agent_name}";
        }


        if ($item["status"] == "CLOSED") {
            $subject .= " <b>Estado de la solicitud</b>: <span class=\"rounded-pill badge bg-success\">Cerrada</span>";
        } else {
            $subject .= " <b>Estado de la solicitud</b>: <span class=\"rounded-pill badge bg-danger\">Pendiente</span>";
        }

        //[Fields]----------------------------------------------------------------------------------------------------------
        $row["conversation"] = "<i class=\"fa-light fa-envelope text-danger fa-3x\"></i><small class=\"text-danger\">{$item["conversation"]}</small>";
        if ($item["status"] == "CLOSED") {
            $row["conversation"] = "<i class=\"fa-light fa-envelope-circle-check fa-3x text-success\"></i><small class=\"text-success\">{$item["conversation"]}</small>";
        }
        $row["service"] = $item["service"];
        $row["title"] = $strings->get_URLDecode($item["title"]);
        $row["description"] = $strings->get_URLDecode($item["description"]);
        $row["status"] = $item["status"];
        $row["priority"] = $item["priority"];
        $row['details'] = $subject;
        $row["author"] = $item["author"];
        $row["created_at"] = $item["created_at"];
        $row["updated_at"] = $item["updated_at"];
        $row["deleted_at"] = $item["deleted_at"];
        $row["options"] = $options;
        //[Push]------------------------------------------------------------------------------------------------------------
        array_push($data, $row);
    }
}
//[Build]---------------------------------------------------------------------------------------------------------------
$json["draw"] = $draw;
$json["columns"] = $columns;
$json["offset"] = $offset;
$json["search"] = $search;
$json["limit"] = $limit;
//$json["sql"] = $sql;
$json["total"] = $recordsTotal;
$json["data"] = $data;
echo(json_encode($json));
?>