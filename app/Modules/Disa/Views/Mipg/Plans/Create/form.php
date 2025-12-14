<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Plans\Creator\form.php]
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
$f = service("forms", array("lang" => "Disa.plans-"));
/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
/* models */
$mplans = model('App\Modules\Disa\Models\Disa_Plans');
$mscores = model('App\Modules\Disa\Models\Disa_Scores');
$score = $mscores->get_ScoreByActivity($oid);
/* vars */
$order = $mplans->get_Consecutive($oid);

/** request * */
$r["plan"] = $f->get_Value("plan", pk());
$r["plan_institutional"] = $f->get_Value("plan_institutional");
$r["manager"] = $f->get_Value("manager");
$r["activity"] = $f->get_Value("activity", $oid);
$r["order"] = $f->get_Value("order", $order);
$r["value"] = $f->get_Value("value", $score);
$r["description"] = $f->get_Value("description");
$r["start"] = $f->get_Value("start");
$r["end"] = $f->get_Value("end");
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
/** Models * */
$mactivities = model('App\Modules\Disa\Models\Disa_Activities');
$mcategories = model('App\Modules\Disa\Models\Disa_Categories');
$mcomponents = model('App\Modules\Disa\Models\Disa_Components');
$mdiagnostics = model('App\Modules\Disa\Models\Disa_Diagnostics');
$mpolitics = model('App\Modules\Disa\Models\Disa_Politics');
$mdimensions = model('App\Modules\Disa\Models\Disa_Dimensions');
$mprocesses = model('App\Modules\Disa\Models\Disa_Processes');
$msubprocesses = model('App\Modules\Disa\Models\Disa_Subprocesses');
$miplans = model('App\Modules\Disa\Models\Disa_Institutional_Plans');
/** Queries * */
$activity = $mactivities->where("activity", $oid)->first();
$category = $mcategories->where("category", $activity["category"])->first();
$component = $mcomponents->where("component", $category["component"])->first();
$diagnostic = $mdiagnostics->where("diagnostic", $component["diagnostic"])->first();
$politic = $mpolitics->where("politic", $diagnostic["politic"])->first();
$dimension = $mdimensions->where("dimension", $politic["dimension"])->first();

$category_name = urldecode($category["name"]);


$processes = $mprocesses->findAll();
$managers = array();
array_push($managers, array("value" => "", "label" => "Seleccione uno"));
foreach ($processes as $process) {
    array_push($managers, array("value" => $process["process"], "label" => "{$process["name"]}"));
}

//$process = $mprocesses->where("process", $dimension["process"])->first();
//$subprocesses = $msubprocesses->where("process", $process["process"])->find();
/** Datas * */
//$managers[0] = array("value" => $process["process"], "label" => "{$process["responsible"]} - {$process["name"]} (Proceso)");
//foreach ($subprocesses as $subprocess) {
//array_push($managers, array("value" => $subprocess["subprocess"], "label" => "{$subprocess["responsible"]} - {$subprocess["name"]} (Subproceso)"));
//}

// Nota proxima ocacion agragarle que por defecto diga seleccione una al iniciar.
$plans = $miplans->get_SelectData();
$back = "/disa/mipg/plans/list/{$oid}?time=" . time();

/** fields * */
$f->add_HiddenField("plan", $r["plan"]);
$f->add_HiddenField("activity", $r["activity"]);
$f->add_HiddenField("order", $r["order"]);
$f->add_HiddenField("author", $r["author"]);

$info = "El criterio de calificación es el puntaje que hace referencia a la calificación de cada una de las Actividades de Gestión, y debe ir en una escala de 0 a 100. Es muy Importante que los puntajes ingresados sean lo más objetivos posible, y que exista un soporte para cada uno de ellos. El propósito principal es identificar oportunidades de mejora, para lo cual es fundamental ser objetivos en los puntajes ingresados. La calificación de las categorías, de los componentes y la calificación total se generan automáticamente."
    . " [ <a data-bs-toggle=\"modal\" data-bs-target=\"#infocreateplan\" href=\"#\">ver valoración del plan</a> ]";
$f->fields["info"] = $f->get_FieldView("info", array("value" => $info, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12", "readonly" => true));
$f->fields["plan"] = $f->get_FieldText("plan", array("value" => $r["plan"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["activity"] = $f->get_FieldText("activity", array("value" => $r["activity"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["order"] = $f->get_FieldText("order", array("value" => $r["order"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["value"] = $f->get_FieldNumber("value", array("value" => $r["value"], "min" => $r["value"], "max" => "100", "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["range"] = $f->get_FieldDateRange("daterange", "end", array("start" => $r["start"], "end" => $r["end"], "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["start"] = $f->get_FieldDate("start", array("value" => $r["start"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["end"] = $f->get_FieldDate("end", array("value" => $r["end"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["plan_institutional"] = $f->get_FieldSelect("plan_institutional", array("value" => $r["plan_institutional"], "data" => $plans, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["manager"] = $f->get_FieldSelect("manager", array("value" => $r["manager"], "data" => $managers, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));

$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/** groups * */
//$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["plan"] . $f->fields["activity"] . $f->fields["order"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["value"] . $f->fields["range"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["plan_institutional"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["manager"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
/** buttons * */
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/

$swarning = service("smarty");
$swarning->set_Mode("bs5x");
$swarning->caching = 0;
$swarning->assign("title", "Recuerde");
$swarning->assign("message", "{$info}");
$warning = ($swarning->view('alerts/inline/warning.tpl'));

$card = service("smarty");
$card->set_Mode("bs5x");
$card->assign("type", "normal");
$card->assign("header", lang("Disa.plans-create-title"));
$card->assign("header_back", $back);
$card->assign("body", $warning . $f);
$card->assign("footer", null);
$card->assign("file", __FILE__);
echo($card->view('components/cards/index.tpl'));


/** Logger **/
history_logger(array(
    "log" => pk(),
    "module" => "DISA",
    "author" => $authentication->get_User(),
    "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> esta creando un <b>plan de acción</b> asociado a la actividad <b>{$activity["order"]}</b>, de la categoría <b><a href=\"/disa/mipg/activities/list/{$category["category"]}\" target=\"_blank\">{$category_name}</a></b>",
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