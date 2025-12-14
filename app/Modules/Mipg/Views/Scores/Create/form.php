<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2024-08-05 16:58:22
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @Editor Anderson Ospina Lenis <andersonospina798@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Mipg_Scores."));
$strings = service("strings");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Mipg\Models\Mipg_Scores");
$mactivities = model("App\Modules\Mipg\Models\Mipg_Activities");
$activity = $mactivities->get_Activity($oid);
//[vars]----------------------------------------------------------------------------------------------------------------
$r["score"] = $f->get_Value("score", pk());
$r["activity"] = $f->get_Value("activity", $oid);
$r["value"] = $f->get_Value("value", "0");
$r["details"] = $f->get_Value("details");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$r["multiplan"] = $f->get_Value("multiplan", "N");
$back = "/mipg/scores/home/{$oid}";
$description = $strings->get_Clear($activity["description"]);
$types = array(
    array("label" => "Si", "value" => "Y"),
    array("label" => "No", "value" => "N"),
);
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["score"] = $f->get_FieldText("score", array("value" => $r["score"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["activity"] = $f->get_FieldText("activity", array("value" => $r["activity"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["value"] = $f->get_FieldNumber("value", array("value" => $r["value"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldViewArea("description", array("value" => $description, "proportion" => "col-12"));
$f->fields["details"] = $f->get_FieldCKEditor("details", array("value" => $r["details"], "proportion" => "col-12"));
$f->fields["multiplan"] = $f->get_FieldSelect("multiplan", array("selected" => $r["multiplan"], "data" => $types, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["score"] . $f->fields["activity"] . $f->fields["value"] . $f->fields["multiplan"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["details"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));

$title = lang("Mipg_Scores.info-create-title");
$message = lang("Mipg_Scores.info-create-message");
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Mipg_Scores.create-title"),
    "content" => $f,
    "header-back" => $back,
    "alert" => array(
        'type' => 'warning',
        'title' => $title,
        'message' => $message
    ),
));
echo($card);
//[info]----------------------------------------------------------------------------------------------------------------
$info = $b->get_Card("card-view-service", array(
    "alert" => array(
        'type' => 'secondary',
        'title' => lang("Mipg_Scores.how-is-it-rated-title"),
        'message' => $activity['evaluation'],
        'class' => 'mb-0'
    ),
));
echo($info);
?>