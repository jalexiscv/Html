<?php

//[Services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication =service('authentication');
$f = service("forms",array("lang" => "Sgd_Registrations."));
//[Models]--------------------------------------------------------------------------------------------------------------
$musers = model('App\Modules\Sgd\Models\Sgd_Users');
//[Request]-------------------------------------------------------------------------------------------------------------
$row= $model->getRegistration($oid);
$r["registration"] =$row["registration"];
$r["reference"] =$row["reference"];
$r["observations"] =$row["observations"];
$r["date"] =$row["date"];
$r["qrcode"] =$row["qrcode"];
$r["time"] =$row["time"];
$r["author"] =$row["author"];
$r["created_at"] =$row["created_at"];
$r["updated_at"] =$row["updated_at"];
$r["deleted_at"] =$row["deleted_at"];
$r["from"] =@$row["from_name"];
$r["from_user"] =@$row["from_user"];
$r["to"] =@$row["to_name"];
$r["to_user"] =@$row["to_user"];

$back= "/sgd/registrations/list/".lpk();

$from=$r["from"];
if(!empty($r["from_user"])){
    $from_profile = $musers->getProfile($r["from_user"]);
    $fullname = @$from_profile["firstname"]." ".@$from_profile["lastname"];
    $from=safe_strtoupper($fullname);
}

$to=$r["to"];
if(!empty($r["to_user"])){
    $to_profile = $musers->getProfile($r["to_user"]);
    $fullname = @$to_profile["firstname"]." ".@$to_profile["lastname"];
    $to=safe_strtoupper($fullname);
}


//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["registration"] = $f->get_FieldView("registration", array("value" => $r["registration"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["observations"] = $f->get_FieldView("observations", array("value" => $r["observations"],"proportion"=>"col-12"));
$f->fields["reference"] = $f->get_FieldView("reference", array("value" => $r["reference"],"proportion"=>"col-12"));

$f->fields["from"] = $f->get_FieldView("from", array("value" => $from,"proportion"=>"col-md-9 col-12"));
$f->fields["from_user"] = $f->get_FieldView("from_user", array("value" => $r["from_user"],"proportion"=>"col-md-3 col-12"));

$f->fields["to"] = $f->get_FieldView("to", array("value" => $to,"proportion"=>"col-md-9 col-12"));
$f->fields["to_user"] = $f->get_FieldView("to_user", array("value" => $r["to_user"],"proportion"=>"col-md-3 col-12"));

$f->fields["date"] = $f->get_FieldView("date", array("value" => $r["date"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["qrcode"] = $f->get_FieldView("qrcode", array("value" => $r["qrcode"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldView("time", array("value" => $r["time"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author",$r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] =$f->get_Button("edit", array("href" =>"/sgd/registrations/edit/".$oid,"text" =>lang("App.Edit"),"class"=>"btn btn-secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["registration"].$f->fields["date"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["reference"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["from"].$f->fields["from_user"])));
$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["to"].$f->fields["to_user"])));
$f->groups["g5"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["observations"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
//$f->groups["gy"] =$f->get_GroupSeparator();
//$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["edit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
echo($f);
?>