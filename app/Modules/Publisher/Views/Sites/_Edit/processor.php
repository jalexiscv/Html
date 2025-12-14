<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-14 23:48:16
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Publisher\Views\Sites\Editor\processor.php]
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Publisher\Models\Publisher_Sites");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Publisher.sites-"));
$d = array(
    "site" => $f->get_Value("site"),
    "image" => $f->get_Value("image"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "max_links" => $f->get_Value("max_links"),
    "links_type" => $f->get_Value("links_type"),
    "sponsored" => $f->get_Value("sponsored"),
    "post_cover" => $f->get_Value("post_cover"),
    "categories" => $f->get_Value("categories"),
    "min_traffic" => $f->get_Value("min_traffic"),
    "max_traffic" => $f->get_Value("max_traffic"),
    "type" => $f->get_Value("type"),
    "themes" => $f->get_Value("themes"),
    "moz_da" => $f->get_Value("moz_da"),
    "moz_pa" => $f->get_Value("moz_pa"),
    "moz_links" => $f->get_Value("moz_links"),
    "moz_rank" => $f->get_Value("moz_rank"),
    "majestic_cf" => $f->get_Value("majestic_cf"),
    "majestic_tf" => $f->get_Value("majestic_tf"),
    "majestic_links" => $f->get_Value("majestic_links"),
    "majestic_rd" => $f->get_Value("majestic_rd"),
    "ahrefs_dr" => $f->get_Value("ahrefs_dr"),
    "ahrefs_bl" => $f->get_Value("ahrefs_bl"),
    "ahrefs_rd" => $f->get_Value("ahrefs_rd"),
    "ahrefs_obl" => $f->get_Value("ahrefs_obl"),
    "ahrefs_otm" => $f->get_Value("ahrefs_otm"),
    "sistrix" => $f->get_Value("sistrix"),
    "price" => $f->get_Value("price"),
    "author" => safe_get_user(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["site"]);
$l["back"] = "/publisher/sites/list/" . lpk();
$l["edit"] = "/publisher/sites/edit/{$d["site"]}";
$asuccess = "publisher/sites-edit-success-message.mp3";
$anoexist = "publisher/sites-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['site'], $d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Publisher.sites-edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Publisher.sites-edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Publisher.sites-edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Publisher.sites-edit-noexist-message"), $d['site']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>
