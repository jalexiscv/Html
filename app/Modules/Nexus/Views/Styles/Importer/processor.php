<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Styles\Creator\processor.php]
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
$f = service("forms", array("lang" => "Nexus.styles-"));
$model = model("App\Modules\Nexus\Models\Nexus_Styles");

$theme = $f->get_Value("theme");
$importer = $f->get_Value("importer");
$resolution = $f->get_Value("resolution");
$code = $f->get_Value("code");


$l["back"] = "/nexus/styles/list/" . $theme;

$c = "";
$c .= ("<pre>");
//print (parse_css_template($d["default"],"xx"));


$dynamic_css = $code;
$css_id_preface = "XX";
//$dynamic_css = str_replace('{{', '[[', $dynamic_css);
//$dynamic_css = str_replace('}}', ']]', $dynamic_css);
/* End new parse */
$oParser = new App\Libraries\Css\Parser($dynamic_css);
$oCss = $oParser->parse();

$styles = array();
foreach ($oCss->getAllDeclarationBlocks() as $oBlock) {
    $selector = "";
    $rules = "";
    $count = 0;
    foreach ($oBlock->getSelectors() as $oSelector) {
        $count++;
        $oSelector->setSelector($oSelector->getSelector());
        //echo("<b>Selector</b>: " . $oSelector->__toString() . " <b>Content</b>: " . "" . " \n");
        if ($count > 1) {
            $selector .= "," . $oSelector->__toString();
        } else {
            $selector .= $oSelector->__toString();
        }
    }
    //echo("Selector\n".$selector."\n");
    foreach ($oBlock->getRules() as $rule) {
        //echo("-><b>Rule</b>: " . $rule->__toString() . " <b>Content</b>: " . "" . " \n");
        $rules .= $rule->__toString() . "\n";
    }
    //echo("--Rules\n".$rules);
    array_push($styles, array("selector" => $selector, "rules" => $rules));
}


foreach ($styles as $style) {
    //print_r($style);
    $d = array(
        "style" => pk(),
        "theme" => $theme,
        "selectors" => urlencode($style["selector"]),
        $f->get_Value("resolution") => urlencode($style["rules"]),
        "date" => $f->get_Value("date"),
        "time" => $f->get_Value("time"),
        "author" => $authentication->get_User(),
        "importer" => $importer,
    );

    $row = $model->where("selectors", $d["selectors"])->where("theme", $d["theme"])->first();
    $c .= ("Buscando");
    print_r($row);
    if (is_array($row) && count($row) > 0) {
        $c .= ("Existe!");
        if (isset($d["default"]) && !empty($row["default"])) {
            $d["default"] = $row["default"] . $d["default"];
        }
        if (isset($d["xxl"]) && !empty($row["xxl"])) {
            $d["xxl"] = $row["xxl"] . $d["xxl"];
        }
        if (isset($d["xl"]) && !empty($row["xl"])) {
            $d["xl"] = $row["xl"] . $d["xl"];
        }
        if (isset($d["lg"]) && !empty($row["lg"])) {
            $d["lg"] = $row["lg"] . $d["lg"];
        }
        if (isset($d["md"]) && !empty($row["md"])) {
            $d["md"] = $row["md"] . $d["md"];
        }
        if (isset($d["sm"]) && !empty($row["sm"])) {
            $d["sm"] = $row["sm"] . $d["sm"];
        }
        if (isset($d["xs"]) && !empty($row["xs"])) {
            $d["xs"] = $row["xs"] . $d["xs"];
        }
        $d["style"] = $row["style"];
        $edit = $model->update($d['style'], $d);
    } else {
        $c .= ("No existe!");
        //print_r($d);
        $create = $model->insert($d);
    }
}


$dynamic_css = $oCss->__toString();
//$dynamic_css = str_replace('[[', '{{', $dynamic_css);
//$dynamic_css = str_replace(']]', '}}', $dynamic_css);

$c .= ("</pre>");

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("title", lang("Nexus.styles-create-success-title"));
$smarty->assign("message", sprintf(lang("Nexus.styles-create-success-message"), $d['style']));
//$smarty->assign("edit", $l["edit"]);
$smarty->assign("continue", $l["back"]);
$smarty->assign("voice", "application/styles-create-success-message.mp3");
$c .= $smarty->view('alerts/card/success.tpl');


/*
$row = $model->find($d["style"]);
$l["back"]="/nexus/styles/list/".lpk();
$l["edit"]="/nexus/styles/edit/{$d["style"]}";
if (isset($row["style"])) {
   $smarty = service("smarty");
   $smarty->set_Mode("bs5x");
   $smarty->assign("title", lang("Nexus.styles-create-duplicate-title"));
   $smarty->assign("message", lang("Nexus.styles-create-duplicate-message"));
   $smarty->assign("continue",$l["back"]);
   $smarty->assign("voice","application/styles-create-duplicate-message.mp3");
   $c=$smarty->view('alerts/card/warning.tpl');
}else {
   $create = $model->insert($d);

   $smarty = service("smarty");
   $smarty->set_Mode("bs5x");
   $smarty->assign("title", lang("Nexus.styles-create-success-title"));
   $smarty->assign("message", sprintf(lang("Nexus.styles-create-success-message"),$d['style']));
   //$smarty->assign("edit", $l["edit"]);
   $smarty->assign("continue", $l["back"]);
   $smarty->assign("voice","application/styles-create-success-message.mp3");
   $c=$smarty->view('alerts/card/success.tpl');
}
*/
echo($c);

?>