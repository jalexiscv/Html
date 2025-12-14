<?php

//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
$massets = model("App\Modules\Maintenance\Models\Maintenance_Assets");
$msheets = model("App\Modules\Maintenance\Models\Maintenance_Sheets");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Maintenance_Assets."));
$d = array(
    "asset" => $f->get_Value("asset"),
    "name" => $f->get_Value("name"),
    "reference"=>$f->get_Value("reference"),
    "fixedcode"=>$f->get_Value("fixedcode"),
    "type" => $f->get_Value("type"),
    "status" => $f->get_Value("status"),
    "description" => $f->get_Value("description"),
    "author" => safe_get_user(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["asset"]);
$l["back"] = $f->get_Value("back");
$l["edit"] = "/maintenance/assets/edit/{$d["asset"]}";
$asuccess = "maintenance/assets-edit-success-message.mp3";
$anoexist = "maintenance/assets-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['asset'], $d);
    if ($d["type"] == "VEHICLE") {
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "license_plate", "value" => $f->get_Value("license_plate")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "vehicle_brand", "value" => $f->get_Value("vehicle_brand")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "vehicle_line", "value" => $f->get_Value("vehicle_line")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "engine_displacement", "value" => $f->get_Value("engine_displacement")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "vehicle_model", "value" => $f->get_Value("vehicle_model")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "vehicle_class", "value" => $f->get_Value("vehicle_class")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "body_type", "value" => $f->get_Value("body_type")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "doors_number", "value" => $f->get_Value("doors_number")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "engine_number", "value" => $f->get_Value("engine_number")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "serial_document", "value" => $f->get_Value("serial_document")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "chassis_number", "value" => $f->get_Value("chassis_number")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "document_number", "value" => $f->get_Value("document_number")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "tonnage_capacity", "value" => $f->get_Value("tonnage_capacity")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "city", "value" => $f->get_Value("city")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "passengers", "value" => $f->get_Value("passengers")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "document_date", "value" => $f->get_Value("document_date")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "vehicle_function", "value" => $f->get_Value("vehicle_function")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "authorized_drivers", "value" => $f->get_Value("authorized_drivers")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "maintenance_manager", "value" => $f->get_Value("maintenance_manager")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "photo_url", "value" => $f->get_Value("photo_url")));
    } else{
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "entry_date", "value" => $f->get_Value("entry_date")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "location", "value" => $f->get_Value("location")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "code", "value" => $f->get_Value("code")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "brand", "value" => $f->get_Value("brand")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "serial_number", "value" => $f->get_Value("serial_number")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "voltage", "value" => $f->get_Value("voltage")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "amperage", "value" => $f->get_Value("amperage")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "frequency", "value" => $f->get_Value("frequency")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "power", "value" => $f->get_Value("power")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "model", "value" => $f->get_Value("model")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "rpm", "value" => $f->get_Value("rpm")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "operation_hours", "value" => $f->get_Value("operation_hours")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "other_specifications", "value" => $f->get_Value("other_specifications")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "document_type", "value" => $f->get_Value("document_type")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "document_location", "value" => $f->get_Value("document_location")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "equipment_function", "value" => $f->get_Value("equipment_function")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "authorized_personnel", "value" => $f->get_Value("authorized_personnel")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "maintenance_manager", "value" => $f->get_Value("maintenance_manager")));
        $msheets->insert(array("sheet" => pk(), "asset" => $d["asset"], "name" => "observations", "value" => $f->get_Value("observations")));
    }

    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Maintenance_Assets.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Maintenance_Assets.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Maintenance_Assets.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Maintenance_Assets.edit-noexist-message"), $d['asset']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>