<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-29 08:30:38
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
//[services]------------------------------------------------------------------------------------------------------------
$mnetworks = model('App\Modules\Library\Models\Library_Networks');
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('server');
//[Models]-----------------------------------------------------------------------------
//$model = model("App\Modules\Library\Models\Library_Resources");
//[Form]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Resources."));
//[Values]-----------------------------------------------------------------------------
$row = $model->find($oid);
$r["resource"] = $f->get_Value("resource", $row["resource"]);
$r["title"] = $f->get_Value("title", urldecode(@$row["title"]));
$r["description"] = $f->get_Value("description", urldecode(@$row["description"]));
$r["authors"] = $f->get_Value("authors", @$row["authors"]);
$r["use"] = $f->get_Value("use", @$row["use"]);
$r["category"] = $f->get_Value("category", @$row["category"]);
$r["level"] = $f->get_Value("level", @$row["level"]);
$r["objective"] = $f->get_Value("objective", @$row["objective"]);
$r["program"] = $f->get_Value("program", @$row["program"]);
$r["type"] = $f->get_Value("type", @$row["type"]);
$r["format"] = $f->get_Value("format", @$row["format"]);
$r["language"] = $f->get_Value("language", @$row["language"]);

$r["editorial"] = $f->get_Value("editorial", @$row["editorial"]);
$r["publication"] = $f->get_Value("publication", @$row["publication"]);

$r["file"] = $f->get_Value("file", @$row["file"]);
$r["url"] = $f->get_Value("url", @$row["url"]);
$r["keywords"] = $f->get_Value("keywords", @$row["keywords"]);
$r["author"] = $f->get_Value("author", $authentication->get_User());
$back = "/library/resources/list/" . lpk();

$categories = array(
    array("value" => "GENERAL", "label" => "General"),
    array("value" => "DOCUMENTS", "label" => "Documentos"),
    array("value" => "GENIALLY", "label" => "Genially"),
    array("value" => "GRAPHIC", "label" => "Gráfico"),
    array("value" => "AUDIO", "label" => "Audio"),
    array("value" => "VIDEO", "label" => "Video"),
    array("value" => "PRESENTATION", "label" => "Presentación"),
    array("value" => "H5P", "label" => "H5P(Paquete HTML5)"),
    array("value" => "YOUTUBE", "label" => "Youtube"),
    array("value" => "VIMEO", "label" => "Vimeo"),
    array("value" => "URL", "label" => "Enlace(URL)"),
);

$uses = array(
    array("value" => "01", "label" => "Ejercicio que fomentan el desarrollo de competencias"),
    array("value" => "02", "label" => "Documentos"),
);

$redes = $mnetworks->get_SelectData();


$types = array(
    array("value" => "ARTICLE", "label" => "Articulo"),
    array("value" => "DOCUMENT", "label" => "Documento"),
    array("value" => "BOOK", "label" => "Libro"),
    array("value" => "OVA", "label" => "Objeto Virtual de Aprendizaje (OVA)"),
    array("value" => "OVI", "label" => "Objeto Virtual Interactivo (OVI)"),
    array("value" => "MAGAZINE", "label" => "Revista"),
    array("value" => "OTHER", "label" => "Otro"),
);

$languages = array(
    array("value" => "ES", "label" => "Español"),
    array("value" => "EN", "label" => "Ingles"),
);

//[Fields]-----------------------------------------------------------------------------
$f->fields["resource"] = $f->get_FieldText("resource", array("value" => $r["resource"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["title"] = $f->get_FieldText("title", array("value" => $r["title"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["authors"] = $f->get_FieldText("authors", array("value" => $r["authors"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["use"] = $f->get_FieldSelect("use", array("selected" => $r["use"], "data" => $uses, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["category"] = $f->get_FieldSelect("category", array("selected" => $r["category"], "data" => $categories, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["level"] = $f->get_FieldText("level", array("value" => $r["level"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["objective"] = $f->get_FieldText("objective", array("value" => $r["objective"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["program"] = $f->get_FieldSelect("program", array("selected" => $r["program"], "data" => $redes, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldSelect("type", array("selected" => $r["type"], "data" => $types, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["format"] = $f->get_FieldText("format", array("value" => $r["format"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["language"] = $f->get_FieldSelect("language", array("selected" => $r["language"], "data" => $languages, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["file"] = $f->get_FieldFile("file", array("value" => $r["file"], "proportion" => "col-12"));
$f->fields["url"] = $f->get_FieldText("url", array("value" => $r["url"], "proportion" => "col-12"));
$f->fields["keywords"] = $f->get_FieldText("keywords", array("value" => $r["keywords"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));

$f->fields["editorial"] = $f->get_FieldText("editorial", array("value" => $r["editorial"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["publication"] = $f->get_FieldDate("publication", array("value" => $r["publication"], "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));


$f->add_HiddenField("author", $r["author"]);
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["resource"] . $f->fields["category"] . $f->fields["language"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["title"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["keywords"] . $f->fields["authors"])));

if ($server::get_Name() == "intranet.campusem.com.co") {
    $f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["objective"] . $f->fields["type"])));
} else {
    $f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["objective"] . $f->fields["program"] . $f->fields["type"])));
}


$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["editorial"] . $f->fields["publication"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["file"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["url"])));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Groups]--------------------------------------------------------------------------------------------------------------
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Resources.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
