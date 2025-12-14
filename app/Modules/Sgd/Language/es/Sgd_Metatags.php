<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-21 14:20:48
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Metatags\Creator\index.php]
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
    // - Campos de Metadatos
    "label_metatag" => "Código del metadato",
    "label_reference" => "Referencia",
    "label_type" => "tipo",
    "label_file" => "archivo",
    "label_value" => "valor",
    "label_author" => "autor",
    "label_created_at" => "creado el",
    "label_updated_at" => "actualizado el",
    "label_deleted_at" => "eliminado el",
    "placeholder_metatag" => "metadato",
    "placeholder_type" => "tipo",
    "placeholder_file" => "archivo",
    "placeholder_value" => "valor",
    "placeholder_author" => "autor",
    "placeholder_created_at" => "creado el",
    "placeholder_updated_at" => "actualizado el",
    "placeholder_deleted_at" => "eliminado el",
    "help_metatag" => "metadato",
    "help_type" => "tipo",
    "help_file" => "archivo",
    "help_value" => "valor",
    "help_author" => "autor",
    "help_created_at" => "creado el",
    "help_updated_at" => "actualizado el",
    "help_deleted_at" => "eliminado el",
    // - Creador de Metadatos
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos metadatos. Por favor, póngase en contacto con el administrador del sistema o, en su defecto, contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo metadato",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Metadato existente!",
    "create-duplicate-message" => "Este metadato ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para retornar al listado general de metadatos.",
    "create-success-title" => "¡Metadato registrado exitosamente!",
    "create-success-message" => "El metadato se registró exitosamente. Para retornar al listado general de metadatos, presione continuar en la parte inferior de este mensaje.",
    // - Visor de Metadatos
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar metadatos en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Editor de Metadatos
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar metadatos en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar metadato!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que se intenta actualizar no existe o se eliminó previamente. Para retornar al listado general de metadatos, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Metadato actualizado!",
    "edit-success-message" => "Los datos del metadato se <b>actualizaron exitosamente</b>. Para retornar al listado general de metadatos, presione el botón continuar en la parte inferior del presente mensaje.",
    // - Eliminador de Metadatos
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar metadatos en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar metadato!",
    "delete-message" => "Para confirmar la eliminación del metadato <b>%s</b>, presione eliminar. Para retornar al listado general de metadatos, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o se eliminó previamente. Para retornar al listado general de metadatos, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Metadato eliminado exitosamente!",
    "delete-success-message" => "El metadato se eliminó exitosamente. Para retornar al listado general de metadatos, presione el botón continuar en la parte inferior de este mensaje.",
    // - Listado de Metadatos
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de metadatos en esta plataforma. Contacte al departamento de soporte técnico para información adicional o la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de metadatos",
    "list-message" => "En esta sección se listan todos los metadatos registrados en la plataforma. Para crear un nuevo metadato, presione el botón agregar en la parte superior de este mensaje.",
]

?>