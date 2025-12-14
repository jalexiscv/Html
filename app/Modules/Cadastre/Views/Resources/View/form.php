<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Cadastre\Views\Resources\Editor\form.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/
$s = service('strings');
$f = service("forms", array("lang" => "Resources."));
//[Request]-----------------------------------------------------------------------------
$row = $model->find($oid);
$r["resource"] = $row["resource"];
$r["title"] = $s->get_URLDecode($row["title"]);
$r["description"] = $s->get_URLDecode($row["description"]);
$r["authors"] = $row["authors"];
$r["use"] = $row["use"];
$r["category"] = $row["category"];
$r["level"] = $row["level"];
$r["objective"] = $row["objective"];
$r["program"] = $row["program"];
$r["type"] = $row["type"];
$r["format"] = $row["format"];
$r["language"] = $row["language"];
$r["file"] = $row["file"];
$r["url"] = $s->get_URLDecode($row["url"]);
$r["keywords"] = $row["keywords"];
$r["editorial"] = $f->get_Value("editorial", $row["editorial"]);
$r["publication"] = $f->get_Value("publication", $row["publication"]);
$r["author"] = $row["author"];
$back = "/cadastre/resources/list/" . lpk();


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
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/cadastre/resources/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
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

if ($r["type"] == "image/jpeg") {
    $viewer = ("<img src=\"{$r["file"]}\" class='img-fluid' />");
} elseif ($r["type"] == "application/pdf") {
    $viewer = "<embed src=\"{$r["file"]}\" type=\"application/pdf\" width=\"100%\" height=\"600px\">";
} elseif ($r["category"] == "GENIALLY") {
    $viewer = "<iframe src=\"{$r["url"]}\" width=\"100%\" height=\"600px\"></iframe>";
} elseif ($r["category"] == "URL") {
    $viewer = "<iframe src=\"{$r["url"]}\" width=\"100%\" height=\"600px\"></iframe>";
} elseif ($r["category"] == "YOUTUBE") {
    $youtube_url = $r["url"]; // URL de video
    $video_id = explode("v=", $youtube_url)[1];
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


$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[Build]-----------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", "Recurso: {$oid}");
$smarty->assign("header_back", $back);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));


?>

