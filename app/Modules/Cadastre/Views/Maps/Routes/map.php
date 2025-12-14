<?php
$bootstrap = service('bootstrap');
//$customers lo recibe de la vista que lo contiene
$map = new App\Libraries\Maps();
$map->set_LatAndLngFields('latitude', 'longitude');

//$list = array();
foreach ($customers as $customer) {
    $latitude = $customer["latitude_decimal"] ?? 0;
    $longitude = $customer["longitude_decimal"] ?? 0;

    if (isset($customer['profile'])) {
        $link['view'] = base_url("cadastre/customers/view/{$customer['customer']}");
        $link['edit'] = base_url("cadastre/customers/edit/{$customer['customer']}");
        $html = "<div class='row'>"
            . "<div class='col-12'>"
            . "<b>Matricula</b>: {$customer['registration']}<br>"
            . "<b>Nombre</b>:{$customer['names']}<br>"
            . "<b>Dirección</b>:{$customer['address']}"
            . "</div>"
            . "</div>"
            . "<div class='row'>"
            . "<div class='col-12 p-3'>"
            . "<div class='btn-group'>"
            . "<a href='{$link['view']}' class='btn btn-sm btn-primary' target='_blank'><i class='fa fa-eye'></i></a>"
            . "<a href='{$link['edit']}' class='btn btn-sm btn-warning' target='_blank'><i class='fa fa-edit'></i></a>"
            . "</div>"
            . "<div class='row'>"
            . "<div class='col-12 p-3'>"
            . "{$customer['georeference']}: {$latitude} | {$longitude}"
            . "</div>"
            . "</div>";

        $map->add_Marker($latitude, $longitude, array(
                'title' => str_replace(array("\r", "\n"), '', $customer['registration']),
                //'defColor' => '#FA6D6D',
                //'defSymbol' => $customer['route_sequence'],
                'infoMaxWidth' => 245,
                'infoCloseOthers' => true,
                'html' => str_replace(array("\r", "\n"), '', $html),
            )
        );
    }
}
$map->set_Center("3.9009", "-76.2969");
$map->set_Zoom(16);

$card = $bootstrap->get_Card("option-" . lpk(), array(
    "class" => "mb-3",
    "header-back" => "/cadastre/maps/home/" . lpk(),
    "title" => "Mapa de la ruta #{$route}",
    "text-class" => "text-center",
    "content" => $map,
));

echo($card);
?>