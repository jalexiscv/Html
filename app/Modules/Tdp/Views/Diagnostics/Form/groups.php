<?php
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["diagnostic"] . $f->fields["line"] . $f->fields["order"] . $f->fields["version"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["name"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
?>