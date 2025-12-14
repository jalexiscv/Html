<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-05 05:15:13
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Views\Clients\Creator\index.php]
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
return [
    // - Clients fields
    "label_client" => "Código de cliente",
    "label_name" => "Nombre del cliente",
    "label_rut" => "RUT",
    "label_vpn" => "VPN",
    "label_users" => "Usuarios",
    "label_domain" => "Dominio",
    "label_default_url" => "Ruta por defecto (URL)",
    "label_db_host" => "Host de la base de datos",
    "label_db_port" => "Puerto de la base de datos",
    "label_db" => "Base de datos",
    "label_db_user" => "Usuario de la base de datos",
    "label_db_password" => "Contraseña de la base de datos",
    "label_status" => "Estado del cliente",
    "label_logo" => "Logo",
    "label_logo_portrait" => "Logo vertical",
    "label_logo_portrait_light" => "Logo vertical claro",
    "label_logo_landscape" => "Logo horizontal",
    "label_logo_landscape_light" => "Logo horizontal claro",
    "label_theme" => "Tema",
    "label_theme_color" => "Color del tema",
    "label_fb_app_id" => "ID de la aplicación de Facebook",
    "label_fb_app_secret" => "Secreto de la aplicación de Facebook",
    "label_fb_page" => "Página de Facebook",
    "label_footer" => "Pie de página",
    "label_google_trackingid" => "ID de seguimiento de Google",
    "label_google_ad_client" => "Cliente de anuncios de Google",
    "label_google_ad_display_square" => "Anuncio cuadrado de Google",
    "label_google_ad_display_rectangle" => "Anuncio rectangular de Google",
    "label_google_ad_links_retangle" => "Anuncios de enlaces rectangulares de Google",
    "label_google_ad_display_vertical" => "Anuncio vertical de Google",
    "label_google_ad_infeed" => "Anuncio in-feed de Google",
    "label_google_ad_inarticle" => "Anuncio in-article de Google",
    "label_google_ad_matching_content" => "Anuncio de contenido coincidente de Google",
    "label_google_ad_links_square" => "Anuncios de enlaces cuadrados de Google",
    "label_arc_id" => "ID de ARC",
    "label_matomo" => "Matomo",
    "label_author" => "Autor",
    "label_created_at" => "Creado en",
    "label_updated_at" => "Actualizado en",
    "label_deleted_at" => "Eliminado en",

    "placeholder_client" => "Cliente",
    "placeholder_name" => "Nombre",
    "placeholder_rut" => "RUT",
    "placeholder_vpn" => "VPN",
    "placeholder_users" => "Usuarios",
    "placeholder_domain" => "Dominio",
    "placeholder_default_url" => "URL por defecto",
    "placeholder_db_host" => "Host de la base de datos",
    "placeholder_db_port" => "Puerto de la base de datos",
    "placeholder_db" => "Base de datos",
    "placeholder_db_user" => "Usuario de la base de datos",
    "placeholder_db_password" => "Contraseña de la base de datos",
    "placeholder_status" => "Estado",
    "placeholder_logo" => "Logo",
    "placeholder_logo_portrait" => "Logo vertical",
    "placeholder_logo_portrait_light" => "Logo vertical claro",
    "placeholder_logo_landscape" => "Logo horizontal",
    "placeholder_logo_landscape_light" => "Logo horizontal claro",
    "placeholder_theme" => "Tema",
    "placeholder_theme_color" => "Color del tema",
    "placeholder_fb_app_id" => "ID de la aplicación de Facebook",
    "placeholder_fb_app_secret" => "Secreto de la aplicación de Facebook",
    "placeholder_fb_page" => "Página de Facebook",
    "placeholder_footer" => "Pie de página",
    "placeholder_google_trackingid" => "ID de seguimiento de Google",
    "placeholder_google_ad_client" => "Cliente de anuncios de Google",
    "placeholder_google_ad_display_square" => "Anuncio cuadrado de Google",
    "placeholder_google_ad_display_rectangle" => "Anuncio rectangular de Google",
    "placeholder_google_ad_links_retangle" => "Anuncios de enlaces rectangulares de Google",
    "placeholder_google_ad_display_vertical" => "Anuncio vertical de Google",
    "placeholder_google_ad_infeed" => "Anuncio in-feed de Google",
    "placeholder_google_ad_inarticle" => "Anuncio in-article de Google",
    "placeholder_google_ad_matching_content" => "Anuncio de contenido coincidente de Google",
    "placeholder_google_ad_links_square" => "Anuncios de enlaces cuadrados de Google",
    "placeholder_arc_id" => "ID de ARC",
    "placeholder_matomo" => "Matomo",
    "placeholder_author" => "Autor",
    "placeholder_created_at" => "Creado en",
    "placeholder_updated_at" => "Actualizado en",
    "placeholder_deleted_at" => "Eliminado en",

    "help_client" => "Cliente",
    "help_name" => "Nombre",
    "help_rut" => "RUT",
    "help_vpn" => "VPN",
    "help_users" => "Usuarios",
    "help_domain" => "Dominio",
    "help_default_url" => "URL por defecto",
    "help_db_host" => "Host de la base de datos",
    "help_db_port" => "Puerto de la base de datos",
    "help_db" => "Base de datos",
    "help_db_user" => "Usuario de la base de datos",
    "help_db_password" => "Contraseña de la base de datos",
    "help_status" => "Estado",
    "help_logo" => "Logo",
    "help_logo_portrait" => "Logo vertical",
    "help_logo_portrait_light" => "Logo vertical claro",
    "help_logo_landscape" => "Logo horizontal",
    "help_logo_landscape_light" => "Logo horizontal claro",
    "help_theme" => "Tema",
    "help_theme_color" => "Color del tema",
    "help_fb_app_id" => "ID de la aplicación de Facebook",
    "help_fb_app_secret" => "Secreto de la aplicación de Facebook",
    "help_fb_page" => "Página de Facebook",
    "help_footer" => "Pie de página",
    "help_google_trackingid" => "ID de seguimiento de Google",
    "help_google_ad_client" => "Cliente de anuncios de Google",
    "help_google_ad_display_square" => "Anuncio cuadrado de Google",
    "help_google_ad_display_rectangle" => "Anuncio rectangular de Google",
    "help_google_ad_links_retangle" => "Anuncios de enlaces rectangulares de Google",
    "help_google_ad_display_vertical" => "Anuncio vertical de Google",
    "help_google_ad_infeed" => "Anuncio in-feed de Google",
    "help_google_ad_inarticle" => "Anuncio in-article de Google",
    "help_google_ad_matching_content" => "Anuncio de contenido coincidente de Google",
    "help_google_ad_links_square" => "Anuncios de enlaces cuadrados de Google",
    "help_arc_id" => "ID de ARC",
    "help_matomo" => "Matomo",
    "help_author" => "Autor",
    "help_created_at" => "Creado en",
    "help_updated_at" => "Actualizado en",
    "help_deleted_at" => "Eliminado en",

    // - Clients creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos clientes. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo cliente",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Cliente existente!",
    "create-duplicate-message" => "Este cliente ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de clientes.",
    "create-success-title" => "¡Cliente registrado exitosamente!",
    "create-success-message" => "El cliente se registró exitosamente. Para retornar al listado general de clientes, presione continuar en la parte inferior de este mensaje.",

    // - Clients viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar clientes en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",

    // - Clients editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar clientes en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar cliente!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o se eliminó previamente. Para retornar al listado general de clientes, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Cliente actualizado!",
    "edit-success-message" => "Los datos del cliente se <b>actualizaron exitosamente</b>. Para retornar al listado general de clientes, presione el botón continuar en la parte inferior del presente mensaje.",

    // - Clients deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar clientes en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar cliente!",
    "delete-message" => "Para confirmar la eliminación del cliente <b>%s</b>, presione eliminar. Para retornar al listado general de clientes, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o se eliminó previamente. Para retornar al listado general de clientes, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Cliente eliminado exitosamente!",
    "delete-success-message" => "El cliente se eliminó exitosamente. Para retornar al listado general de clientes, presione el botón continuar en la parte inferior de este mensaje.",

    // - Clients list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de clientes en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de clientes",
    "list-description" => "En esta sección se listan todos los clientes registrados en la plataforma. Para crear un nuevo cliente, presione el botón crear.",
];


?>