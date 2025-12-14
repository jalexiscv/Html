<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-10-09 15:10:35
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Helpdesk\Views\Conversations\Editor\form.php]
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
//[models]--------------------------------------------------------------------------------------------------------------
$mservices = model("App\Modules\Helpdesk\Models\Helpdesk_Services");
$mcustomers = model("App\Modules\Helpdesk\Models\Helpdesk_Customers");
$mattachments = model("App\Modules\Helpdesk\Models\Helpdesk_Attachments");
$mconversations = model("App\Modules\Helpdesk\Models\Helpdesk_Conversations");
//[vars]----------------------------------------------------------------------------------------------------------------
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Conversations."));
//[Request]-------------------------------------------------------------------------------------------------------------
$row = $mconversations->get_Conversation($oid);
$r["conversation"] = $row["conversation"];
$r["service"] = $row["service"];
$r["title"] = $row["title"];
$r["description"] = $row["description"];
$r["status"] = $row["status"];
$r["priority"] = $row["priority"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];

$customer = $mcustomers->where("conversation", $r["conversation"])->first();
$r["customer"] = $customer["customer"];
$r["document_type"] = $customer["document_type"];
$r["document_number"] = $customer["document_number"];
$r["first_name"] = $customer["first_name"];
$r["last_name"] = $customer["last_name"];
$r["email"] = $customer["email"];
$r["phone"] = $customer["phone"];

$back = "/helpdesk/conversations/list/" . lpk();
$edit = "/helpdesk/conversations/edit/" . $oid;

$service = $mservices->find($r["service"]);
$r["service"] = $row["service"] . " - " . $service["name"];
//[Fields]-----------------------------------------------------------------------------
$f->add_HiddenField("author", $r["author"]);
$f->fields["conversation"] = $f->get_FieldView("conversation", array("value" => $r["conversation"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["service"] = $f->get_FieldView("service", array("value" => $r["service"], "proportion" => "col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12"));
$f->fields["title"] = $f->get_FieldView("title", array("value" => $r["title"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldView("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["status"] = $f->get_FieldView("status", array("value" => $r["status"], "proportion" => "col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12"));
$f->fields["priority"] = $f->get_FieldView("priority", array("value" => $r["priority"], "proportion" => "col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12"));

$f->fields["customer"] = $f->get_FieldView("customer", array("value" => $r["customer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_type"] = $f->get_FieldView("document_type", array("value" => $r["document_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_number"] = $f->get_FieldView("document_number", array("value" => $r["document_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["first_name"] = $f->get_FieldView("first_name", array("value" => $r["first_name"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["last_name"] = $f->get_FieldView("last_name", array("value" => $r["last_name"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["email"] = $f->get_FieldView("email", array("value" => $r["email"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["phone"] = $f->get_FieldView("phone", array("value" => $r["phone"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));

$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/helpdesk/conversations/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["reply"] = $f->get_Button("reply", array("href" => "/helpdesk/messages/create/" . $oid, "text" => lang("App.Reply"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$table = view('App\Modules\Helpdesk\Views\Conversations\Review\table', array('conversation' => $r['conversation']));
//[Groups]-----------------------------------------------------------------------------
//$f->groups["g0"] = $f->get_Group(array("legend" => "Mensajes", "fields" => ($table), "class" => "p-0"));
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["conversation"] . $f->fields["service"] . $f->fields["status"] . $f->fields["priority"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["customer"] . $f->fields["document_type"] . $f->fields["document_number"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["first_name"] . $f->fields["last_name"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["email"] . $f->fields["phone"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["title"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));

$attachments = $mattachments->get_FileListForObject($r["conversation"]);
$list = "<ul class='px-3 mx-3'>";
foreach ($attachments as $attachment) {
    $list .= "<li><a href='{$attachment['file']}' target='_blank'>{$attachment['file']}</a></li>";
}
$list .= "</ul>";
$f->groups["g9"] = $f->get_Group(array("legend" => "Archivos Adjuntos", "fields" => ($list)));


//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["reply"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Mensajes",
    "header-back" => $back,
    "header-edit" => $edit,
    "content" => $table,
    "header-add" => "/helpdesk/messages/create/" . $r["conversation"],
));
echo($card);


$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Solicitud de soporte",
    "header-back" => $back,
    "content" => $f,
    "content-class" => "p-3",
    //"header-add" => "/helpdesk/messages/create/" . $r["conversation"],
));
echo($card);
?>