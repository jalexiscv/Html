<?php
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Cases."));
$case = $f->get_Value('case');
$country = $f->get_Value('country');
$identifier = $f->get_Value('identifier');
$search = $f->get_Value('search');

$grid = $bootstrap->get_Grid();
$grid->set_Id("table-" . pk());
$grid->set_Headers(array("Campo", "Valor"));
$grid->add_Row(array("Case", $case));
$grid->add_Row(array("Country", $country));
$grid->add_Row(array("Identifier", $identifier));
$grid->add_Row(array("Search", $search));
echo($grid);

$data = array(
    'case' => $case,
    'country' => $country,
    'identifier' => $identifier,
    'search' => $search
);
if ($identifier == "CSC") {
    $c = view('App\Modules\C4isr\Views\Cases\View\Processors\sints\identifications', $data);
} elseif ($identifier == "PHONE") {
    $c = view('App\Modules\C4isr\Views\Cases\View\Processors\sints\phones', $data);
} elseif ($identifier == "EMAIL") {
    $c = view('App\Modules\C4isr\Views\Cases\View\Processors\sints\mails', $data);
} elseif ($identifier == "DOMAIN") {
    $c = view('App\Modules\C4isr\Views\Cases\View\Processors\sints\domains', $data);
} else {
    echo("Identificador desconocido: {$identifier}");
}
echo($c);
?>