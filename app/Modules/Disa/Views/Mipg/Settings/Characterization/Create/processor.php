<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Characterizations\Editor\processor.php]
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
$server = service("server");
$f = service("forms", array("lang" => "Disa.characterizations-"));
$model = model("App\Modules\Disa\Models\Disa_Characterizations");
$clients = model("App\Models\Application_Clients");
$client = $clients->get_ClientByDomain($server::get_FullName());

$d = array(
    "characterization" => pk(),
    "sigep" => $f->get_Value("sigep"),
    "name" => $f->get_Value("name"),
    "vision" => $f->get_Value("vision"),
    "mision" => $f->get_Value("mision"),
    "representative" => $f->get_Value("representative"),
    "representative_position" => $f->get_Value("representative_position"),
    "leader" => $f->get_Value("leader"),
    "leader_position" => $f->get_Value("leader_position"),
    "logo" => $f->get_Value("logo"),
    "author" => $authentication->get_User(),
    "internalcontrol" => $f->get_Value("internalcontrol"),
    "internalcontrol_position" => $f->get_Value("internalcontrol_position"),
    "support" => $f->get_Value("support"),
    "support_position" => $f->get_Value("support_position"),
    "termsofuse" => $f->get_Value("termsofuse"),
    "privacypolicy" => $f->get_Value("privacypolicy"),
);
$row = $model->find($d["characterization"]);
if (isset($row["characterization"])) {
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.characterizations-create-duplicate-title"));
    $smarty->assign("message", lang("Disa.characterizations-create-duplicate-message"));
    $smarty->assign("continue", base_url("/disa/characterizations"));
    $smarty->assign("voice", "disa/characterizations-create-duplicate-message.mp3");
    $c = $smarty->view('alerts/warning.tpl');
} else {
    $logo = $request->getFile($f->get_fieldId("logo"));
    $logo_portrait = $request->getFile($f->get_fieldId("logo_portrait"));
    $logo_portrait_light = $request->getFile($f->get_fieldId("logo_portrait_light"));
    $logo_landscape = $request->getFile($f->get_fieldId("logo_landscape"));
    $logo_landscape_light = $request->getFile($f->get_fieldId("logo_landscape_light"));
    /** Si el directorio no existe procedo a crearlo **/
    $path = "/storages/" . md5($server::get_FullName()) . "/application/logos";
    $realpath = ROOTPATH . "public" . $path;
    if (!file_exists($realpath)) {
        mkdir($realpath, 0777, true);
    }
    /** Proceso los archivos cargados **/
    if ($logo->isValid()) {
        $rname = $logo->getRandomName();
        $logo->move($realpath, $rname);
        $name = $logo->getClientName();
        $type = $logo->getClientMimeType();
        $logo = "{$path}/{$rname}";
        $client['logo'] = $logo;
        $authentication->set("logo", $logo);
    }
    if ($logo_portrait->isValid()) {
        $rname = "logo-portrait-dark-" . $logo_portrait->getRandomName();
        $logo_portrait->move($realpath, $rname);
        $name = $logo_portrait->getClientName();
        $type = $logo_portrait->getClientMimeType();
        $portrait = "{$path}/{$rname}";
        $client['logo_portrait'] = $portrait;
        $authentication->set("logo_portrait", $portrait);
    }
    if ($logo_portrait_light->isValid()) {
        $rname = "logo-portrait-light-" . $logo_portrait_light->getRandomName();
        $logo_portrait_light->move($realpath, $rname);
        $name = $logo_portrait_light->getClientName();
        $type = $logo_portrait_light->getClientMimeType();
        $portrait_light = "{$path}/{$rname}";
        $client['logo_portrait_light'] = $portrait_light;
        $authentication->set("logo_portrait_light", $portrait_light);
    }
    if ($logo_landscape->isValid()) {
        $rname = "logo-landscape-dark-" . $logo_landscape->getRandomName();
        $logo_landscape->move($realpath, $rname);
        $name = $logo_landscape->getClientName();
        $type = $logo_landscape->getClientMimeType();
        $landscape = "{$path}/{$rname}";
        $client['logo_landscape'] = $landscape;
        $authentication->set("logo_landscape", $landscape);
    }
    if ($logo_landscape_light->isValid()) {
        $rname = "logo-landscape-light-" . $logo_landscape_light->getRandomName();
        $logo_landscape_light->move($realpath, $rname);
        $name = $logo_landscape_light->getClientName();
        $type = $logo_landscape_light->getClientMimeType();
        $landscape_light = "{$path}/{$rname}";
        $client['logo_landscape_light'] = $landscape_light;
        $authentication->set("logo_landscape_light", $landscape_light);
    }
    $clients->update($client['client'], $client);
    $create = $model->insert($d);

    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("title", lang("Disa.characterizations-create-success-title"));
    $smarty->assign("message", sprintf(lang("Disa.characterizations-create-success-message"), $d['characterization']));
    //$smarty->assign("edit", base_url("/disa/settings/characterization/create/" . lpk()));
    $smarty->assign("continue", base_url("/disa/settings/characterization/view/" . lpk()));
    $smarty->assign("voice", "disa/characterizations-create-success-message.mp3");
    $c = $smarty->view('alerts/success.tpl');
    /** Logger **/
    history_logger(array(
        "log" => pk(),
        "module" => "DISA",
        "author" => $authentication->get_User(),
        "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> modifico la caracterización de la entidad.",
        "code" => "",
    ));
}
echo($c);
?>