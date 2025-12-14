<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Intrusions\List\json.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/

//[Uses]----------------------------------------------------------------------------------------------------------------
use App\Libraries\Html\HtmlTag;
use App\Libraries\Authentication;
use Config\Services;

//[Models]--------------------------------------------------------------------------------------------------------------
$mintrusions = model("App\Modules\C4isr\Models\C4isr_Intrusions");
$mprofiles = model("App\Modules\C4isr\Models\C4isr_Profiles");
$mvulnerabilities = model("App\Modules\C4isr\Models\C4isr_Vulnerabilities");


//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');

//[Request]-----------------------------------------------------------------------------
$columns = $request->getGet("columns");
$offset = $request->getGet("offset");
$search = $request->getGet("search");
//[Query]-----------------------------------------------------------------------------
$draw = empty($request->getGet("draw")) ? 1 : $request->getGet("draw");
$limit = empty($request->getGet("limit")) ? 10 : $request->getGet("limit");
$mintrusions = model('App\Modules\C4isr\Models\C4isr_Intrusions');
$intrusions = $mintrusions
    ->where("breach", $oid)
    ->groupStart()
    ->like("intrusion", "%{$search}%")
    ->orLike("vulnerability", "%{$search}%")
    ->groupEnd()
    ->orderBy("created_at", "DESC")
    ->findAll($limit, $offset);
if (!empty($search)) {
    $recordsTotal = $mintrusions
        ->where("breach", $oid)
        ->groupStart()
        ->like("intrusion", "%{$search}%")
        ->orLike("vulnerability", "%{$search}%")
        ->groupEnd()
        ->countAllResults();
} else {
    $recordsTotal = $mintrusions
        ->where("breach", $oid)
        ->countAllResults();
}
//$sql=$model->getLastQuery()->getQuery();
//[Asignations]-----------------------------------------------------------------------------
$data = array();
$iview = HtmlTag::tag('i', array('class' => 'icon far fa-eye'), '');
$icreate = HtmlTag::tag('i', array('class' => 'icon far fa-sparkles'), '');
$ilist = HtmlTag::tag('i', array('class' => 'icon fas fa-list'));
$iedit = HtmlTag::tag('i', array('class' => 'icon far fa-edit'));
$idelete = HtmlTag::tag('i', array('class' => 'far fa-trash'));
$component = '/c4isr/intrusions';
foreach ($intrusions as $intrusion) {
    //[ReQueries]---------------------------------------------------------------------------------------------------------
    $reference = '';
    $vulnerability = $mvulnerabilities->find($intrusion['vulnerability']);
    //print_r($vulnerability);

    if (isset($vulnerability['mail']) && !empty($vulnerability['mail'])) {
        $mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
        $mmails->setTable('c4isr_mails_' . $vulnerability['partition']);
        $mail = $mmails->find($vulnerability['mail']);
        $reference = @$mail['email'];
    } elseif (isset($vulnerability['alias']) && !empty($vulnerability['alias'])) {
        $maliases = model("App\Modules\C4isr\Models\C4isr_Aliases", false);
        $maliases->setTable('c4isr_aliases_' . $vulnerability['partition']);
        $alias = $maliases->find($vulnerability['alias']);
        $reference = @$alias['user'];
    } else {
        $reference = '<i class=\"fa-sharp fa-solid fa-skull-crossbones\"></i>';
    }
    //[Buttons]---------------------------------------------------------------------------------------------------------
    $viewer = "{$component}/view/{$intrusion["intrusion"]}";
    $editor = "{$component}/edit/{$intrusion["intrusion"]}";
    $deleter = "{$component}/delete/{$intrusion["intrusion"]}";
    $lviewer = $bootstrap::get_Link('view', array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => lang("App.View"), 'class' => 'btn-primary'));
    $leditor = $bootstrap::get_Link('edit', array('href' => $editor, 'icon' => ICON_EDIT, 'text' => lang("App.Edit"), 'class' => 'btn-secondary'));
    $ldeleter = $bootstrap::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => lang("App.Delete"), 'class' => 'btn-danger'));
    $options = $bootstrap::get_BtnGroup('options', array("content" => array($leditor, $ldeleter)));
    //[Fields]-----------------------------------------------------------------------------
    $row["intrusion"] = $intrusion["intrusion"];
    $row["partition"] = @$vulnerability["partition"];
    $row["vulnerability"] = $intrusion["vulnerability"];
    $row["breach"] = $intrusion["breach"];
    $row["reference"] = $strings->get_URLDecode($reference);
    $row["password"] = $strings->get_URLDecode($vulnerability["password"]);
    $row["author"] = $intrusion["author"];
    $row["created_at"] = $intrusion["created_at"];
    $row["updated_at"] = $intrusion["updated_at"];
    $row["deleted_at"] = $intrusion["deleted_at"];
    $row["options"] = $options;
    //[Push]-----------------------------------------------------------------------------
    array_push($data, $row);

}
//[Build]-----------------------------------------------------------------------------
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



