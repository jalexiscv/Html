<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="content-style-type" content="text/css"/>
    <meta http-equiv="content-script-type" content="text/javascript"/>
    <meta http-equiv="imagetoolbar" content="no"/>

    <title>Map Builder Example</title>

    <script type="text/javascript">
        /*
        Create a JavaScript gag function which will be called after map initialization.
        The name of the function should be mbOnAfterInit().
        */
        function mbOnAfterInit(map) {
            var directionsDisplay = new google.maps.DirectionsRenderer();
            var directionsService = new google.maps.DirectionsService();
            directionsDisplay.setMap(map);
            var request = {
                origin: "Eifel Tower, Paris, France",
                destination: "Promenade Plantee, Paris, France",
                waypoints: [{
                    location: "Jardin du Luxembourg, Paris, France",
                    stopover: true
                }, {
                    location: "Musee d'Orsay, Paris, France",
                    stopover: true
                }, {
                    location: "The Louvre, Paris, France",
                    stopover: true
                }],
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode["DRIVING"]
            };
            directionsService.route(request, function (result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(result);
                } else {
                    alert("Sorry, we couldn't route from your location!");
                }
            });
        }
    </script>

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

// Display the map.
$map->show();

?>

</body>

</html>