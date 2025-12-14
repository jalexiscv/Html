<?php

use App\Libraries\Bootstrap;

use App\Libraries\Strings;

$authentication = service('authentication');
$strings = new Strings();
$mplans = model("App\Modules\Disa\Models\Disa_Plans");
$mprocesses = model('App\Modules\Disa\Models\Disa_Processes');
$msubprocesses = model('App\Modules\Disa\Models\Disa_Subprocesses');
$mpositions = model('App\Modules\Disa\Models\Disa_Positions');

$plan = $mplans->find($oid);
$lsubprocesses = $msubprocesses->where("process", $plan["manager"])->findAll();

$description = $strings->get_Striptags(urldecode($plan["description"]));
$submanagers = array();
array_push($submanagers, array("value" => "none", "label" => "No asignado"));
foreach ($lsubprocesses as $process) {
    array_push($submanagers, array("value" => $process["subprocess"], "label" => "{$process["responsible"]} - {$process["position"]}"));
}
$r["manager_subprocess"] = $plan["manager_subprocess"];

$f = service("forms", array("lang" => "Disa.plans-team-"));
$f->fields["manager_subprocess"] = $f->get_FieldSelect("manager_subprocess", array("value" => $r["manager_subprocess"], "data" => $submanagers, "proportion" => "col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12"));

if (!empty($plan["manager_subprocess"])) {
    $lpostions = $mpositions->where("subprocess", $plan["manager_subprocess"])->findAll();
    $positions = array();
    array_push($positions, array("value" => "none", "label" => "No asignado"));
    foreach ($lpostions as $position) {
        array_push($positions, array("value" => $position["position"], "label" => "{$position["responsible"]} - {$position["name"]}"));
    }
    $r["manager_position"] = $plan["manager_position"];
    $f->fields["manager_position"] = $f->get_FieldSelect("manager_position", array("value" => $r["manager_position"], "data" => $positions, "proportion" => "col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12"));
}

$b = new Bootstrap();

echo("<div class=\"alert alert-warning bgc-warning-l3 brc-warning-m2 d-flex align-items-center mb-1\" role=\"alert\">");
echo("<i class=\"fas fa-info-circle mr-3 fa-2x text-warning\"></i>");
echo("<div>");
echo("<b>Causa a analizar</b>: {$description}");
echo("</div>");
echo("</div>");

echo("<div class=\"alert alert-primary bgc-primary-l3 brc-primary-m2 d-flex align-items-center mb-1\" role=\"alert\">");
echo("<i class=\"fas fa-info-circle mr-3 fa-2x text-blue\"></i>");
echo("<div style=\"width:100%;\">");
echo("<form method=\"POST\" action=\"/disa/mipg/plans/team/{$plan["plan"]}\">");
echo("<input type=\"hidden\" name=\"" . csrf_token() . "\" value=\"" . csrf_hash() . "\">");
echo("<input type=\"hidden\" name=\"submited\" value=\"" . $f->get_fid() . "\" style=\"display:none;\">");
echo("<input type=\"hidden\" name=\"{$f->get_fid()}_plan\" value=\"{$oid}\" style=\"display:none;\">");
echo("<input type=\"hidden\" name=\"{$f->get_fid()}_option\" value=\"subprocess\" style=\"display:none;\">");
echo("<div class=\"row\">");
echo($f->fields["manager_subprocess"]);
echo("         <div class=\"col-md-3\">");
echo("             <label for=\"submit_analisis\"></label>");
echo("             <div class=\"input-group\">");
echo("                <button id=\"submit_analisis\" style=\"margin-top: 4px;\" class=\"btn btn-primary btn-lg btn-block\" type=\"submit\">Actualizar</button>");
echo("             </div>");
echo("              <div class=\"help-block\"></div>");
echo("         </div>");
echo("    </div>");
echo("</form>");
echo("</div>");
echo("</div>");

if (!empty($plan["manager_subprocess"])) {
    echo("<div class=\"alert alert-primary bgc-primary-l3 brc-primary-m2 d-flex align-items-center\" role=\"alert\">");
    echo("<i class=\"fas fa-info-circle mr-3 fa-2x text-blue\"></i>");
    echo("<div style=\"width:100%;\">");
    echo("<form method=\"POST\" action=\"/disa/mipg/plans/team/{$plan["plan"]}\">");
    echo("<input type=\"hidden\" name=\"" . csrf_token() . "\" value=\"" . csrf_hash() . "\">");
    echo("<input type=\"hidden\" name=\"submited\" value=\"" . $f->get_fid() . "\" style=\"display:none;\">");
    echo("<input type=\"hidden\" name=\"{$f->get_fid()}_plan\" value=\"{$oid}\" style=\"display:none;\">");
    echo("<input type=\"hidden\" name=\"{$f->get_fid()}_option\" value=\"position\" style=\"display:none;\">");
    echo("<div class=\"row\">");
    echo($f->fields["manager_position"]);
    echo("         <div class=\"col-md-3\">");
    echo("             <label for=\"submit_actions\"></label>");
    echo("             <button id=\"submit_actions\" style=\"margin-top: 4px;\" class=\"btn btn-primary btn-lg btn-block\" type=\"submit\">Actualizar</button>");
    echo("         </div>");
    echo("    </div>");
    echo("</form>");
    echo("</div>");
    echo("</div>");
}
?>