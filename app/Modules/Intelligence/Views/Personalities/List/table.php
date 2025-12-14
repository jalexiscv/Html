<?php
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$request = service('Request');
//[models]--------------------------------------------------------------------------------------------------------------
$mias = model('App\Modules\Intelligence\Models\Intelligence_Ias');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie/enrollments/home/" . lpk();
$offset = !empty($request->getGet("offset")) ? $request->getGet("offset") : 0;
$search = !empty($request->getGet("search")) ? $request->getGet("search") : "";
$field = !empty($request->getGet("field")) ? $request->getGet("field") : "";
$limit = !empty($request->getGet("limit")) ? $request->getGet("limit") : 0;
$fields = [
    'ia' => 'Inteligencia',
    'name' => 'Nombres',
    'option' => 'Opciones',
];
$query = $mias->get_CachedSearch(array(), $limit, $offset, 'name', 1);
$rows = $query['data'];
$total = $query['total'];
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center  align-middle"),
    array("content" => lang("Intelligence_Ias.intelligence"), "class" => "text-center align-middle"),
    array("content" => lang("App.Name"), "class" => "text-left align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center  align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$count = 0;
foreach ($rows as $row) {
    $count++;
    $href["view"] = "/intelligence/personalities/view/{$row['ia']}";
    $href["edit"] = "/intelligence/personalities/edit/{$row['ia']}";
    $href["delete"] = "/intelligence/personalities/delete/{$row['ia']}";
    $btnview = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $href["view"], "class" => "btn-primary ml-1",));
    $btnedit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Delete"), "href" => $href["edit"], "class" => "btn-secondary ml-1",));
    $btndelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $href["delete"], "class" => "btn-danger ml-1",));
    $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnview . $btnedit . $btndelete));
    $bgrid->add_Row(
        array(
            array("content" => $count, "class" => "text-center align-middle"),
            array("content" => $row['ia'], "class" => "text-center align-middle"),
            array("content" => $row['name'], "class" => "text-left  align-middle"),
            array("content" => $options, "class" => "text-center align-middle"),
        )
    );
}
//[card]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Intelligence_Ias.list-personalities-title'),
    "header-back" => $back,
    //"header-add"=>"/sie/enrollments/create/" . lpk(),
    "content" => $bgrid,
));
echo($card);
?>