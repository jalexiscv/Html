<?php

return [
    // --- Campos del Modelo de Episodios (Etiquetas) ---
    'label_episode' => 'Código del Episodio',
    'label_patient' => 'Paciente',
    'label_start_date' => 'Fecha de Inicio',
    'label_end_date' => 'Fecha de Fin',
    'label_reason_for_visit' => 'Motivo de la Consulta',
    'label_general_notes' => 'Notas Generales',
    'label_author' => 'Autor',
    'label_created_at' => 'Fecha de Creación',
    'label_updated_at' => 'Fecha de Actualización',
    'label_deleted_at' => 'Fecha de Eliminación',

    // --- Marcadores de Posición (Placeholders) ---
    'placeholder_episode' => 'Ej: EPI-00123',
    'placeholder_patient' => 'Seleccione un paciente',
    'placeholder_start_date' => 'Seleccione la fecha de inicio',
    'placeholder_end_date' => 'Seleccione la fecha de finalización (si aplica)',
    'placeholder_reason_for_visit' => 'Ej: Control anual de retinopatía diabética',
    'placeholder_general_notes' => 'Ej: Paciente refiere disminución de la agudeza visual en el último mes.',
    'placeholder_author' => 'Autor del registro',

    // --- Textos de Ayuda (Help) ---
    'help_episode' => 'Identificador único del episodio clínico.',
    'help_patient' => 'Paciente asociado a este episodio clínico.',
    'help_start_date' => 'Fecha en que se inicia el episodio clínico.',
    'help_end_date' => 'Fecha en que finaliza el episodio clínico (opcional).',
    'help_reason_for_visit' => 'Motivo principal que origina la consulta o el episodio.',
    'help_general_notes' => 'Notas y observaciones generales sobre el episodio.',
    'help_author' => 'Usuario que registra el episodio.',

    // --- Creación de Episodios ---
    'create-denied-title' => 'Acceso Denegado',
    'create-denied-message' => 'Su rol en la plataforma no posee los privilegios requeridos para crear nuevos Episodios. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente.',
    'create-title' => 'Crear Nuevo Episodio',
    'create-errors-title' => '¡Advertencia!',
    'create-errors-message' => 'Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.',
    'create-duplicate-title' => '¡Episodio Existente!',
    'create-duplicate-message' => "Este Episodio ya ha sido registrado previamente. Presione 'Continuar' para retornar al listado general de Episodios.",
    'create-success-title' => '¡Episodio Registrado Exitosamente!',
    'create-success-message' => "El Episodio se registró exitosamente. Para retornar al listado general de Episodios, presione 'Continuar'.",

    // --- Vista de Episodios ---
    'view-denied-title' => '¡Acceso Denegado!',
    'view-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar Episodios en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'view-title' => 'Ver Episodio',
    'view-noexist-title' => '¡Episodio no Existe!',
    'view-noexist-message' => "El Episodio que intenta visualizar no existe o fue eliminado previamente. Presione 'Continuar' para volver al listado de Episodios.",

    // --- Edición de Episodios ---
    'edit-denied-title' => '¡Acceso Denegado!',
    'edit-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar Episodios en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'edit-title' => 'Actualizar Episodio',
    'edit-errors-title' => '¡Advertencia!',
    'edit-errors-message' => 'Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.',
    'edit-noexist-title' => '¡Episodio no Existe!',
    'edit-noexist-message' => "El Episodio que intenta actualizar no existe o fue eliminado previamente. Presione 'Continuar' para retornar al listado general de Episodios.",
    'edit-success-title' => '¡Episodio Actualizado!',
    'edit-success-message' => "Los datos del Episodio se <b>actualizaron exitosamente</b>. Para retornar al listado general de Episodios, presione el botón 'Continuar'.",

    // --- Eliminación de Episodios ---
    'delete-denied-title' => '¡Acceso Denegado!',
    'delete-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar Episodios en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'delete-title' => 'Eliminar Episodio',
    'delete-message' => "Para confirmar la eliminación del Episodio <b>%s</b>, presione 'Eliminar'. Para cancelar y retornar al listado general de Episodios, presione 'Cancelar'.",
    'delete-errors-title' => '¡Advertencia!',
    'delete-errors-message' => 'No se pudo eliminar el Episodio debido a un error. Por favor, inténtelo nuevamente.',
    'delete-noexist-title' => '¡Episodio no Existe!',
    'delete-noexist-message' => "El Episodio que intenta eliminar no existe o fue eliminado previamente. Presione 'Continuar' para retornar al listado general de Episodios.",
    'delete-success-title' => '¡Episodio Eliminado Exitosamente!',
    'delete-success-message' => "El Episodio se eliminó exitosamente. Para retornar al listado general de Episodios, presione el botón 'Continuar'.",

    // --- Listado de Episodios ---
    'list-denied-title' => '¡Acceso Denegado!',
    'list-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de Episodios. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'list-title' => 'Listado de Episodios',
    'list-description' => 'A continuación se presenta el listado de episodios clínicos registrados en el sistema.',
    'list-norecords-title' => 'No se Encontraron Registros',
    'list-norecords-message' => 'No se encontraron episodios clínicos que coincidan con los criterios de búsqueda. Por favor, intente con otros términos o cree un nuevo episodio.',
];

?>
