<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-13 00:45:27
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Firewall\Views\Livetraffic\Creator\index.php]
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
    "Request-uri" => "Solicitud(URI)",
    // - Livetraffic fields
    "label_traffic" => "Código de trafico",
    "label_ip" => "IP",
    "label_useragent" => "Agente",
    "label_browser" => "Navegador",
    "label_browser_code" => "Código de navegador",
    "label_os" => "os",
    "label_os_code" => "os_code",
    "label_device_type" => "device_type",
    "label_country" => "country",
    "label_country_code" => "country_code",
    "label_request_uri" => "request_uri",
    "label_domain" => "domain",
    "label_referer" => "referer",
    "label_bot" => "bot",
    "label_date" => "date",
    "label_time" => "time",
    "label_uniquev" => "uniquev",
    "placeholder_traffic" => "traffic",
    "placeholder_ip" => "ip",
    "placeholder_useragent" => "useragent",
    "placeholder_browser" => "browser",
    "placeholder_browser_code" => "browser_code",
    "placeholder_os" => "os",
    "placeholder_os_code" => "os_code",
    "placeholder_device_type" => "device_type",
    "placeholder_country" => "country",
    "placeholder_country_code" => "country_code",
    "placeholder_request_uri" => "request_uri",
    "placeholder_domain" => "domain",
    "placeholder_referer" => "referer",
    "placeholder_bot" => "bot",
    "placeholder_date" => "date",
    "placeholder_time" => "time",
    "placeholder_uniquev" => "uniquev",
    "help_traffic" => "traffic",
    "help_ip" => "ip",
    "help_useragent" => "useragent",
    "help_browser" => "browser",
    "help_browser_code" => "browser_code",
    "help_os" => "os",
    "help_os_code" => "os_code",
    "help_device_type" => "device_type",
    "help_country" => "country",
    "help_country_code" => "country_code",
    "help_request_uri" => "request_uri",
    "help_domain" => "domain",
    "help_referer" => "referer",
    "help_bot" => "bot",
    "help_date" => "date",
    "help_time" => "time",
    "help_uniquev" => "uniquev",
    // - Livetraffic creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos trafico , por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo trafico ",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡trafico  existente!",
    "create-duplicate-message" => "Este trafico  ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de trafico .",
    "create-success-title" => "¡trafico  registrada exitosamente!",
    "create-success-message" => "La trafico  se registró exitosamente, para retornar al listado general de trafico  presioné continuar en la parte inferior de este mensaje.",
    // - Livetraffic viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar trafico  en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Livetraffic editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar trafico  en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar trafico !",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de trafico  presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡trafico  actualizada!",
    "edit-success-message" => "Los datos de trafico  se <b>actualizaron exitosamente</b>, para retornar al listado general de trafico  presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Livetraffic deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar trafico  en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar trafico !",
    "delete-message" => "Para confirmar la eliminación del trafico  <b>%s</b>, presioné eliminar, para retornar al listado general de trafico  presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de trafico  presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡trafico  eliminad@ exitosamente!",
    "delete-success-message" => "La trafico  se elimino exitosamente, para retornar al listado de general de trafico  presioné el botón continuar en la parte inferior de este mensaje.",
    // - Livetraffic list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de trafico  en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de trafico ",
    "list-description"=>"Listado de trafico, donde se encuentran todos los trafico registrados en el sistema, para ver el detalle de cada uno de ellos, presione el botón ver, para editar o eliminar el trafico  presione los botones correspondientes.",
];

?>