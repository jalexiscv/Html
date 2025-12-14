<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-02-21 17:36:04
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Units\List\table.php]
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
* █ @link https://www.higgs.com.co
* █ @Version 1.5.1 @since PHP 8,PHP 9
* █ ---------------------------------------------------------------------------------------------------------------------
**/
/**
* @var object $authentication Authentication service from the ModuleController.
* @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
* @var string $component Complete URI to the requested component.
* @var object $dates Date service from the ModuleController.
* @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
* @var object $parent Represents the ModuleController.
* @var object $request Request service from the ModuleController.
* @var object $strings String service from the ModuleController.
* @var string $view String passed to the view defined in the viewer for evaluation.
* @var string $viewer Complete URI to the view responsible for evaluating each requested view.
* @var string $views Complete URI to the module views.
**/
//[models]--------------------------------------------------------------------------------------------------------------
$munits = model('App\Modules\Sgd\Models\Sgd_Units');
//[vars]----------------------------------------------------------------------------------------------------------------
$back= "/sgd";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
		 "general" => "General",
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
	"version" => $oid,
);
//$munits->clear_AllCache();
$rows = $munits->get_CachedSearch($conditions,$limit, $offset,"unit DESC");
$total = $munits->get_CountAllResults($conditions);
//echo(safe_dump($rows['sql']));
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
		array("content" => "#", "class" => "text-center	align-middle text-wrap"),
		array("content" => lang("App.Unit"), "class" => "text-center	align-middle text-wrap"),
		array("content" => lang("App.Reference"), "class" => "text-center	align-middle text-wrap"),
		array("content" => lang("App.Name"), "class" => "text-center	align-middle text-wrap"),
		 //array("content" => lang("App.description"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.owner"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.date"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.time"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
		array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sgd/units';
$count = $offset;
foreach ($rows["data"] as $row) {
		if(!empty($row["unit"])){
				$count++;
				//[links]-------------------------------------------------------------------------------------------------------
				$hrefView="$component/view/{$row["unit"]}";
				$hrefEdit="$component/edit/{$row["unit"]}";
				$hrefDelete="$component/delete/{$row["unit"]}";
				//[buttons]-----------------------------------------------------------------------------------------------------
				$btnView = $bootstrap->get_Link("btn-view", array("size" => "sm","icon" => ICON_VIEW,"title" => lang("App.View"),"href" =>$hrefView,"class" => "btn-primary ml-1",));
				$btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm","icon" => ICON_EDIT,"title" => lang("App.Edit"),"href" =>$hrefEdit,"class" => "btn-warning ml-1",));
				$btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm","icon" => ICON_DELETE,"title" => lang("App.Delete"),"href" =>$hrefDelete,"class" => "btn-danger ml-1",));
				$options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView.$btnEdit.$btnDelete));
				//[etc]---------------------------------------------------------------------------------------------------------
				$bgrid->add_Row(
						array(
								array("content" => $count, "class" => "text-end align-middle text-wrap"),
								 array("content" => $row['unit'], "class" => "text-center align-middle text-wrap"),
								 array("content" => $row['reference'], "class" => "text-center align-middle text-wrap"),
								 array("content" => $row['name'], "class" => "text-start align-middle text-wrap"),
								 //array("content" => $row['description'], "class" => "text-left align-middle"),
								 //array("content" => $row['author'], "class" => "text-left align-middle"),
								 //array("content" => $row['owner'], "class" => "text-left align-middle"),
								 //array("content" => $row['date'], "class" => "text-left align-middle"),
								 //array("content" => $row['time'], "class" => "text-left align-middle"),
								 //array("content" => $row['created_at'], "class" => "text-left align-middle"),
								 //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
								 //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
								array("content" => $options, "class" => "text-center align-middle text-wrap"),
						)
				);
		}
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-grid", array(
		"header-title" =>lang('Sgd_Units.list-title'),
		//"header-back" => $back,
		"header-add"=>"/sgd/units/create/{$oid}",
		//"alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Units.list-title'), "message" => lang('Units.list-description')),
		"content" => $bgrid,
));
echo($card);
?>