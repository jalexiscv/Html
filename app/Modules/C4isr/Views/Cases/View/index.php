<?php
ini_set('max_execution_time', 600);
$strings = service('strings');
/*
* -----------------------------------------------------------------------------
* [Vars]
* -----------------------------------------------------------------------------
*/
$data = $parent->get_Array();
$data['model'] = model("App\Modules\C4isr\Models\C4isr_Cases");
$data['permissions'] = array('singular' => 'c4isr-cases-view', "plural" => 'c4isr-cases-view-all');
$data['processors'] = $component . '\Processors';
$singular = $authentication->has_Permission($data['permissions']['singular']);
$plural = $authentication->has_Permission($data['permissions']['plural']);
$author = $data['model']->get_Authority($oid, $authentication->get_User());
$authority = ($singular && $author) ? true : false;
$submited = $request->getVar("submited");
$header = $component . '\breadcrumb';
$validator = $component . '\validator';
$formbreaches = $component . '\Forms\breaches';
$formosints = $component . '\Forms\osints';
$formcveweb = $component . '\Forms\cveweb';
$formdarkweb = $component . '\Forms\darkweb';
$deny = $component . '\deny';
$incidents = $component . '\incidents';
$case = $data['model']->find($oid);
$type = $strings->get_Strtolower($case["type"]);
/*
* -----------------------------------------------------------------------------
* [Evaluate]
* -----------------------------------------------------------------------------
*/
if ($plural || $authority) {
    if (!empty($submited)) {
        $c = view($validator, $data);
    } else {
        if ($type == "databreaches") {
            $c = view($formbreaches, $data);
            $c .= view($incidents, $data);
        } elseif ($type == "osints") {
            $c = view($formosints, $data);
            $c .= view($incidents, $data);
        } elseif ($type == "cveweb") {
            $c = view($formcveweb, $data);
            $c .= view($incidents, $data);
        } elseif ($type == "darkweb") {
            $c = view($formdarkweb, $data);
            $c .= view($incidents, $data);
        } else {
            $c = view($deny, $data);
        }

    }
} else {
    $c = view($deny, $data);
}
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/

session()->set('page_template', 'page');
session()->set('page_header', view($header, $data));
session()->set('main_template', 'c9c3');
session()->set('right', get_c4isr_case($oid));
session()->set('messenger', true);
session()->set('main', $c);
?>