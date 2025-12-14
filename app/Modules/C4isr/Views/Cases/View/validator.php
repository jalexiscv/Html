<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Cases\Editor\validator.php]
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
$mcases = model("App\Modules\C4isr\Models\C4isr_Cases");
$f = service("forms", array("lang" => "Cases."));
/*
* -----------------------------------------------------------------------------
* [Request]
* -----------------------------------------------------------------------------
*/
$formbreaches = $component . '\Forms\breaches';
$formosints = $component . '\Forms\osints';
$formcveweb = $component . '\Forms\cveweb';
$case = $mcases->find($oid);
$type = $strings->get_Strtolower($case["type"]);

$country = $f->get_Value("country");
$identifier = $f->get_Value("identifier");
$search = $f->get_Value("search");

if ($type == "osints") {
    $f->set_ValidationRule("case", "required");
    $f->set_ValidationRule("country", "trim|required");
    $f->set_ValidationRule("identifier", "trim|required");

    if ($identifier == "CSC") {
        $f->set_ValidationRule("search", "trim|required|numeric");
    } elseif ($identifier == "PHONE") {
        if ($country == "CO") {
            $f->set_ValidationRule("search", "trim|required|numeric|min_length[10]|max_length[12]");
        } elseif ($country == "VE") {
            $f->set_ValidationRule("search", "trim|required|numeric|min_length[11]|max_length[13]");
        } else {
            $f->set_ValidationRule("search", "trim|required|numeric|min_length[10]|max_length[12]");
        }
    } elseif ($identifier == "EMAIL") {
        $f->set_ValidationRule("search", "trim|required|valid_email");
    } else {
        $f->set_ValidationRule("search", "trim|required");
    }

} elseif ($type == 'databreaches') {
    $f->set_ValidationRule("case", "required");
    $f->set_ValidationRule("search", "trim|required");
} elseif ($type == 'cveweb') {
    $f->set_ValidationRule("case", "required");
    $query = $f->get_Value("query");
    if (empty($query)) {
        $f->set_ValidationRule("country", "required");
        $f->set_ValidationRule("explore", "required");
        $explore = $f->get_Value("explore");
        if ($explore == 'vulnerability') {
            $f->set_ValidationRule("variant", "required");
        } elseif ($explore == 'authentication') {
            $f->set_ValidationRule("variant", "required");
        } elseif ($explore == 'service') {
            $f->set_ValidationRule("variant", "required");
        } elseif ($explore == 'domain') {
            $f->set_ValidationRule("domain", "trim|required");
        } elseif ($explore == 'ip') {
            $f->set_ValidationRule("domain", "trim|required");
        }
    } else {

    }
} elseif ($type == 'darkweb') {
    $f->set_ValidationRule("case", "required");
    $f->set_ValidationRule("query", "required");
} else {
    echo($type);
    //$f->set_ValidationRule("case", "required");
    //$f->set_ValidationRule("search", "trim|required");
}


/*
* -----------------------------------------------------------------------------
* [Validation]
* -----------------------------------------------------------------------------
*/
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $errors = $f->validation->listErrors();
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Cases.view-errors-title"));
    $smarty->assign("message", lang("Cases.view-errors-message"));
    $smarty->assign("errors", $errors);
    $smarty->assign("continue", null);
    $smarty->assign("voice", "c4isr/cases-view-errors-message.mp3");
    $c = $smarty->view('alerts/card/danger.tpl');
    if ($type == "databreaches") {
        $c .= view($formbreaches, $parent->get_Array());
    } elseif ($type == "osints") {
        $c .= view($formosints, $parent->get_Array());
    } elseif ($type == "cveweb") {
        $c .= view($formcveweb, $parent->get_Array());
    } else {

    }
}
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
echo($c);
?>