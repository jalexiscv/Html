<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-04-10 06:51:12
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Episodes\List\table.php]
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
//[models]--------------------------------------------------------------------------------------------------------------
$mepisodes = model('App\Modules\Iris\Models\Iris_Episodes');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/iris";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    "general" => "General",
);
//[build]--------------------------------------------------------------------------------------------------------------
$rows = $mepisodes->get_List($limit, $offset, $search);
$total = ($rows) ? $rows['total'] : 0;

//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("pb-2 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center	align-middle"),
    array("content" => lang("Iris.Episode"), "class" => "text-center	align-middle"),
    array("content" => lang("Iris.Patient"), "class" => "text-center	align-middle"),
    array("content" => lang("Iris.Start_Date"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/iris/episodes';
$count = $offset;

if ($rows && $rows['total'] > 0) {
    foreach ($rows["data"] as $row) {
        if (!empty($row["episode"])) {
            $count++;
            //[links]-------------------------------------------------------------------------------------------------------
            $hrefView = "$component/view/{$row["episode"]}";
            $hrefEdit = "$component/edit/{$row["episode"]}";
            $hrefDelete = "$component/delete/{$row["episode"]}";
            //[buttons]-----------------------------------------------------------------------------------------------------
            $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
            $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
            $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
            $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
            //[etc]---------------------------------------------------------------------------------------------------------
            $bgrid->add_Row(
                array(
                    array("content" => $count, "class" => "text-center align-middle"),
                    array("content" => $row['episode'], "class" => "text-left align-middle"),
                    array("content" => $row['full_name'], "class" => "text-left align-middle"),
                    array("content" => $row['start_date'], "class" => "text-left align-middle"),
                    array("content" => $options, "class" => "text-center align-middle"),
                )
            );
        }
    }
    $content = $bgrid;
} else {
    $content = $bgrid;
    $content .= $bootstrap->get_Alert(array(
        "type" => "warning",
        "title" => lang('Iris_Episodes.list-norecords-title'),
        "message" => lang('Iris_Episodes.list-norecords-message')
    ));
}

//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-grid", array(
    "header-title" => lang('Iris_Episodes.list-title'),
    "header-back" => $back,
    "header-add" => "/iris/episodes/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Iris_Episodes.list-title'), "message" => lang('Iris_Episodes.list-description')),
    "content" => $content,
));
echo($card);
?>
