<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-04-10 06:51:05
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Assessments\Editor\form.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication =service('authentication');
$f = service("forms",array("lang" => "Iris_Assessments."));
//[Request]-----------------------------------------------------------------------------
$row= $model->getAssessment($oid);
$r["assessment"] =$row["assessment"];
$r["image"] =$row["image"];
$r["analysis_date"] =$row["analysis_date"];
$r["ai_results"] =$row["ai_results"];
$r["confidence_score"] =$row["confidence_score"];
$r["ai_recommendations"] =$row["ai_recommendations"];
$r["author"] =$row["author"];
$r["created_at"] =$row["created_at"];
$r["updated_at"] =$row["updated_at"];
$r["deleted_at"] =$row["deleted_at"];
$back= "/iris/assessments/list/".lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["assessment"] = $f->get_FieldView("assessment", array("value" => $r["assessment"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["image"] = $f->get_FieldView("image", array("value" => $r["image"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["analysis_date"] = $f->get_FieldView("analysis_date", array("value" => $r["analysis_date"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ai_results"] = $f->get_FieldView("ai_results", array("value" => $r["ai_results"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["confidence_score"] = $f->get_FieldView("confidence_score", array("value" => $r["confidence_score"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ai_recommendations"] = $f->get_FieldView("ai_recommendations", array("value" => $r["ai_recommendations"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author",$r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] =$f->get_Button("edit", array("href" =>"/iris/assessments/edit/".$oid,"text" =>lang("App.Edit"),"class"=>"btn btn-secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["assessment"].$f->fields["image"].$f->fields["analysis_date"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["ai_results"].$f->fields["confidence_score"].$f->fields["ai_recommendations"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["author"].$f->fields["created_at"].$f->fields["updated_at"])));
$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["deleted_at"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["edit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
		"title" => lang("Iris_Assessments.view-title"),
		"header-back" => $back,
		"content" => $f,
));
echo($card);
?>
