<?php
/*
* ----------------------------------------------------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Cadastre\Views\Resources\Creator\form.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* ----------------------------------------------------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* ----------------------------------------------------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* ----------------------------------------------------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* ----------------------------------------------------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* ----------------------------------------------------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* ----------------------------------------------------------------------------------------------------------------------
*/

$mnetworks = model('App\Modules\Cadastre\Models\Cadastre_Networks');

$dates = service("dates");
$f = service("forms", array("lang" => "Resources."));
//[Requests]------------------------------------------------------------------------------------------------------------
$r["resource"] = $f->get_Value("resource", pk());
$r["title"] = $f->get_Value("title");
$r["description"] = $f->get_Value("description");
$r["authors"] = $f->get_Value("authors");
$r["use"] = $f->get_Value("use");
$r["category"] = $f->get_Value("category");
$r["level"] = $f->get_Value("level");
$r["objective"] = $f->get_Value("objective");
$r["program"] = $f->get_Value("program");
$r["editorial"] = $f->get_Value("editorial");
$r["publication"] = $f->get_Value("publication", $dates->get_Date());
$r["type"] = $f->get_Value("type");
$r["format"] = $f->get_Value("format");
$r["language"] = $f->get_Value("language");
$r["file"] = $f->get_Value("file");
$r["url"] = $f->get_Value("url");
$r["keywords"] = $f->get_Value("keywords");
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_date"] = $f->get_Value("created_date");
$r["updated_date"] = $f->get_Value("updated_date");
$r["deleted_date"] = $f->get_Value("deleted_date");
$back = "/cadastre/resources/list/" . lpk();

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
//[Fields]--------------------------------------------------------------------------------------------------------------
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
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["resource"] . $f->fields["category"] . $f->fields["language"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["title"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["keywords"] . $f->fields["authors"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["objective"] . $f->fields["program"] . $f->fields["type"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["editorial"] . $f->fields["publication"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["file"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["url"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Resources.create-title"));
$smarty->assign("header_back", $back);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>