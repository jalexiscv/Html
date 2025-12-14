<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2024-07-24 16:14:03
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
    "mipg-info-requirement" => "Este diagnóstico se generara para el requerimiento <u>%s</u>.",
    "mipg-diagnostic-info-message" => "En el contexto de MIPG (Modelo Integrado de Planeación y Gestión) en Colombia, un autodiagnóstico es un proceso sistemático mediante el cual una entidad pública evalúa su propio desempeño en relación con las políticas, procesos y prácticas establecidas por el modelo. Este proceso implica analizar y medir el grado de cumplimiento de las políticas y estándares definidos en el MIPG en áreas clave como la gestión del talento humano, la gestión financiera, la gestión de la calidad, la transparencia y la rendición de cuentas, entre otras.",
    "mipg-diagnostic-info-title" => "Autodiagnósticos",
    // - Diagnostics fields
    "label_diagnostic" => "Código del diagnóstico",
    "label_politic" => "Código de la política",
    "label_requirement" => "Política relacionada",
    "label_order" => "Orden",
    "label_name" => "Nombre del diagnóstico",
    "label_description" => "Descripción del diagnóstico",
    "label_version" => "Versión del diagnóstico",
    "label_author" => "Autor",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_diagnostic" => "Diagnóstico",
    "placeholder_requirement" => "Requisito",
    "placeholder_order" => "Orden",
    "placeholder_name" => "Ej: Diagnóstico 2024",
    "placeholder_description" => "Ej: Diagnóstico de la norma ISO 9001:2015",
    "placeholder_version" => "Version",
    "placeholder_author" => "Autor",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_diagnostic" => "Generado automáticamente",
    "help_requirement" => "Heredado de la política",
    "help_order" => "Requerido",
    "help_name" => "Requerido",
    "help_politic" => "Código automático",
    "help_description" => "Requerido",
    "help_version" => "Requerido",
    "help_author" => "Autor",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Diagnostics creator
    "create-denied-title" => "¡Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos diagnósticos.Por favor, póngase en contacto con el administrador del sistema o, en su defecto, con el personal de soporte técnico para que le sean asignados los permisos necesarios, si corresponde. Para continuar, presione la opción correspondiente en la parte inferior de este mensaje",
    "create-title" => "Crear nuevo diagnóstico",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "create-duplicate-title" => "¡Diagnóstico existente!",
    "create-duplicate-message" => "Este diagnóstico ya se había registrado previamente. Presione continuar en la parte inferior de este mensaje para regresar al listado general de diagnósticos.",
    "create-success-title" => "¡Diagnóstico registrado exitosamente!",
    "create-success-message" => "El diagnóstico se registró exitosamente. Para regresar al listado general de diagnósticos, presione continuar en la parte inferior de este mensaje.",
    // - Diagnostics viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o para la asignación de los permisos necesarios, si corresponde. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Diagnostics editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o para la asignación de los permisos necesarios, si corresponde. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar diagnóstico!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que intenta actualizar no existe o ha sido eliminado previamente. Para regresar al listado general de diagnósticos, presione continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Diagnóstico actualizado!",
    "edit-success-message" => "Los datos de diagnóstico se <b>actualizaron exitosamente</b>. Para retornar al listado general de diagnósticos, presione el botón continuar en la parte inferior de este mensaje.",
    // - Diagnostics deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o para la asignación de los permisos necesarios, si corresponde. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar diagnóstico!",
    "delete-message" => "Para confirmar la eliminación del diagnóstico <b>%s</b>, presione eliminar. Para regresar al listado general de diagnósticos, presione cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "El elemento que intenta eliminar no existe o ha sido eliminado previamente. Para regresar al listado general de diagnósticos, presione continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Diagnóstico eliminado exitosamente!",
    "delete-success-message" => "El diagnóstico se eliminó exitosamente. Para regresar al listado general de diagnósticos, presione el botón continuar en la parte inferior de este mensaje.",
    // - Diagnostics list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para obtener información adicional o para la asignación de los permisos necesarios, si corresponde. Para continuar, seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Diagnósticos de la política",
    // - Info Politic
    "info-politic" => "En el contexto de MIPG en Colombia, una política se concibe como un conjunto de principios, directrices y normas que guían la toma de decisiones y acciones dentro de una entidad pública, con el fin de alcanzar los objetivos estratégicos y cumplir con la misión y visión institucionales. Como parte integral del proceso de cumplimiento de estas políticas, se requiere llevar a cabo un autodiagnóstico para evaluar el nivel de cumplimiento de cada una de ellas de manera individualizada. Este autodiagnóstico permite identificar áreas de mejora y fortalecimiento en la implementación de las políticas, contribuyendo así a una gestión pública más eficaz y al logro de los resultados esperados por la entidad. Este listado corresponde a todas las políticas relacionadas con una dimensión específica, para las cuales se deberán desarrollar autodiagnósticos individuales.",
];

?>