<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
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
    "tdp-info-requirement" => "Este diagnóstico se generara para el requerimiento <u>%s</u>.",
    "tdp-diagnostic-info-message" => "En el contexto del MIPG (Modelo Integrado de Planeación y Gestión) en Colombia, un autodiagnóstico es un proceso sistemático mediante el cual una entidad pública evalúa su propio desempeño en relación con las políticas, procesos y prácticas establecidas por el modelo. Este proceso implica analizar y medir el grado de cumplimiento de las políticas y estándares definidos en el MIPG en áreas clave como la gestión del talento humano, la gestión financiera, la gestión de la calidad, la transparencia y la rendición de cuentas, entre otras.",
    "tdp-diagnostic-info-title" => "Autodiagnósticos",
    // - Diagnostics fields
    "label_diagnostic" => "Código del diagnóstico",
    "label_line" => "Código de la linea estratégica",
    "label_order" => "Orden",
    "label_name" => "Nombre del diagnóstico",
    "label_description" => "Descripción del diagnóstico",
    "label_version" => "Versión del diagnóstico",
    "label_author" => "author",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "placeholder_diagnostic" => "diagnostic",
    "placeholder_requirement" => "requirement",
    "placeholder_order" => "order",
    "placeholder_name" => "Ej: Diagnóstico 2024",
    "placeholder_description" => "Ej: Diagnóstico de la norma ISO 9001:2015",
    "placeholder_version" => "version",
    "placeholder_author" => "author",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "help_diagnostic" => "Generado automáticamente",
    "help_line" => "Heredado de la linea estratégica",
    "help_order" => "Requerido",
    "help_name" => "Requerido",
    "help_description" => "Requerido",
    "help_version" => "Requerido",
    "help_author" => "author",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    // - Diagnostics creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos diagnósticos, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo diagnóstico",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡diagnóstico existente!",
    "create-duplicate-message" => "Este diagnóstico ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de diagnósticos.",
    "create-success-title" => "¡Diagnóstico registrado exitosamente!",
    "create-success-message" => "El diagnóstico se registró exitosamente, para retornar al listado general de diagnósticos presioné continuar en la parte inferior de este mensaje.",
    // - Diagnostics viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para visualizar diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Vista",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Diagnostics editor
    "tdp-edit-alert-title" => "Actualizar diagnóstico",
    "tdp-edit-alert-message" => "Recuerde que los diagnósticos son evaluaciones detalladas de la situación actual del municipio o territorio en las diferentes dimensiones (social, económica, ambiental, etc.). Incluyen el análisis de fortalezas, debilidades, oportunidades y amenazas (FODA), así como la identificación de necesidades, problemas y potencialidades. Los diagnósticos proveen la base factual y analítica para la formulación de objetivos, estrategias y programas. Para actualizar el diagnóstico \"<b>%s</b>\", complete el formulario con la información correspondiente y presione el botón guardar para aplicar los cambios. Para retornar al listado general de diagnósticos presioné cancelar.",
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar diagnóstico!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de diagnósticos presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡Diagnóstico actualizado!",
    "edit-success-message" => "Los datos de diagnóstico se <b>actualizaron exitosamente</b>, para retornar al listado general de diagnósticos presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Diagnostics deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar diagnóstico!",
    "delete-message" => "Para confirmar la eliminación del diagnóstico <b>%s</b>, presioné eliminar, para retornar al listado general de diagnósticos presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de diagnósticos presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡Diagnóstico eliminado exitosamente!",
    "delete-success-message" => "El diagnóstico se elimino exitosamente, para retornar al listado de general de diagnósticos presioné el botón continuar en la parte inferior de este mensaje.",
    // - Diagnostics list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "tdp-list-title" => "Línea Estratégica / Diagnósticos",
    "tdp-diagnostic-info-title" => "Diagnóstico de una Línea Estratégica",
    "tdp-diagnostic-info-message" => "Se trata de un proceso analítico y sistemático destinado a identificar, comprender y evaluar de manera integral y detallada las condiciones actuales y los factores internos y externos que afectan una determinada área o tema de interés (línea estratégica) dentro de un territorio o comunidad. Este proceso incluye la recolección y análisis de datos cuantitativos y cualitativos, la identificación de necesidades, desafíos, oportunidades, fortalezas y debilidades, así como la comprensión de las dinámicas y relaciones entre los distintos actores involucrados.",
];

?>