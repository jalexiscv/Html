<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-21 14:20:59
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Series\Creator\index.php]
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
    // - Campos de series
    "label_serie" => "Código de la serie",
    "label_unit" => "Unidad documental",
    "label_reference" => "Código de referencia",
    "label_name" => "Nombre de la serie",
    "label_description" => "Descripción",
    "label_author" => "Autor",
    "label_created_at" => "Fecha de creación",
    "label_updated_at" => "Fecha de actualización",
    "label_deleted_at" => "Fecha de eliminación",
    "placeholder_serie" => "Serie documental",
    "placeholder_reference" => "Eje: 000-000-000",
    "placeholder_name" => "Nombre",
    "placeholder_description" => "Descripción",
    "placeholder_author" => "Autor",
    "placeholder_created_at" => "Fecha de creación",
    "placeholder_updated_at" => "Fecha de actualización",
    "placeholder_deleted_at" => "Fecha de eliminación",
    "help_serie" => "Ingrese el código de la serie documental",
    "help_reference" => "Referencia de la serie documental",
    "help_name" => "Ingrese el nombre de la serie",
    "help_description" => "Proporcione una descripción detallada de la serie",
    "help_author" => "Nombre del autor de la serie",
    "help_created_at" => "Fecha de creación de la serie",
    "help_updated_at" => "Fecha de última actualización",
    "help_deleted_at" => "Fecha de eliminación (si aplica)",
    // - Creación de series
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas series documentales. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que le sean asignados los permisos correspondientes. Para continuar, presione la opción indicada en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva serie documental",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Serie existente!",
    "create-duplicate-message" => "Esta serie documental ya había sido registrada previamente. Presione continuar en la parte inferior de este mensaje para regresar al listado general de series.",
    "create-success-title" => "¡Serie registrada exitosamente!",
    "create-success-message" => "La serie documental se registró exitosamente. Para regresar al listado general de series, presione continuar en la parte inferior de este mensaje.",
    // - Visualización de series
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar series documentales en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Visualización de serie",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "La serie documental solicitada no se encuentra registrada en el sistema.",
    "view-success-title" => "Consulta exitosa",
    "view-success-message" => "La serie documental ha sido recuperada correctamente.",
    // - Edición de series
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar series documentales en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar serie documental!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que desea actualizar no existe o fue eliminado previamente. Para regresar al listado general de series, presione continuar en la parte inferior de este mensaje.",
    "edit-success-title" => "¡Serie actualizada!",
    "edit-success-message" => "Los datos de la serie documental se <b>actualizaron exitosamente</b>. Para regresar al listado general de series, presione el botón continuar en la parte inferior del mensaje.",
    // - Eliminación de series
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar series documentales en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar serie documental!",
    "delete-message" => "Para confirmar la eliminación de la serie documental <b>%s</b>, presione eliminar. Para regresar al listado general de series, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o fue eliminado previamente. Para regresar al listado general de series, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Serie eliminada exitosamente!",
    "delete-success-message" => "La serie documental se eliminó exitosamente. Para regresar al listado general de series, presione el botón continuar en la parte inferior del mensaje.",
    // - Listado de series
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de series documentales en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o la asignación de los permisos necesarios. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de series documentales",
    "list-description" => "En esta sección se listan todas las series documentales registradas en la plataforma. Para crear una nueva serie, presione el botón 'Agregar' en la parte superior derecha.",
];

?>