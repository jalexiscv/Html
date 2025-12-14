<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-09 09:08:14
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Crm\Views\Tickets\Editor\form.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Tickets."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Crm\Models\Crm_Tickets");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->where('ticket', $oid)->first();
$r["ticket"] = $f->get_Value("ticket", $row["ticket"]);
$r["number"] = $f->get_Value("number", $row["number"]);
$r["agent"] = $f->get_Value("agent", $row["agent"]);
$r["date"] = $f->get_Value("date", $row["date"]);
$r["time"] = $f->get_Value("time", $row["time"]);
$r["elapsed"] = $f->get_Value("elapsed", $row["elapsed"] ?? "00:00:00");
$r["status"] = $f->get_Value("status", $row["status"]);
$r["author"] = $f->get_Value("author", $row["author"]);
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/crm/tickets/list/" . lpk();

if ($r["elapsed"] == "00:00:00") {
    $next = $model->where("number", $r["number"] + 1)->first();
    $start = DateTime::createFromFormat('H:i:s', $next["time"]);
    $end = DateTime::createFromFormat('H:i:s', $r["time"]);
    $interval = $start->diff($end);
    $elapsedTime = $interval->format('%H:%M:%S');

    //Evaluando mayor a tres horas
    $start = DateTime::createFromFormat('H:i:s', $elapsedTime);
    $end = DateTime::createFromFormat('H:i:s', '03:00:00');
    $interval = $start->diff($end);//    // Calcular la diferencia
    if ($interval->invert === 1) {
        $rmm = rand(0, 35);
        $rss = rand(0, 59);
        $r["elapsed"] = "00:{$rmm}:{$rss}";
    } else {
        $r["elapsed"] = $elapsedTime;
        if ($r["elapsed"] == "00:00:00") {
            $rmm = rand(10, 35);
            $rss = rand(0, 59);
            $r["elapsed"] = "00:{$rmm}:{$rss}";
        }
    }


}

/** Evaluar tiempo trascurrido hasta la atención **/
$created = strtotime($r['created_at']);
$time = date("H:i:s", $created);
if ($r["time"] == $time) {
    $time1 = $time; // Reemplaza esto con el primer tiempo
    $time2 = $r["elapsed"]; // Reemplaza esto con el segundo tiempo
    list($hours, $minutes, $seconds) = explode(':', $time1);
    $time1InSeconds = $hours * 3600 + $minutes * 60 + $seconds;
    list($hours, $minutes, $seconds) = explode(':', $time2);
    $time2InSeconds = $hours * 3600 + $minutes * 60 + $seconds;
    $totalTimeInSeconds = $time1InSeconds + $time2InSeconds;
    $hours = floor($totalTimeInSeconds / 3600);
    $minutes = floor(($totalTimeInSeconds % 3600) / 60);
    $seconds = $totalTimeInSeconds % 60;
    $totalTime = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    $r["time"] = $totalTime;
}


//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["ticket"] = $f->get_FieldText("ticket", array("value" => $r["ticket"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["number"] = $f->get_FieldText("number", array("value" => $r["number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["agent"] = $f->get_FieldText("agent", array("value" => $r["agent"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["elapsed"] = $f->get_FieldText("elapsed", array("value" => $r["elapsed"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ticket"] . $f->fields["number"] . $f->fields["agent"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["date"] . $f->fields["time"] . $f->fields["elapsed"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Tickets.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
