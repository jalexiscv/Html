<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:05
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\List\table.php]
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

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[vars]----------------------------------------------------------------------------------------------------------------
//[models]--------------------------------------------------------------------------------------------------------------
$mq10files = model("App\Modules\Sie\Models\Sie_Q10files");
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments', true);
//[request]-------------------------------------------------------------------------------------------------------------
$back = "/sie/tools/home/" . lpk();
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 100;
$fields = [
    'identification' => 'Número de identificación',
];
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    "search" => $search,
);
//$mq10files->clear_AllCache();
$rows = $mq10files->getSearch($conditions, $limit, $offset, "file DESC");
$total = $rows['total'];
//echo(safe_dump($rows['sql']));
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center  align-middle"),
    array("content" => lang("App.File"), "class" => "text-center align-middle"),
    array("content" => lang("App.Attachment"), "class" => "text-center  align-middle"),
    array("content" => lang("App.Reference"), "class" => "text-center  align-middle"),
    array("content" => lang("App.Type"), "class" => "text-center  align-middle"),
    array("content" => "Identificación", "class" => "text-center  align-middle"),
    array("content" => lang("App.Description"), "class" => "text-center  align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center  align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row['file'])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefEdit = "/sie/q10files/edit/" . $row['file'];
        $hrefDelete = "/sie/q10files/delete/" . $row['file'];
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnedit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-primary",));
        $btndelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-sm btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnedit . $btndelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $attachment = "";

        if (!empty($row['attachment'])) {
            $rattachment = $mattachments->where("attachment", $row['attachment'])->first();
            $file = @$rattachment['file'];
            $url = cdn_url($file);
            $attachment = "<a href=\"{$url}\"target=\"_blank\">{$row['attachment']}</a>";
        }
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['file'], "class" => "text-left  align-middle"),
                array("content" => $attachment, "class" => "text-left  align-middle"),
                array("content" => $row['reference'], "class" => "text-left  align-middle"),
                array("content" => $row['type'], "class" => "text-center  align-middle"),
                array("content" => $row['identification'], "class" => "text-left  align-middle"),
                array("content" => $row['description'], "class" => "text-center  align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Q10/" . lang('Q10files.list_of_files'),
    "header-back" => $back,
    "header-add" => "/sie/q10files/import/" . lpk(),
    "content" => $bgrid,
));
echo($card);
?>