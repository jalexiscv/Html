<?php


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
$mlocations = model('App\Modules\Sgd\Models\Sgd_Locations');
//[vars]----------------------------------------------------------------------------------------------------------------
$back= "/sgd";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
		 //"location" => lang("App.location"),
		 //"center" => lang("App.center"),
		 //"shelve" => lang("App.shelve"),
		 //"box" => lang("App.box"),
		 //"folder" => lang("App.folder"),
		 //"author" => lang("App.author"),
		 //"date" => lang("App.date"),
		 //"time" => lang("App.time"),
		 //"created_at" => lang("App.created_at"),
		 //"updated_at" => lang("App.updated_at"),
		 //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array();
//$mlocations->clear_AllCache();
$rows = $mlocations->get_CachedSearch($conditions,$limit, $offset,"location DESC");
$total = $mlocations->get_CountAllResults($conditions);
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
		 //array("content" => lang("App.location"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.center"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.shelve"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.box"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.folder"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.date"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.time"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
		 //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
		array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sgd/locations';
$count = $offset;
foreach ($rows["data"] as $row) {
		if(!empty($row["location"])){
				$count++;
				//[links]-------------------------------------------------------------------------------------------------------
				$hrefView="$component/view/{$row["location"]}";
				$hrefEdit="$component/edit/{$row["location"]}";
				$hrefDelete="$component/delete/{$row["location"]}";
				//[buttons]-----------------------------------------------------------------------------------------------------
				$btnView = $bootstrap->get_Link("btn-view", array("size" => "sm","icon" => ICON_VIEW,"title" => lang("App.View"),"href" =>$hrefView,"class" => "btn-primary ml-1",));
				$btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm","icon" => ICON_EDIT,"title" => lang("App.Edit"),"href" =>$hrefEdit,"class" => "btn-warning ml-1",));
				$btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm","icon" => ICON_DELETE,"title" => lang("App.Delete"),"href" =>$hrefDelete,"class" => "btn-danger ml-1",));
				$options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView.$btnEdit.$btnDelete));
				//[etc]---------------------------------------------------------------------------------------------------------
				$bgrid->add_Row(
						array(
								array("content" => $count, "class" => "text-center align-middle"),
								 //array("content" => $row['location'], "class" => "text-left align-middle"),
								 //array("content" => $row['center'], "class" => "text-left align-middle"),
								 //array("content" => $row['shelve'], "class" => "text-left align-middle"),
								 //array("content" => $row['box'], "class" => "text-left align-middle"),
								 //array("content" => $row['folder'], "class" => "text-left align-middle"),
								 //array("content" => $row['author'], "class" => "text-left align-middle"),
								 //array("content" => $row['date'], "class" => "text-left align-middle"),
								 //array("content" => $row['time'], "class" => "text-left align-middle"),
								 //array("content" => $row['created_at'], "class" => "text-left align-middle"),
								 //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
								 //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
								array("content" => $options, "class" => "text-center align-middle"),
						)
				);
		}
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-grid", array(
		"title" =>lang('Locations.list-title'),
		"header-back" => $back,
		"header-add"=>"/sie/q10files/import/" . lpk(),
		"alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Locations.list-title'), "message" => lang('Locations.list-description')),
		"content" => $bgrid,
));
echo($card);
?>
