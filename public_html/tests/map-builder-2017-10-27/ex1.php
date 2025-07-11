<?php

// Include MapBuilder class.
require_once 'class.MapBuilder.php';

// Create MapBuilder object.
$map = new MapBuilder();

// Set API key
$map->setApiKey('AIzaSyB230QxSetZoJiM9noon7FiAQXbc-HPSLU');

// Set map's center position by latitude and longitude coordinates. 
$map->setCenter(48.858278, 2.294254);

// Display the map.
$map->show();

?>