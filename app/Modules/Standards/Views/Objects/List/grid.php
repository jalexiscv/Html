<?php
//[models]--------------------------------------------------------------------------------------------------------------
$mobjects = model('App\Modules\Standards\Models\Standards_Objects');
$mcategories = model('App\Modules\Standards\Models\Standards_Categories');

$object = $mobjects->get_Object($oid);

if(@$object["type_content"] == "HEATCHARTS"){
    include("heatcharts.php");
}else{
    if(safe_strtoupper(@$object["type_node"])=="Y"){
        include("activities.php");
    }else{
        include("general.php");
    }
}


?>