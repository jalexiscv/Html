<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-10-31 08:48:30
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Certificates\List\table.php]
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
$mcertificates = model('App\Modules\Sie\Models\Sie_Certificates');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"certificate" => lang("App.certificate"),
    //"format" => lang("App.format"),
    //"serial" => lang("App.serial"),
    //"registration" => lang("App.registration"),
    //"expiration" => lang("App.expiration"),
    //"created_by" => lang("App.created_by"),
    //"updated_by" => lang("App.updated_by"),
    //"deleted_by" => lang("App.deleted_by"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    "registration" => $oid,
);
//$mcertificates->clear_AllCache();
$rows = $mcertificates->getCachedSearch($conditions, $limit, $offset, "certificate DESC");
$total = $mcertificates->getCountAllResults($conditions);
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
    array("content" => lang("App.Certificate"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Details"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.format"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.serial"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.registration"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.expiration"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/certificates';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["certificate"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["certificate"]}";
        $hrefEdit = "$component/edit/{$row["certificate"]}";
        $hrefDelete = "$component/delete/{$row["certificate"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $registration = $mregistrations->getRegistration($row['registration']);
        $fullname = @$registration['first_name'] . ' ' . @$registration['second_name'] . ' ' . @$registration['first_surname'] . " " . @$registration['second_surname'];

        $details = "{$fullname} - <span class='opacity-3'>{$row['registration']}</span>";


        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['certificate'], "class" => "text-left align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                //array("content" => $row['format'], "class" => "text-left align-middle"),
                //array("content" => $row['serial'], "class" => "text-left align-middle"),
                //array("content" => $row['registration'], "class" => "text-left align-middle"),
                //array("content" => $row['expiration'], "class" => "text-left align-middle"),
                //array("content" => $row['created_by'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_by'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_by'], "class" => "text-left align-middle"),
                //array("content" => $row['created_at'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}

$addCertificate = "";
$addCertificate .= "<div class=\"row\">\n";
$addCertificate .= "    <div class=\"col-6\">\n";
$addCertificate .= "        <div class=\"input-group mb-3\">\n";
$addCertificate .= "            <a id=\"btn-bill\" class=\"btn btn-secondary\" href=\"/sie/certificates/create/{$oid}?back=/sie/students/view/{$oid}&registration={$oid}\"><i class=\"icon fa-light fa-plus \"></i><div class=\"btn-text-inline\">Crear certificado</div></a>\n";
$addCertificate .= "        </div>\n";
$addCertificate .= "    </div>\n";
$addCertificate .= "</div>\n";

$icertificates = $bootstrap->get_Alert(array(
    'type' => 'info',
    'title' => lang('App.Remember'),
    "message" => lang("Sie_Certificates.message-certificates-student-list-info"),
));
//[build]---------------------------------------------------------------------------------------------------------------
echo($icertificates);
echo($addCertificate);
echo($bgrid);
?>