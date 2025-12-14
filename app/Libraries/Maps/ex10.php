<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="content-style-type" content="text/css"/>
    <meta http-equiv="content-script-type" content="text/javascript"/>
    <meta http-equiv="imagetoolbar" content="no"/>

    <title>Map Builder Example</title>

</head>

<body>

<?php

// Include MapBuilder class.
require_once 'class.MapBuilder.php';

// Create MapBuilder object.
$map = new MapBuilder();

// Set API key
$map->setApiKey('AIzaSyB230QxSetZoJiM9noon7FiAQXbc-HPSLU');

// Set map's center position by latitude and longitude coordinates. 
$map->setCenter(48.860181, 2.3249648);

// Set the default map type.
$map->setMapTypeId(MapBuilder::MAP_TYPE_ID_ROADMAP);

// Set width and height of the map.
$map->setSize(860, 550);

// Set default zoom level.
$map->setZoom(14);

// Make zoom control compact.
$map->setZoomControlStyle(MapBuilder::ZOOM_CONTROL_STYLE_SMALL);

// Define locations and add markers with custom icons and attached info windows.
// Extract points from locations to draw 2 polylines.
$locations = array(
    array('Eifel Tower', 48.858278, 2.294254, '#FF7B6F', 'http://armdex.com/maps/eifel-tower.jpg', 120, 160),
    array('The Louvre', 48.8640411, 2.3360444, '#6BE337', 'http://armdex.com/maps/the-louvre.jpg', 160, 111),
    array('Musee d\'Orsay', 48.860181, 2.3249648, '#E6E325', 'http://armdex.com/maps/musee-dorsay.jpg', 160, 120),
    array('Jardin du Luxembourg', 48.8469529, 2.337285, '#61A1FF', 'http://armdex.com/maps/jardin-du-luxembourg.jpg', 160, 106),
    array('Promenade Plantee', 48.856614, 2.3522219, '#FF61E3', 'http://armdex.com/maps/promenade-plantee.jpg', 160, 120)
);
$path1 = $path2 = array();
foreach ($locations as $i => $location) {
    if ($i < 3) {
        $path1[] = array($location[1], $location[2]);
    } else {
        $path2[] = array($location[1], $location[2]);
    }
    $map->addMarker($location[1], $location[2], array(
        'title' => $location[0],
        'icon' => 'http://armdex.com/maps/icon' . ($i + 1) . '.png',
        'html' => '<div><img src="' . $location[4] . '" width="' . $location[5] . '" height="' . $location[6] . '" /></div><b>' . $location[0] . '</b>',
        'infoCloseOthers' => true
    ));
}

// Add polylines by providing array of points, stroke color, weight and opacity.
$map->addPolyline($path1, '#ff0000', 2, 1.0);
$map->addPolyline($path2, '#00ff00', 10, 0.5);

// Display the map.
$map->show();

?>

</body>

</html>