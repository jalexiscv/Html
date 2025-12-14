<?php

/** @var string $oid */
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Sie_Registrations."));
$r = service("request");
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Registrations");
$mprogams = model("App\Modules\Sie\Models\Sie_Programs");
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mobservations = model("App\Modules\Sie\Models\Sie_Observations");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
//[vars]----------------------------------------------------------------------------------------------------------------
$data = $r->getJSON();
$object = $data->object;

// Existen dos permisos para observaciones, uno con accesso a observaciones propias "sie-observations-view" y otro
// con acceso a todas las observaciones "sie-observations-view-all"
$authentication = service("authentication");
$singular = $authentication->has_Permission("SIE-OBSERVATIONS-VIEW");
$plural = $authentication->has_Permission("SIE-OBSERVATIONS-VIEW-ALL");
//echo("<br>SINGULAR $singular PLURAL $plural");

if ($plural) {
    $observations = $mobservations->get_Observations(1000, 0, array("object" => $oid));
} else {
    $observations = $mobservations->get_Observations(1000, 0, array("object" => $oid, "author" => safe_get_user()));
}


$bgrid = $b->get_Grid();
$bgrid->set_Id("sie-student-observations-list");
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center  align-middle"),
    //array("content" => "Código", "class" => "text-center align-middle"),
    //array("content" => "Author", "class" => "text-center align-middle"),
    //array("content" => "Contenido", "class" => "text-center align-middle"),
    array("content" => "Detalle", "class" => "text-center align-middle"),
    //array("content" => "Fecha", "class" => "text-center align-middle"),
    //array("content" => "Hora", "class" => "text-center align-middle"),
    array("content" => "Opciones", "class" => "text-center  align-middle"),
));

$count = 0;
if (is_array($observations)) {
    foreach ($observations as $observation) {
        $count++;
        $types = LIST_TYPES_OBSERVATIONS;
        $code = $observation["observation"];
        $author = $observation["author"];
        $content = $observation["content"];
        $type = $observation["type"];
        $author = $observation["author"];
        $puser = $mfields->get_Profile($author);
        $author_name = $puser["name"] . " - <span class='fst-italic opacity-1'>{$observation["author"]}</span>";

        foreach ($types as $t) {
            if ($t['value'] == $type) {
                $type = $t['label'];
            }
        }


        //[buttons]-----------------------------------------------------------------------------------------------------
        $deleter = "#";
        $leditor = $b::get_Link('editor', array('href' => "#", 'icon' => ICON_EDIT, 'text' => "", 'class' => 'btn-secondary', 'onclick' => "confirmEditObservation('{$observation['observation']}');"));
        $ldeleter = $b::get_Link('delete', array('href' => $deleter, 'icon' => ICON_DELETE, 'text' => "", 'class' => 'btn-danger', 'onclick' => "confirmDeleteObservation('{$observation['observation']}');"));
        $options = $b::get_BtnGroup('options', array('content' => array($leditor . $ldeleter)));
        //[details]-----------------------------------------------------------------------------------------------------
        $details = "<b>Radicada por</b>: $author_name </br>";
        $details .= "<b>Tipo</b>: $type </br>";
        $details .= "<b>Observación</b>: $content </br>";
        $cell_count = array("content" => $count, "class" => "text-center  align-middle",);
        //$cell_code = array("content" => $code, "class" => "text-center  align-middle text-nowrap",);
        //$cell_author = array("content" => $author, "class" => "text-center  align-middle text-nowrap",);
        //$cell_content = array("content" => $content, "class" => "text-center  align-middle text-nowrap",);
        $cell_details = array("content" => $details, "class" => "text-left  align-middle ",);
        //$cell_date = array("content" => $observation["date"], "class" => "text-center  align-middle text-nowrap",);
        //$cell_time = array("content" => $observation["time"], "class" => "text-center  align-middle text-nowrap",);
        $cell_options = array("content" => $options, "class" => "text-center align-middle",);
        $bgrid->add_Row(array($cell_count, $cell_details, $cell_options));
    }
} else {
    echo("Sin observaciones!...");
}

$data = array(
    "message" => "Draw grid!",
    "grid" => $bgrid . "",
    "status" => 200
);
echo(json_encode($data));
?>