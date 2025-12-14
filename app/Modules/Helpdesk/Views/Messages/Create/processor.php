<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-10-12 07:16:26
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Helpdesk\Views\Messages\Creator\processor.php]
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('server');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Messages."));
$model = model("App\Modules\Helpdesk\Models\Helpdesk_Messages");
$mattachments = model("App\Modules\Helpdesk\Models\Helpdesk_Attachments");
$d = array(
    "message" => $f->get_Value("message"),
    "conversation" => $f->get_Value("conversation"),
    "participant" => $f->get_Value("participant"),
    "type" => $f->get_Value("type"),
    "subject" => $f->get_Value("subject"),
    "content" => $f->get_Value("content"),
    "priority" => $f->get_Value("priority"),
    "status" => $f->get_Value("status"),
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
);
$row = $model->find($d["message"]);

$user = safe_get_user();
$back = "/helpdesk/conversations/review/" . $d["conversation"];
if ($user != "anonymous") {
    $back = "/helpdesk/conversations/view/" . $d["conversation"];
}

$l["back"] = $back;
$l["edit"] = "/helpdesk/messages/edit/{$d["message"]}";
$asuccess = "helpdesk/messages-create-success-message.mp3";
$aexist = "helpdesk/messages-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Messages.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Messages.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $model->insert($d);
    //[attachments]-----------------------------------------------------------------------------------------------------
    $attachments = $request->getFiles();
    $path = "/storages/" . md5($server::get_FullName()) . "/helpdesk/attachments";
    $realpath = ROOTPATH . "public" . $path;
    if (!file_exists($realpath)) {
        mkdir($realpath, 0777, true);
    }
    foreach ($attachments[$f->get_fieldId("attachment")] as $attachment) {

        if ($attachment->isValid()) {
            $rname = $attachment->getRandomName();
            $attachment->move($realpath, $rname);
            $name = $attachment->getClientName();
            $type = $attachment->getClientMimeType();
            $size = $attachment->getSize();
            $uri = "{$path}/{$rname}";
            $attach = array(
                "attachment" => pk(),
                "object" => $d['message'],
                "file" => $uri,
                "type" => $type,
                "date" => $dates->get_Date(),
                "time" => $dates->get_Time(),
                "alt" => "",
                "title" => "",
                "size" => $size,
                "reference" => "ATTACHMENT",
                "author" => safe_get_user(),
            );
            $acreate = $mattachments->insert($attach);

        }
    }
    $notifier = view('App\Modules\Helpdesk\Views\Messages\Create\notifier', $d);
    echo($notifier);

    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Messages.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Messages.create-success-message"), $d['message']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
?>