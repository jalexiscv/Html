<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Causes\Creator\form.php]
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
 ***/

use App\Libraries\Bootstrap;

use App\Libraries\Strings;

$authentication = service('authentication');
$strings = new Strings();

$mplans = model('App\Modules\Disa\Models\Disa_Plans', true);
$mcauses = model('App\Modules\Disa\Models\Disa_Causes', true);
$mscores = model('App\Modules\Disa\Models\Disa_Causes_Scores', true);

$plan = $mplans->find($oid);
$causes = $mcauses->where("plan", $oid)->find();
$description = $strings->get_Striptags(urldecode($plan["description"]));

$prefix = "Disa.Causes-Evaluate-";
$f = service("forms", array("lang" => "{$prefix}-"));
$r["author"] = $f->get_Value("author", $authentication->get_User());
$scores = $mscores->where("author", $r["author"])->find();
//var_dump($scores);

$data = array(
    array("label" => "0", "value" => "0.0"),
    array("label" => "1", "value" => "0.1"),
    array("label" => "2", "value" => "0.2"),
    array("label" => "3", "value" => "0.3"),
    array("label" => "4", "value" => "0.4"),
    array("label" => "5", "value" => "0.5"),
    array("label" => "6", "value" => "0.6"),
    array("label" => "7", "value" => "0.7"),
    array("label" => "8", "value" => "0.8"),
    array("label" => "9", "value" => "0.9"),
);

$f->add_HiddenField("plan", $oid);
$f->add_HiddenField("author", $r["author"]);

$sinfo = service("smarty");
$sinfo->set_Mode("bs5x");
$sinfo->caching = 0;
$sinfo->assign("title", "Causa a analizar");
$sinfo->assign("message", $description);
$info = ($sinfo->view('alerts/inline/info.tpl'));

$html = "";
$html .= "<table class=\"table table-striped mg-b-0\">\n";
$html .= "   <thead>\n";
$html .= "      <tr>\n";
$html .= "         <th>#</th>\n";
$html .= "         <th>" . lang("Disa.Probable-causes") . "</th>\n";
$html .= "         <th>" . lang("App.Score") . "</th>\n";
$html .= "      </tr>\n";
$html .= "   </thead>\n";
$html .= "   <tbody>\n";

$count = 0;
foreach ($causes as $cause) {
    $count++;
    $description = urldecode($cause["description"]);
    $value = "0";
    foreach ($scores as $score) {
        if ($score["cause"] == $cause["cause"]) {
            $value = $score["value"];
        }
    }
    $field = $f->get_FieldSelect("value[{$cause["cause"]}]", array("value" => $value, "data" => $data, "label" => false, "help" => false, "proportion" => "col-12"));
    $html .= "<tr>\n";
    $html .= "<td>{$count}</td>\n";
    $html .= "<td>{$description}</td>\n";
    $html .= "<td width=\"150\">{$field}</td>\n";
    $html .= "</tr>\n";
}
$html .= "   </tbody>\n";
$html .= "</table>\n";
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/disa/mipg/plans/causes/list/{$oid}", "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));

/** buttons * */
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));

$f->add_Html($html);

history_logger(array(
    "module" => "DISA",
    "type" => "EDIT",
    "reference" => "COMPONENT",
    "object" => "PLAN",
    "log" => "Accedió a <b>calificar las causas</b> del  <b>plan de acción</b> <b>{$plan['order']}</b>",
));


/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$cards = service("smarty");
$cards->set_Mode("bs5x");
$cards->assign("type", "normal");
$cards->assign("header", lang("Disa.causes-evaluate-title"));
$cards->assign("header_back", "/disa/mipg/plans/causes/list/{$oid}");
$cards->assign("body", $info . $f);
$cards->assign("footer", null);
$cards->assign("file", __FILE__);
echo($cards->view('components/cards/index.tpl'));

?>