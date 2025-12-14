<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-04-22 20:27:20
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Views\Clients\List\table.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/
//[models]--------------------------------------------------------------------------------------------------------------
$mclients = model('App\Modules\Plex\Models\Plex_Clients');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/application";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 100;
$fields = array(
    "general" =>"General",
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    "name LIKE" => "%{$search}%",
);
//$mclients->clear_AllCache();
$rows = $mclients->getCachedSearch($conditions, $limit, $offset, "updated_at DESC");
$total = $mclients->get_CountAllResults($conditions);
//echo(safe_dump($rows['sql']));
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center	align-middle"),
    array("content" => lang("App.Client"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.rut"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.vpn"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.users"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.domain"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.default_url"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.db_host"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.db_port"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.db"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.db_user"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.db_password"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.status"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.logo"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.logo_portrait"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.logo_portrait_light"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.logo_landscape"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.logo_landscape_light"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.theme"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.theme_color"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.fb_app_id"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.fb_app_secret"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.fb_page"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.footer"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.google_trackingid"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.google_ad_client"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.google_ad_display_square"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.google_ad_display_rectangle"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.google_ad_links_retangle"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.google_ad_display_vertical"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.google_ad_infeed"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.google_ad_inarticle"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.google_ad_matching_content"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.google_ad_links_square"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.arc_id"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.matomo"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.2fa"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.smtp_host"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.smtp_port"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.smtp_smtpsecure"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.smtp_smtpauth"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.smtp_username"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.smtp_password"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.smtp_from_email"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.smtp_from_name"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.smtp_charset"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/plex/clients';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["client"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["client"]}";
        $hrefEdit = "$component/edit/{$row["client"]}";
        $hrefDelete = "$component/delete/{$row["client"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['client'], "class" => "text-left align-middle"),
                array("content" => $row['name'], "class" => "text-left align-middle"),
                //array("content" => $row['rut'], "class" => "text-left align-middle"),
                //array("content" => $row['vpn'], "class" => "text-left align-middle"),
                //array("content" => $row['users'], "class" => "text-left align-middle"),
                //array("content" => $row['domain'], "class" => "text-left align-middle"),
                //array("content" => $row['default_url'], "class" => "text-left align-middle"),
                //array("content" => $row['db_host'], "class" => "text-left align-middle"),
                //array("content" => $row['db_port'], "class" => "text-left align-middle"),
                //array("content" => $row['db'], "class" => "text-left align-middle"),
                //array("content" => $row['db_user'], "class" => "text-left align-middle"),
                //array("content" => $row['db_password'], "class" => "text-left align-middle"),
                //array("content" => $row['status'], "class" => "text-left align-middle"),
                //array("content" => $row['logo'], "class" => "text-left align-middle"),
                //array("content" => $row['logo_portrait'], "class" => "text-left align-middle"),
                //array("content" => $row['logo_portrait_light'], "class" => "text-left align-middle"),
                //array("content" => $row['logo_landscape'], "class" => "text-left align-middle"),
                //array("content" => $row['logo_landscape_light'], "class" => "text-left align-middle"),
                //array("content" => $row['theme'], "class" => "text-left align-middle"),
                //array("content" => $row['theme_color'], "class" => "text-left align-middle"),
                //array("content" => $row['fb_app_id'], "class" => "text-left align-middle"),
                //array("content" => $row['fb_app_secret'], "class" => "text-left align-middle"),
                //array("content" => $row['fb_page'], "class" => "text-left align-middle"),
                //array("content" => $row['footer'], "class" => "text-left align-middle"),
                //array("content" => $row['google_trackingid'], "class" => "text-left align-middle"),
                //array("content" => $row['google_ad_client'], "class" => "text-left align-middle"),
                //array("content" => $row['google_ad_display_square'], "class" => "text-left align-middle"),
                //array("content" => $row['google_ad_display_rectangle'], "class" => "text-left align-middle"),
                //array("content" => $row['google_ad_links_retangle'], "class" => "text-left align-middle"),
                //array("content" => $row['google_ad_display_vertical'], "class" => "text-left align-middle"),
                //array("content" => $row['google_ad_infeed'], "class" => "text-left align-middle"),
                //array("content" => $row['google_ad_inarticle'], "class" => "text-left align-middle"),
                //array("content" => $row['google_ad_matching_content'], "class" => "text-left align-middle"),
                //array("content" => $row['google_ad_links_square'], "class" => "text-left align-middle"),
                //array("content" => $row['arc_id'], "class" => "text-left align-middle"),
                //array("content" => $row['matomo'], "class" => "text-left align-middle"),
                //array("content" => $row['2fa'], "class" => "text-left align-middle"),
                //array("content" => $row['smtp_host'], "class" => "text-left align-middle"),
                //array("content" => $row['smtp_port'], "class" => "text-left align-middle"),
                //array("content" => $row['smtp_smtpsecure'], "class" => "text-left align-middle"),
                //array("content" => $row['smtp_smtpauth'], "class" => "text-left align-middle"),
                //array("content" => $row['smtp_username'], "class" => "text-left align-middle"),
                //array("content" => $row['smtp_password'], "class" => "text-left align-middle"),
                //array("content" => $row['smtp_from_email'], "class" => "text-left align-middle"),
                //array("content" => $row['smtp_from_name'], "class" => "text-left align-middle"),
                //array("content" => $row['smtp_charset'], "class" => "text-left align-middle"),
                //array("content" => $row['author'], "class" => "text-left align-middle"),
                //array("content" => $row['created_at'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-grid", array(
    "header-title" => lang('Plex_Clients.list-title'),
    "header-back" => $back,
    "header-add" => "/plex/clients/create/" . lpk(),
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Plex_Clients.list-title'), "message" => lang('Plex_Clients.list-description')),
    "content" => $bgrid,
));
echo($card);
?>