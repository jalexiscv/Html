<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Scores\Editor\form.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/
$f = service("forms", array("lang" => "Scores."));
//[Request]--------------------------------------------------------------------------------------------------------------
$activities = model("App\Modules\Disa\Models\Disa_Activities");
$model = model("App\Modules\Disa\Models\Disa_Scores");
$row = $model->find($oid);
$activity = $activities->find($row["activity"]);
//[Groups]--------------------------------------------------------------------------------------------------------------
$r["score"] = $f->get_Value("score", $row["score"]);
$r["activity"] = $f->get_Value("activity", $row["activity"]);
$r["value"] = $f->get_Value("value", $row["value"]);
$r["details"] = $f->get_Value("details", urldecode($row["details"]));
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/disa/mipg/scores/list/{$r["activity"]}";
//[Form]--------------------------------------------------------------------------------------------------------------
$info = "El criterio de calificación es el puntaje que hace referencia a la calificación de cada una de las Actividades de Gestión, y debe ir en una escala de 0 a 100. Es muy Importante que los puntajes ingresados sean lo más objetivos posible, y que exista un soporte para cada uno de ellos. El propósito principal es identificar oportunidades de mejora, para lo cual es fundamental ser objetivos en los puntajes ingresados. La calificación de las categorías, de los componentes y la calificación total se generan automáticamente."
    . " [ <a data-bs-toggle=\"modal\" data-bs-target=\"#infocreateplan\" href=\"#\">ver criterio de valoraciones</a> ]";
$f->fields["info"] = $f->get_FieldView("info", array("value" => $info, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12", "readonly" => true));
$f->add_HiddenField("author", $r["author"]);
$f->fields["score"] = $f->get_FieldText("score", array("value" => $r["score"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["activity"] = $f->get_FieldText("activity", array("value" => $r["activity"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["value"] = $f->get_FieldText("value", array("value" => $r["value"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["details"] = $f->get_FieldTextArea("details", array("value" => $r["details"], "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Modify"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
//$f->groups["g0"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["info"])));
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["score"] . $f->fields["activity"] . $f->fields["value"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["details"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$swarning = service("smarty");
$swarning->set_Mode("bs5x");
$swarning->caching = 0;
$swarning->assign("title", "Recuerde");
$swarning->assign("message", "{$info}");
$warning = ($swarning->view('alerts/inline/warning.tpl'));
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Scores.edit-title"));
$smarty->assign("header_back", $back);
$smarty->assign("body", $warning . $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
<!-- Modal -->
<div class="modal fade" id="infocreateplan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Criterio de Recalificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo(urldecode($activity["evaluation"])); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continuar</button>
            </div>
        </div>
    </div>
</div>
