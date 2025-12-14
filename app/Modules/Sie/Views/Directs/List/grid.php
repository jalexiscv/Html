<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-11-26 08:37:47
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Directs\List\table.php]
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
$mdirects = model('App\Modules\Sie\Models\Sie_Directs');
//[vars]----------------------------------------------------------------------------------------------------------------
$back= "/sie/tools/home/".lpk();
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
		 //"direct" => lang("App.direct"),
		 //"title" => lang("App.title"),
		 //"content" => lang("App.content"),
		 //"href" => lang("App.href"),
		 //"target" => lang("App.target"),
		 //"author" => lang("App.author"),
		 //"created_at" => lang("App.created_at"),
		 //"updated_at" => lang("App.updated_at"),
		 //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mdirects->clear_AllCache();
$rows = $mdirects->getCachedSearch($conditions,$limit, $offset,"direct DESC");
$total = $mdirects->getCountAllResults($conditions);
//echo(safe_dump($rows['sql']));
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
		array("content" => "#", "class" => "text-center	align-middle"),
		 array("content" => "Enlace", "class" => "text-center	align-middle"),
		 array("content" => lang("App.Title"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.content"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.href"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.target"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
		array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/directs';
$count = $offset;
foreach ($rows["data"] as $row) {
		if(!empty($row["direct"])){
				$count++;
				//[links]-------------------------------------------------------------------------------------------------------
				$hrefView="$component/view/{$row["direct"]}";
				$hrefEdit="$component/edit/{$row["direct"]}";
				$hrefDelete="$component/delete/{$row["direct"]}";
				//[buttons]-----------------------------------------------------------------------------------------------------
				$btnView = $bootstrap->get_Link("btn-view", array("size" => "sm","icon" => ICON_VIEW,"title" => lang("App.View"),"href" =>$hrefView,"class" => "btn-primary ml-1",));
				$btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm","icon" => ICON_EDIT,"title" => lang("App.Edit"),"href" =>$hrefEdit,"class" => "btn-warning ml-1",));
				$btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm","icon" => ICON_DELETE,"title" => lang("App.Delete"),"href" =>$hrefDelete,"class" => "btn-danger ml-1",));
				$options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView.$btnEdit.$btnDelete));
				//[etc]---------------------------------------------------------------------------------------------------------
				$bgrid->add_Row(
						array(
								array("content" => $count, "class" => "text-center align-middle"),
								array("content" => $row['direct'], "class" => "text-left align-middle"),
								array("content" => $row['title'], "class" => "text-left align-middle"),
								 //array("content" => $row['content'], "class" => "text-left align-middle"),
								 //array("content" => $row['href'], "class" => "text-left align-middle"),
								 //array("content" => $row['target'], "class" => "text-left align-middle"),
								 //array("content" => $row['author'], "class" => "text-left align-middle"),
								 //array("content" => $row['created_at'], "class" => "text-left align-middle"),
								 //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
								 //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
								array("content" => $options, "class" => "text-center align-middle"),
						)
				);
		}
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-grid", array(
		"header-title" =>lang('Sie_Directs.list-title'),
		"header-back" => $back,
		"header-add"=>"/sie/directs/create/" . lpk(),
		"alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Sie_Directs.list-title'), "message" => lang('Sie_Directs.list-description')),
		"content" => $bgrid,
));
echo($card);
?>
