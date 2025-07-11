<?php
if (isset($_POST['lat']) && isset($_POST['lng'])) {
    $lat = floatval($_POST['lat']);
    $lng = floatval($_POST['lng']);
    // do something...
    die($lat . ' ' . $lng);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Maps Test</title>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
        function mbOnAfterLocationDetected(lat, lng) {
            $.post("ex15.php", {lat: lat, lng: lng});
            alert(lat + ' ' + lng);
        }
    </script>
</head>
<body>
<?php
require_once 'class.MapBuilder.php';
$map = new MapBuilder('', 'AIzaSyB230QxSetZoJiM9noon7FiAQXbc-HPSLU');
$map->overrideCenterByGeo(true);
$map->addGeoMarker();
$map->show();
?>
</body>
</html>

