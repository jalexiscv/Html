<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-09-15 06:10:25
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Diagnostics\Editor\form.php]
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
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication =service('authentication');
$server = service("server");
$f = service("forms",array("lang" => "Iris_Diagnostics."));
//[models]--------------------------------------------------------------------------------------------------------------
//[vars]----------------------------------------------------------------------------------------------------------------
$row= $model->getDiagnostic($oid);
$r["diagnostic"] =$row["diagnostic"];
$r["study"] =$row["study"];
$r["attachment"] =$row["attachment"];
$r["result_ia"] =$row["result_ia"];
$r["result"] =$row["result"];
$r["created_by"] =$row["created_by"];
$r["updated_by"] =$row["updated_by"];
$r["deleted_by"] =$row["deleted_by"];
$r["created_at"] =$row["created_at"];
$r["updated_at"] =$row["updated_at"];
$r["deleted_at"] =$row["deleted_at"];
$back="/iris/studies/view/{$r["study"]}";
//[Fields]-----------------------------------------------------------------------------
$f->fields["diagnostic"] = $f->get_FieldView("diagnostic", array("value" => $r["diagnostic"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["study"] = $f->get_FieldView("study", array("value" => $r["study"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["attachment"] = $f->get_FieldView("attachment", array("value" => $r["attachment"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["result_ia"] = $f->get_FieldView("result_ia", array("value" => $r["result_ia"],"proportion"=>"col-12"));
$f->fields["result"] = $f->get_FieldView("result", array("value" => $r["result"],"proportion"=>"col-12"));
$f->fields["created_by"] = $f->get_FieldView("created_by", array("value" => $r["created_by"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_by"] = $f->get_FieldView("updated_by", array("value" => $r["updated_by"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_by"] = $f->get_FieldView("deleted_by", array("value" => $r["deleted_by"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] =$f->get_Button("edit", array("href" =>"/iris/diagnostics/edit/".$oid,"text" =>lang("App.Edit"),"class"=>"btn btn-secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["diagnostic"].$f->fields["study"].$f->fields["attachment"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["result"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["result_ia"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["edit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
		"header-title" => lang("Iris_Diagnostics.view-title"),
		"header-back" => $back,
		"content" => $f,
));
echo($card);
?>
