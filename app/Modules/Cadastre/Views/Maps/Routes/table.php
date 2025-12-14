<?php
$bootstrap = service('bootstrap');

$thcount = $bootstrap->get_Th('thcount', array('content' => 'N°', 'class' => 'text-center'));
$thcustomer = $bootstrap->get_Th('thcustomer', array('content' => lang('App.Customer'), 'class' => 'text-center'));
$thregistration = $bootstrap->get_Th('thregistration', array('content' => lang('App.Registration'), 'class' => 'text-center'));
$thfirstname = $bootstrap->get_Th('thfirstname', array('content' => lang('App.Firstname'), 'class' => 'text-start'));
//$thlastname = $bootstrap->get_Th('thlastname', array('content' => lang('App.Lastname'), 'class' => 'text-start'));
$thcycle = $bootstrap->get_Th('thcycle', array('content' => lang('App.Cycle'), 'class' => 'text-center'));
$throute = $bootstrap->get_Th('threading_route', array('content' => lang('App.Route'), 'class' => 'text-center'));
//$thlatitude = $bootstrap->get_Th('thlatitude', array('content' => lang('App.Latitude'), 'class' => 'text-center'));
//$thlongitude = $bootstrap->get_Th('thlongitude', array('content' => lang('App.Longitude'), 'class' => 'text-center'));
$thoptions = $bootstrap->get_Th('thoptions', array('content' => lang('App.Options'), 'class' => 'text-center'));
$trheader = $bootstrap->get_Tr('trheader', array('content' => $thcount . $thcustomer . $thregistration . $thfirstname . $thcycle . $thoptions, 'class' => 'text-center'));

$rows = "";
$count = 0;
foreach ($customers as $customer) {
    $count++;
    //$latitude = substr($customer['latitude'], 0, 6);
    //$longitude = substr($customer['longitude'], 0, 6);
    $latitude = $customer['latitude_decimal'];
    $longitude = $customer['longitude_decimal'];
    //[btns]------------------------------------------------------------------------------------------------------------
    $btnView = $bootstrap->get_Link('btnView', array('icon' => ICON_VIEW, 'content' => lang('App.View'), 'class' => 'btn btn-primary', 'href' => "/cadastre/customers/view/{$customer['customer']}", 'target' => "_blank"));
    $btnGeo = $bootstrap->get_Link('btnGeo', array('icon' => ICON_GEO, 'content' => "Geo", 'class' => 'btn btn-secondary', 'href' => "/cadastre/customers/geo/{$customer['customer']}", 'target' => "_blank"));
    $btns = $bootstrap->get_BtnGroup('btnGroup', array('content' => $btnView . $btnGeo));
    //[cols]------------------------------------------------------------------------------------------------------------
    $details = "";
    $details .= "<div class=\"fs-6 lh-1 p-2\">" . @$customer['names'] . "</br>";
    $details .= "<b>Dirección</b>: " . @$customer['address'] . "</br>";
    $details .= "<b>Latitud</b>: {$latitude} | <b>Longitud</b>: {$longitude} ";
    $details .= "</div>";
    $tdcount = $bootstrap->get_Td('tdcount', array('content' => $count, 'class' => 'text-center'));
    $tdcustomer = $bootstrap->get_Td('tdcustomer', array('content' => $customer['customer'], 'class' => 'text-center'));
    $tdregistration = $bootstrap->get_Td('tdregistration', array('content' => @$customer['registration'], 'class' => 'text-center'));
    $tdfirstname = $bootstrap->get_Td('tdfirstname', array('content' => $details, 'class' => 'text-start'));
    //$tdlastname = $bootstrap->get_Td('tdlastname', array('content' => @$customer['lastname'], 'class' => 'text-start'));
    $tdcycle = $bootstrap->get_Td('tdcycle', array('content' => @$customer['cycle'], 'class' => 'text-center'));
    $tdroute = $bootstrap->get_Td('tdreading_route', array('content' => @$customer['reading_route'], 'class' => 'text-center'));
    //$tdlatitude = $bootstrap->get_Td('tdlatitude', array('content' => $latitude, 'class' => 'text-center'));
    //$tdlongitude = $bootstrap->get_Td('tdlongitude', array('content' => $longitude, 'class' => 'text-center'));
    $tdoptions = $bootstrap->get_Td('tdoptions', array('content' => $btns, 'class' => 'text-center'));
    $posicion = false;
    if (!empty(@$customer['address'])) {
        $posicion = strpos(@$customer['address'], "RET");
    }
    if ($posicion !== false) {
        $tr = $bootstrap->get_Tr('trcontent', array('content' => $tdcount . $tdcustomer . $tdregistration . $tdfirstname . $tdcycle . $tdoptions, 'class' => 'text-center bg-warning'));
    } else {
        if (!empty($latitude) && !empty($longitude)) {
            $tr = $bootstrap->get_Tr('trcontent', array('content' => $tdcount . $tdcustomer . $tdregistration . $tdfirstname . $tdcycle . $tdoptions, 'class' => 'text-center'));
        } else {
            $tr = $bootstrap->get_Tr('trcontent', array('content' => $tdcount . $tdcustomer . $tdregistration . $tdfirstname . $tdcycle . $tdoptions, 'class' => 'text-center bg-danger'));
        }
    }
    $rows .= $tr;
}
$table = $bootstrap->get_Table('customers', array('content' => $trheader . $rows, 'class' => 'table table-bordered '));
//[build]-----------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("option-" . lpk(), array(
    "class" => "mb-3 table-responsive",
    "title" => "Clientes en la ruta #{$route}",
    "header-back" => "/cadastre/maps/home/" . lpk(),
    "text-class" => "text-center",
    "content" => $table,
));
echo($card);


?>