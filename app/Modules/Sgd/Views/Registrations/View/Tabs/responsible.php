<?php

/** @var array $row viene de tabs y es una consulta sobre el modelo **/

//[Services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication =service('authentication');
//[modules]-------------------------------------------------------------------------------------------------------------
$mfields = model("App\Modules\Sgd\Models\Sgd_Users_Fields");
//[vars]----------------------------------------------------------------------------------------------------------------
$f = service("forms",array("lang" => "Sgd_Registrations."));
$responsible_fullname=$mfields->get_FullName($row["author"]);
//[Request]-------------------------------------------------------------------------------------------------------------
$r["date"] =$row["date"];
$r["time"] =$row["time"];
$r["author"] =$row["author"];
$r["author_name"] =$responsible_fullname;
$back= "/sgd/registrations/list/".lpk();
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["date"] = $f->get_FieldView("date", array("value" => $r["date"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldView("time", array("value" => $r["time"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["author"] = $f->get_FieldView("author", array("value" => $r["author"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["author_name"] = $f->get_FieldView("author_name", array("value" => $r["author_name"],"proportion"=>"col-12"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["gr1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["date"].$f->fields["time"].$f->fields["author"])));
$f->groups["gr2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["author_name"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
//$f->groups["gy"] =$f->get_GroupSeparator();
//$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["edit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
echo($f);
?>