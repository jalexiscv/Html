<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Plans\Editor\form.php]
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
$model = model("App\Modules\Disa\Models\Disa_Plans");
$f = service("forms", array("lang" => "Disa.plans-"));
/** request **/
$row = $model->find($oid);
$r["plan"] = $f->get_Value("plan", $row["plan"]);
$r["plan_institutional"] = $f->get_Value("plan_institutional", @$row["plan_institutional"]);
$r["manager"] = $f->get_Value("manager", @$row["manager"]);
$r["activity"] = $f->get_Value("activity", $row["activity"]);
$r["description"] = $f->get_Value("description", $row["description"]);
$r["order"] = $f->get_Value("order", $row["order"]);
$r["value"] = $f->get_Value("value", $row["value"]);
$r["start"] = $f->get_Value("start", $row["start"]);
$r["end"] = $f->get_Value("end", $row["end"]);
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
/** Models **/
$mactivities = model('App\Modules\Disa\Models\Disa_Activities');
$mcategories = model('App\Modules\Disa\Models\Disa_Categories');
$mcomponents = model('App\Modules\Disa\Models\Disa_Components');
$mdiagnostics = model('App\Modules\Disa\Models\Disa_Diagnostics');
$mpolitics = model('App\Modules\Disa\Models\Disa_Politics');
$mdimensions = model('App\Modules\Disa\Models\Disa_Dimensions');
$mprocesses = model('App\Modules\Disa\Models\Disa_Processes');
$msubprocesses = model('App\Modules\Disa\Models\Disa_Subprocesses');
$miplans = model('App\Modules\Disa\Models\Disa_Institutional_Plans');
/** Queries **/
$activity = $mactivities->where("activity", $row["activity"])->first();
$category = $mcategories->where("category", $activity["category"])->first();
$component = $mcomponents->where("component", $category["component"])->first();
$diagnostic = $mdiagnostics->where("diagnostic", $component["diagnostic"])->first();
$politic = $mpolitics->where("politic", $diagnostic["politic"])->first();
$dimension = $mdimensions->where("dimension", $politic["dimension"])->first();
$process = $mprocesses->where("process", $dimension["process"])->first();
$subprocesses = $msubprocesses->where("process", @$process["process"])->find();

$processes = $mprocesses->findAll();
$managers = array();
foreach ($processes as $process) {
    array_push($managers, array("value" => $process["process"], "label" => "{$process["name"]}"));
}

$plans = $miplans->get_SelectData();
/* Links */
$l["back"] = "/disa/mipg/plans/list/{$row["activity"]}?time=" . time();
/** fields * */
$f->add_HiddenField("plan", $r["plan"]);
$f->add_HiddenField("activity", $r["activity"]);
$f->add_HiddenField("order", $r["order"]);
$f->add_HiddenField("author", $r["author"]);

$f->fields["plan"] = $f->get_FieldView("plan", array("value" => $r["plan"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["activity"] = $f->get_FieldText("activity", array("value" => $r["activity"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["order"] = $f->get_FieldText("order", array("value" => $r["order"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["value"] = $f->get_FieldNumber("value", array("value" => $r["value"], "min" => $r["value"], "max" => "100", "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["range"] = $f->get_FieldDateRange("daterange", "end", array("start" => $r["start"], "end" => $r["end"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => urldecode($r["description"]), "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["plan_institutional"] = $f->get_FieldSelect("plan_institutional", array("value" => $r["plan_institutional"], "data" => $plans, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["manager"] = $f->get_FieldSelect("manager", array("value" => $r["manager"], "data" => $managers, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));

$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $l["back"], "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/** groups * */
//$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["plan"] . $f->fields["activity"] . $f->fields["order"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["plan"] . $f->fields["value"] . $f->fields["range"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["plan_institutional"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["manager"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
/** buttons * */
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));


$swarning = service("smarty");
$swarning->set_Mode("bs5x");
$swarning->caching = 0;
$swarning->assign("title", "Recuerde");
$swarning->assign("message", lang("Disa.plans-edit-info") . "[ <a data-bs-toggle=\"modal\" data-bs-target=\"#infocreateplan\" href=\"#\">ver valoración del plan</a> ]");
$warning = ($swarning->view('alerts/inline/warning.tpl'));


/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", sprintf(lang("Disa.plans-edit-title"), $strings->get_ZeroFill($row["order"], 4)));
$smarty->assign("header_back", $l["back"]);
$smarty->assign("header_help", $l["back"]);
$smarty->assign("body", $warning . $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));


/** Logger **/
history_logger(array(
    "log" => pk(),
    "module" => "DISA",
    "author" => $authentication->get_User(),
    "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> ha accedido al <b>formulario de edición del plan de acción</b> <b><a href=\"/disa/mipg/plans/view/{$oid}\" target=\"_blank\">{$oid}</b>.",
    "code" => "",
));


?>
<!-- Modal -->
<div class="modal fade" id="infocreateplan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Valoración del plan</h5>
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