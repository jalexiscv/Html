<?php

return [
    // --- Campos del Modelo de Diagnósticos (Etiquetas) ---
    'label_diagnostic' => 'Código del Diagnóstico',
    'label_study' => 'Estudio Asociado',
    'label_attachment' => 'Archivo Adjunto',
    'label_result_ia' => 'Análisis IA',
    'label_result' => 'Resultado Clínico Emitido',
    'label_created_by' => 'Creado Por',
    'label_updated_by' => 'Actualizado Por',
    'label_deleted_by' => 'Eliminado Por',
    'label_created_at' => 'Fecha de Creación',
    'label_updated_at' => 'Fecha de Actualización',
    'label_deleted_at' => 'Fecha de Eliminación',

    // --- Marcadores de Posición (Placeholders) ---
    'placeholder_diagnostic' => 'Ej: DIAG-00123',
    'placeholder_study' => 'Seleccione el estudio relacionado',
    'placeholder_attachment' => 'ID del archivo adjunto',
    'placeholder_result_ia' => 'Resultado del análisis de IA (formato JSON)',
    'placeholder_result' => 'Ingrese la interpretación y diagnóstico del especialista',

    // --- Textos de Ayuda (Help) ---
    'help_diagnostic' => 'Identificador único del diagnóstico.',
    'help_study' => 'Estudio clínico al que pertenece este diagnóstico.',
    'help_attachment' => 'Archivo (imagen, documento, etc.) asociado al diagnóstico.',
    'help_result_ia' => 'Resultado generado automáticamente por el modelo de Inteligencia Artificial.',
    'help_result' => 'Diagnóstico final, conclusiones o interpretación emitida por el profesional de la salud.',

    // --- Creación de Diagnósticos ---
    'create-denied-title' => 'Acceso Denegado',
    'create-denied-message' => 'Su rol en la plataforma no posee los privilegios requeridos para crear nuevos Diagnósticos. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente.',
    'create-title' => 'Crear Nuevo Diagnóstico',
    'create-errors-title' => '¡Advertencia!',
    'create-errors-message' => 'Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.',
    'create-duplicate-title' => '¡Diagnóstico Existente!',
    'create-duplicate-message' => "Este Diagnóstico ya ha sido registrado previamente. Presione 'Continuar' para retornar al listado general de Diagnósticos.",
    'create-success-title' => '¡Diagnóstico Registrado Exitosamente!',
    'create-success-message' => "El Diagnóstico se registró exitosamente. Para retornar al listado general de Diagnósticos, presione 'Continuar'.",

    // --- Vista de Diagnósticos ---
    'view-denied-title' => '¡Acceso Denegado!',
    'view-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar Diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'view-title' => 'Ver Diagnóstico',
    'view-noexist-title' => '¡Diagnóstico no Existe!',
    'view-noexist-message' => "El Diagnóstico que intenta visualizar no existe o fue eliminado previamente. Presione 'Continuar' para volver al listado de Diagnósticos.",

    // --- Edición de Diagnósticos ---
    'edit-denied-title' => '¡Acceso Denegado!',
    'edit-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar Diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'edit-title' => 'Actualizar Diagnóstico',
    'edit-errors-title' => '¡Advertencia!',
    'edit-errors-message' => 'Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.',
    'edit-noexist-title' => '¡Diagnóstico no Existe!',
    'edit-noexist-message' => "El Diagnóstico que intenta actualizar no existe o fue eliminado previamente. Presione 'Continuar' para retornar al listado general de Diagnósticos.",
    'edit-success-title' => '¡Diagnóstico Actualizado!',
    'edit-success-message' => "Los datos del Diagnóstico se <b>actualizaron exitosamente</b>. Para retornar al listado general de Diagnósticos, presione el botón 'Continuar'.",

    // --- Eliminación de Diagnósticos ---
    'delete-denied-title' => '¡Acceso Denegado!',
    'delete-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar Diagnósticos en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'delete-title' => 'Eliminar Diagnóstico',
    'delete-message' => "Para confirmar la eliminación del Diagnóstico <b>%s</b>, presione 'Eliminar'. Para cancelar y retornar al listado general de Diagnósticos, presione 'Cancelar'.",
    'delete-errors-title' => '¡Advertencia!',
    'delete-errors-message' => 'No se pudo eliminar el Diagnóstico debido a un error. Por favor, inténtelo nuevamente.',
    'delete-noexist-title' => '¡Diagnóstico no Existe!',
    'delete-noexist-message' => "El Diagnóstico que intenta eliminar no existe o fue eliminado previamente. Presione 'Continuar' para retornar al listado general de Diagnósticos.",
    'delete-success-title' => '¡Diagnóstico Eliminado Exitosamente!',
    'delete-success-message' => "El Diagnóstico se eliminó exitosamente. Para retornar al listado general de Diagnósticos, presione el botón 'Continuar'.",

    // --- Listado de Diagnósticos ---
    'list-denied-title' => '¡Acceso Denegado!',
    'list-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de Diagnósticos. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'list-title' => 'Listado de Diagnósticos',
    'list-description' => 'A continuación se presenta el listado de diagnósticos registrados en el sistema.',
    'list-norecords-title' => 'No se Encontraron Registros',
    'list-norecords-message' => 'No se encontraron diagnósticos que coincidan con los criterios de búsqueda. Por favor, intente con otros términos o cree un nuevo diagnóstico.',
];

?>