<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-10-09 15:10:34
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Helpdesk\Views\Conversations\Creator\processor.php]
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
//[Services]-----------------------------------------------------------------------------
$server = service('server');
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$mcustomers = model("App\Modules\Helpdesk\Models\Helpdesk_Customers");
$mattachments = model("App\Modules\Helpdesk\Models\Helpdesk_Attachments");

$author = safe_get_user();

$f = service("forms", array("lang" => "Conversations."));
$mconvsersations = model("App\Modules\Helpdesk\Models\Helpdesk_Conversations");
$d = array(
    "conversation" => pk(), //$f->get_Value("conversation"),
    "service" => $f->get_Value("service"),
    "title" => $f->get_Value("title"),
    "description" => $f->get_Value("description"),
    "status" => $f->get_Value("status"),
    "priority" => $f->get_Value("priority"),
    "type" => $f->get_Value("type"),
    "category" => $f->get_Value("category"),
    "agent" => $f->get_Value("agent"),
    "author" => !empty($author) ? $author : 0,
);

$customer = array(
    "customer" => pk(),
    "conversation" => $d['conversation'],
    "document_type" => $f->get_Value("document_type"),
    "document_number" => $f->get_Value("document_number"),
    "first_name" => $f->get_Value("first_name"),
    "last_name" => $f->get_Value("last_name"),
    "email" => $f->get_Value("email"),
    "phone" => $f->get_Value("phone"),
);


$row = $mconvsersations->find($d["conversation"]);
$l["back"] = "/helpdesk/home/index/" . lpk();
$l["edit"] = "/helpdesk/conversations/edit/{$d["conversation"]}";
$asuccess = "helpdesk/conversations-create-success-message.mp3";
$aexist = "helpdesk/conversations-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Conversations.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Conversations.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $mconvsersations->insert($d);
    $customer_create = $mcustomers->insert($customer);
    $data = array(
        'conversation' => $d['conversation'],
        'service' => $d['service'],
        'type' => $d['type'],
        'category' => $d['category'],
        'agent' => $d['agent'],
        'email' => @$customer['email'],
        'name' => @$customer['first_name'] . " " . @$customer['last_name'],
        'title' => $d['title'],
        'description' => $d['description'],
    );
    //print_r($data);
    $notifier = view('App\Modules\Helpdesk\Views\Conversations\Create\notifier', $data);
    echo($notifier);

    //[attachments]-----------------------------------------------------------------------------------------------------
    $attachment = $request->getFile($f->get_fieldId("attachment"));
    $path = "/storages/" . md5($server::get_FullName()) . "/helpdesk/attachments";
    $realpath = ROOTPATH . "public" . $path;
    if (!file_exists($realpath)) {
        mkdir($realpath, 0777, true);
    }
    if ($attachment->isValid()) {
        $rname = $attachment->getRandomName();
        $attachment->move($realpath, $rname);
        $name = $attachment->getClientName();
        $type = $attachment->getClientMimeType();
        $size = $attachment->getSize();
        $uri = "{$path}/{$rname}";
        $attach = array(
            "attachment" => pk(),
            "object" => $d['conversation'],
            "file" => $uri,
            "type" => $type,
            "date" => $dates->get_Date(),
            "time" => $dates->get_Time(),
            "alt" => "",
            "title" => "",
            "size" => $size,
            "reference" => "ATTACHMENT",
            "author" => $author,
        );
        $acreate = $mattachments->insert($attach);
    }

    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Conversations.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Conversations.create-success-message"), $d['conversation']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>