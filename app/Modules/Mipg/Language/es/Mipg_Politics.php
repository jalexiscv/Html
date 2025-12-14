<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2024-07-24 17:23:10
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @Editor Anderson Ospina Lenis <andersonospina798@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
return [
    // - Politics fields
    "label_politic" => "Código de la política",
    "label_dimension" => "Código de la dimensión",
    "label_order" => "Orden",
    "label_name" => "Nombre de la política",
    "label_description" => "Descripción de la política",
    "label_author" => "Autor de la política",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "label_normative"=> "Normativa",
    "label_tools" => "Herramientas",
    "placeholder_politic" => "Política",
    "placeholder_dimension" => "Dimensión",
    "placeholder_order" => "Orden",
    "placeholder_name" => "Nombre",
    "placeholder_description" => "Descripción",
    "placeholder_author" => "Autor",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_politic" => "Código automático",
    "help_dimension" => "Código heredado",
    "help_order" => "Número de orden (Requerido)",
    "help_name" => "Nombre (Requerido)",
    "help_description" => "Descripción (Requerido)",
    "help_author" => "Autor",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Politics creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevas políticas. Por favor, póngase en contacto con el administrador del sistema o, en su defecto, con el personal de soporte técnico para que le sean asignados los permisos necesarios, si corresponde. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nueva política",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Política existente!",
    "create-duplicate-message" => "Esta política ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para regresar al listado general de políticas.",
    "create-success-title" => "¡Política registrada exitosamente!",
    "create-success-message" => "La política se registró exitosamente. Para regresar al listado general de políticas, presione continuar en la parte inferior de este mensaje.",
    // - Politics viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar políticas en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o para la asignación de los permisos necesarios, si corresponde. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Politics editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar políticas en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o para la asignación de los permisos necesarios, si corresponde. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar política!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o ha sido eliminado previamente. Para regresar al listado general de políticas, presione continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Política actualizada!",
    "edit-success-message" => "Los datos de la política se <b>actualizaron exitosamente</b>. Para regresar al listado general de políticas, presione el botón continuar en la parte inferior de este mensaje.",
    // - Politics deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar políticas en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o para la asignación de los permisos necesarios, si corresponde. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar política!",
    "delete-message" => "Para confirmar la eliminación de la política <b>%s</b>, presione eliminar. Para regresar al listado general de políticas, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o ha sido eliminado previamente. Para regresar al listado general de políticas, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Política eliminada exitosamente!",
    "delete-success-message" => "La política se eliminó exitosamente. Para regresar al listado general de políticas, presione el botón continuar en la parte inferior de este mensaje.",
    // - Politics list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de políticas en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o para la asignación de los permisos necesarios, si corresponde. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Políticas de la dimensión",
    "info-politic" => "En el contexto de MIPG en Colombia, una política se concibe como un conjunto de principios, directrices y normas que guían la toma de decisiones y acciones dentro de una entidad pública, con el fin de alcanzar los objetivos estratégicos y cumplir con la misión y visión institucionales. Como parte integral del proceso de cumplimiento de estas políticas, se requiere llevar a cabo un autodiagnóstico para evaluar el nivel de cumplimiento de cada una de ellas de manera individualizada. Este autodiagnóstico permite identificar áreas de mejora y fortalecimiento en la implementación de las políticas, contribuyendo así a una gestión pública más eficaz y al logro de los resultados esperados por la entidad. Este listado corresponde a todas las políticas relacionadas con una dimensión específica, para las cuales se deberán desarrollar autodiagnósticos individuales.",
];

?>