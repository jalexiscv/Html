<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-29 08:30:37
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Library\Views\Resources\Editor\form.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$s = service('strings');
$f = service("forms", array("lang" => "Resources."));
//[Request]-----------------------------------------------------------------------------
$row = $model->get_Resource($oid);
$r["resource"] = @$row["resource"];
$r["title"] = $s->get_URLDecode($row["title"]);
$r["description"] = $s->get_URLDecode(@$row["description"]);
$r["authors"] = @$row["authors"];
$r["use"] = @$row["use"];
$r["category"] = @$row["category"];
$r["level"] = @$row["level"];
$r["objective"] = @$row["objective"];
$r["program"] = @$row["program"];
$r["type"] = @$row["type"];
$r["format"] = @$row["format"];
$r["language"] = @$row["language"];
$r["file"] = @$row["file"];
$r["url"] = $s->get_URLDecode(@$row["url"]);
$r["keywords"] = @$row["keywords"];
$r["editorial"] = $f->get_Value("editorial", @$row["editorial"]);
$r["publication"] = $f->get_Value("publication", @$row["publication"]);
$r["author"] = @$row["author"];


$back = "/library/resources/list/" . lpk();


$types = array(
    array("value" => "ARTICLE", "label" => "Articulo"),
    array("value" => "DOCUMENT", "label" => "Documento"),
    array("value" => "BOOK", "label" => "Libro"),
    array("value" => "OVA", "label" => "Objeto Virtual de Aprendizaje (OVA)"),
    array("value" => "OVI", "label" => "Objeto Virtual Interactivo (OVI)"),
    array("value" => "MAGAZINE", "label" => "Revista"),
    array("value" => "OTHER", "label" => "Otro"),
);


$associatedLabel = "";

foreach ($types as $type) {
    if ($type["value"] == $r["type"]) {
        $r["type"] = $type["label"];
        break;
    }
}


//[Fields]-----------------------------------------------------------------------------
$f->fields["resource"] = $f->get_FieldView("resource", array("value" => $r["resource"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["title"] = $f->get_FieldView("title", array("value" => $r["title"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldView("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["authors"] = $f->get_FieldView("authors", array("value" => $r["authors"], "proportion" => "col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12"));
$f->fields["use"] = $f->get_FieldView("use", array("value" => $r["use"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["category"] = $f->get_FieldView("category", array("value" => $r["category"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["level"] = $f->get_FieldView("level", array("value" => $r["level"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["objective"] = $f->get_FieldView("objective", array("value" => $r["objective"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["program"] = $f->get_FieldView("program", array("value" => $r["program"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldView("type", array("value" => $r["type"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["format"] = $f->get_FieldView("format", array("value" => $r["format"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["language"] = $f->get_FieldView("language", array("value" => $r["language"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["file"] = $f->get_FieldView("file", array("value" => $r["file"], "proportion" => "col-12"));
$f->fields["url"] = $f->get_FieldView("url", array("value" => $r["url"], "proportion" => "col-12"));
$f->fields["keywords"] = $f->get_FieldView("keywords", array("value" => $r["keywords"], "proportion" => "col-12"));
$f->fields["editorial"] = $f->get_FieldView("editorial", array("value" => $r["editorial"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["publication"] = $f->get_FieldView("publication", array("value" => $r["publication"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));

$f->add_HiddenField("author", $r["author"]);
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Continue"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/library/resources/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["resource"] . $f->fields["category"] . $f->fields["language"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["title"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["keywords"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["authors"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["objective"] . $f->fields["program"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["type"] . $f->fields["editorial"] . $f->fields["publication"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["file"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["url"])));


$f->groups["gy"] = $f->get_GroupSeparator();

$url=cdn_url($r["file"]);
if ($r["type"] == "image/jpeg") {
    $viewer = ("<img src=\"{$url}\" class='img-fluid' />");
} elseif ($r["type"] == "application/pdf") {
    $viewer = "<embed src=\"{$url}\" type=\"application/pdf\" width=\"100%\" height=\"600px\">";
} elseif ($r["category"] == "GENIALLY") {
    $url=cdn_url($r["url"]);
    $viewer = "<iframe src=\"{$url}\" width=\"100%\" height=\"600px\"></iframe>";
} elseif ($r["category"] == "URL") {
    $viewer = "<iframe src=\"{$r["url"]}\" width=\"100%\" height=\"600px\"></iframe>";
} elseif ($r["category"] == "YOUTUBE") {
    $youtube_url = $r["url"]; // URL de video
    if (!empty($youtube_url)) {
        //https://www.youtube.com/watch?v=MlGxpvo79dU
        //https://youtu.be/4Ygzrz8jjVM
        $patron1 = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        $patron2 = '/youtu\.be\/([a-zA-Z0-9_-]{11})/';
        if (preg_match($patron1, $youtube_url, $coincidencias)) {
            $video_id = $coincidencias[1];
        } elseif (preg_match($patron2, $youtube_url, $coincidencias)) {
            $video_id = $coincidencias[1];
        } else {
            $video_id = false; // No se encontró el ID del video
        }
    }
    $embed_code = "<iframe width='560' height='560' src='https://www.youtube.com/embed/$video_id' frameborder='0' allowfullscreen></iframe>";
    $viewer = $embed_code;
} elseif ($r["category"] == "VIMEO") {
    $vimeo_url = $r["url"]; // URL de video
    $video_id = explode("/", $vimeo_url)[count(explode("/", $vimeo_url)) - 1];
    $embed_code = "<iframe src='https://player.vimeo.com/video/$video_id' width='640' height='360' frameborder='0' allow='autoplay; fullscreen; picture-in-picture' allowfullscreen></iframe>";
    $viewer = $embed_code;
} else {
    $viewer = "--";
}

$f->groups["g6"] = $f->get_Group(array("legend" => "Visualizar", "fields" => ($viewer)));

//$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["use"] . $f->fields["category"])));
//$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["level"] . $f->fields["objective"] . $f->fields["program"])));
//$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["type"] . $f->fields["format"] . $f->fields["language"])));
//$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["file"] . $f->fields["url"])));

if(get_LoggedIn()){
    $f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
}else{

}



//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => lang("Resources.view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
