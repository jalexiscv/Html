<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-11-10 06:42:40
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Georeferences\Editor\processor.php]
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
$f = service("forms", array("lang" => "Cadastre.georeferences-"));
$model = model("App\Modules\Cadastre\Models\Cadastre_Georeferences");
$d = array(
    "georeference" => $f->get_Value("georeference"),
    "profile" => $f->get_Value("profile"),
    "latitud" => $f->get_Value("latitud"),
    "latitude_degrees" => $f->get_Value("latitude_degrees"),
    "latitude_minutes" => $f->get_Value("latitude_minutes"),
    "latitude_seconds" => $f->get_Value("latitude_seconds"),
    "latitude_decimal" => $f->get_Value("latitude_decimal"),
    "longitude" => $f->get_Value("longitude"),
    "longitude_degrees" => $f->get_Value("longitude_degrees"),
    "longitude_minutes" => $f->get_Value("longitude_minutes"),
    "longitude_seconds" => $f->get_Value("longitude_seconds"),
    "longitude_decimal" => $f->get_Value("longitude_decimal"),
    "date" => $f->get_Value("date"),
    "time" => $f->get_Value("time"),
    "author" => safe_get_user(),
);
$row = $model->find($d["georeference"]);
if (isset($row["georeference"])) {
    $edit = $model->update($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Cadastre.georeferences-view-success-title"));
    $smarty->assign("message", sprintf(lang("Cadastre.georeferences-view-success-message"), $d['georeference']));
    $smarty->assign("edit", base_url("/cadastre/georeferences/edit/{$d['georeference']}/" . lpk()));
    $smarty->assign("continue", base_url("/cadastre/georeferences/view/{$d["georeference"]}/" . lpk()));
    $smarty->assign("voice", "cadastre/georeferences-view-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
} else {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Cadastre.georeferences-view-noexist-title"));
    $smarty->assign("message", lang("Cadastre.georeferences-view-noexist-message"));
    $smarty->assign("continue", base_url("/cadastre/georeferences"));
    $smarty->assign("voice", "cadastre/georeferences-view-noexist-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
}
echo($c);
?>
