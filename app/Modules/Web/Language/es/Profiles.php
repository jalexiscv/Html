<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-06-22 13:47:18
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Web\Views\Profiles\Creator\index.php]
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
return [
    // - Profiles fields
    "label_profile" => "Código del perfil",
    "label_customer" => "Código del cliente",
    "label_registration" => "Numero de matricula",
    "label_names" => "Nombre Completo",
    "label_address" => "Dirección del predio",
    "label_cycle" => "Ciclo",
    "label_stratum" => "Estrato",
    "label_use_type" => "Uso",
    "label_consumption" => "Consumo",
    "label_service" => "Servicio",
    "label_neighborhood_description" => "Barrio / Sector",
    "label_unit_id" => "Cedula",
    "label_phone" => "Teléfono",
    "label_entry_date" => "Registro",
    "label_reading_route" => "Ruta de lectura",
    "label_national_property_number" => "Numero predial",
    "label_rate" => "Tarifa",
    "label_route_sequence" => "Secuencia de ruta",
    "label_diameter" => "Diametro",
    "label_meter_number" => "Numero del medidor",
    "label_historical" => "Consumo historico",
    "label_longitude" => "Longitud",
    "label_latitude" => "Latitud",
    "placeholder_profile" => "profile",
    "placeholder_customer" => "customer",
    "placeholder_registration" => "registration",
    "placeholder_names" => "names",
    "placeholder_address" => "address",
    "placeholder_cycle" => "cycle",
    "placeholder_stratum" => "stratum",
    "placeholder_use_type" => "use_type",
    "placeholder_consumption" => "consumption",
    "placeholder_service" => "service",
    "placeholder_neighborhood_description" => "neighborhood_description",
    "placeholder_unit_id" => "unit_id",
    "placeholder_phone" => "phone",
    "placeholder_entry_date" => "entry_date",
    "placeholder_reading_route" => "reading_route",
    "placeholder_national_property_number" => "national_property_number",
    "placeholder_rate" => "rate",
    "placeholder_route_sequence" => "route_sequence",
    "placeholder_diameter" => "diameter",
    "placeholder_meter_number" => "meter_number",
    "placeholder_historical" => "historical",
    "placeholder_longitude" => "longitude",
    "placeholder_latitude" => "latitude",
    "help_profile" => "profile",
    "help_customer" => "customer",
    "help_registration" => "registration",
    "help_names" => "names",
    "help_address" => "address",
    "help_cycle" => "cycle",
    "help_stratum" => "stratum",
    "help_use_type" => "use_type",
    "help_consumption" => "consumption",
    "help_service" => "service",
    "help_neighborhood_description" => "neighborhood_description",
    "help_unit_id" => "unit_id",
    "help_phone" => "phone",
    "help_entry_date" => "entry_date",
    "help_reading_route" => "reading_route",
    "help_national_property_number" => "national_property_number",
    "help_rate" => "rate",
    "help_route_sequence" => "route_sequence",
    "help_diameter" => "diameter",
    "help_meter_number" => "meter_number",
    "help_historical" => "historical",
    "help_longitude" => "longitude",
    "help_latitude" => "latitude",
    // - Profiles creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos #plural, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo #singular",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡#singular existente!",
    "create-duplicate-message" => "Este #singular ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de #plural.",
    "create-success-title" => "¡#singular registrada exitosamente!",
    "create-success-message" => "La #singular se registró exitosamente, para retornar al listado general de #plural presioné continuar en la parte inferior de este mensaje.",
    // - Profiles viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar #plural en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Profiles editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar #plural en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar #singular!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de #plural presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡#singular actualizada!",
    "edit-success-message" => "Los datos de #singular se <b>actualizaron exitosamente</b>, para retornar al listado general de #plural presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Profiles deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar #plural en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar #singular!",
    "delete-message" => "Para confirmar la eliminación del #singular <b>%s</b>, presioné eliminar, para retornar al listado general de #plural presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de #plural presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡#Singular eliminad@ exitosamente!",
    "delete-success-message" => "La #singular se elimino exitosamente, para retornar al listado de general de #plural presioné el botón continuar en la parte inferior de este mensaje.",
    // - Profiles list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de #plural en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de #plural",
];

?>