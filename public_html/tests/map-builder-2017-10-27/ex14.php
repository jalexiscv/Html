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
$locations = array(
    array('Eifel Tower', 48.858278, 2.294254, '#FF7B6F', 'http://armdex.com/maps/eifel-tower.jpg', 120, 160),
    array('The Louvre', 48.8640411, 2.3360444, '#6BE337', 'http://armdex.com/maps/the-louvre.jpg', 160, 111),
    array('Musee d\'Orsay', 48.860181, 2.3249648, '#E6E325', 'http://armdex.com/maps/musee-dorsay.jpg', 160, 120),
    array('Jardin du Luxembourg', 48.8469529, 2.337285, '#61A1FF', 'http://armdex.com/maps/jardin-du-luxembourg.jpg', 160, 106),
    array('Promenade Plantee', 48.856614, 2.3522219, '#FF61E3', 'http://armdex.com/maps/promenade-plantee.jpg', 160, 120)
);
foreach ($locations as $i => $location) {
    $map->addMarker($location[1], $location[2], array(
        'title' => $location[0],
        'icon' => 'http://armdex.com/maps/icon' . ($i + 1) . '.png',
        'html' => '<div><img src="' . $location[4] . '" width="' . $location[5] . '" height="' . $location[6] . '" /></div><b>' . $location[0] . '</b>',
        'infoCloseOthers' => true,
        'draggable' => true
    ));
}

// Display the map.
$map->show();

?>

<script type="text/javascript" src="infobox_packed.js"></script>

<script type="text/javascript">

    function Label(opts) {
        this.setValues(opts);
        var span = this.span_ = document.createElement("span");
        span.style.cssText = "position:relative;left:-50%;top:1px;white-space:nowrap;border:1px solid #ffc11f;padding:3px;border-radius:5px;background-color:white";
        var div = this.div_ = document.createElement("div");
        div.appendChild(span);
        div.style.cssText = "position:absolute;display:none";
    };

    Label.prototype = new google.maps.OverlayView;

    Label.prototype.onAdd = function () {
        var pane = this.getPanes().overlayLayer;
        pane.appendChild(this.div_);
        var me = this;
        this.listeners_ = [
            google.maps.event.addListener(this, "position_changed", function () {
                me.draw();
            }),
            google.maps.event.addListener(this, "text_changed", function () {
                me.draw();
            })
        ];
    };

    Label.prototype.onRemove = function () {
        this.div_.parentNode.removeChild(this.div_);
        for (var i = 0, I = this.listeners_.length; i < I; ++i) {
            google.maps.event.removeListener(this.listeners_[i]);
        }
    };

    Label.prototype.draw = function () {
        var projection = this.getProjection();
        var position = projection.fromLatLngToDivPixel(this.get("position"));
        var div = this.div_;
        div.style.left = position.x + "px";
        div.style.top = position.y + "px";
        div.style.display = "block";
        this.span_.innerHTML = this.get("text").toString();
    };

    /*
    Create a JavaScript gag function which will be called after map initialization.
    The name of the function should be mbOnAfterInit().
    */
    function mbOnAfterInit(map) {
        for (var i = 0; i < markers.length; i++) {
            var label = new Label({
                map: map
            });
            label.bindTo("position", markers[i], "position");
            label.bindTo("text", markers[i], "title");

            if (infos[i] != null) {
                infobox = new InfoBox({
                    content: infos[i].content,
                    pixelOffset: new google.maps.Size(-100, -30),
                    zIndex: null,
                    alignBottom: true,
                    boxStyle: {
                        backgroundColor: "#ffffff",
                        opacity: 0.85,
                        width: "200px",
                        padding: "10px",
                        border: "1px solid #ffc11f",
                        borderRadius: "5px"
                    },
                    closeBoxMargin: "0px 4px 2px 2px",
                    closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
                    infoBoxClearance: new google.maps.Size(1, 1)
                });
                google.maps.event.clearListeners(markers[i], "click");
                google.maps.event.addListener(markers[i], "click", function () {
                    infobox.open(map, this);
                });
            }
        }
    }

</script>

</body>

</html>