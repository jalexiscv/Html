<?php


//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication =service('authentication');
$f = service("forms",array("lang" => "Maintenance_Assets."));
//[Request]-----------------------------------------------------------------------------
$row= $model->getAsset($oid);
$r["asset"] =$row["asset"];
$r["name"] =$row["name"];
$r["type"] =$row["type"];
$r["status"] =$row["status"];
$r["description"] =$row["description"];
$r["created_at"] =$row["created_at"];
$r["updated_at"] =$row["updated_at"];
$r["deleted_at"] =$row["deleted_at"];
$r["author"] =$row["author"];
$back= "/maintenance/assets/list/".lpk();
//[Fields]-----------------------------------------------------------------------------
if($r["type"]=="VEHICLE"){
    include("Types/vehicle.php");
}else{
    include("Types/equipment.php");
}
?>