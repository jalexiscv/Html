<?php

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication =service('authentication');
$f = service("forms",array("lang" => "Categories."));
//[Variables]-----------------------------------------------------------------------------------------------------------
$mcategories = model('App\Modules\Standards\Models\Standards_Categories');
//[Request]-------------------------------------------------------------------------------------------------------------
$row= $mcategories->getCategory($oid);

$r["category"] =$row["category"];
$r["name"] =$row["name"];
$r["description"] =$row["description"];
$r["author"] =$row["author"];
$r["date"] =$row["date"];
$r["time"] =$row["time"];
$r["created_at"] =$row["created_at"];
$r["updated_at"] =$row["updated_at"];
$r["deleted_at"] =$row["deleted_at"];
$back= "/standards/categories/list/".lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["category"] = $f->get_FieldView("category", array("value" => $r["category"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldView("name", array("value" => $r["name"],"proportion"=>"col-md-8 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldView("description", array("value" => $r["description"],"proportion"=>"col-12"));
$f->add_HiddenField("author",$r["author"]);
$f->fields["date"] = $f->get_FieldView("date", array("value" => $r["date"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldView("time", array("value" => $r["time"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] =$f->get_Button("edit", array("href" =>"/standards/categories/edit/".$oid,"text" =>lang("App.Edit"),"class"=>"btn btn-secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["category"].$f->fields["name"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["description"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["edit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
		"header-title" => lang("Categories.view-title"),
		"header-back" => $back,
		"content" => $f,
));
echo($card);
?>