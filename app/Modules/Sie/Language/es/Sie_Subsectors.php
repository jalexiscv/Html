<?php

return [
    // --- Campos del Modelo de Subsectores (Etiquetas) ---
    'label_subsector' => 'Código del Subsector',
    'label_network' => 'Red de Conocimiento',
    'label_reference' => 'Referencia',
    'label_name' => 'Nombre del Subsector',
    'label_description' => 'Descripción',
    'label_moodle_course_base' => 'Base de Cursos Moodle',
    'label_created_by' => 'Creado Por',
    'label_updated_by' => 'Actualizado Por',
    'label_deleted_by' => 'Eliminado Por',
    'label_created_at' => 'Fecha de Creación',
    'label_updated_at' => 'Fecha de Actualización',
    'label_deleted_at' => 'Fecha de Eliminación',

    // --- Marcadores de Posición (Placeholders) ---
    'placeholder_subsector' => 'Código único del subsector, ej: SUB-01',
    'placeholder_network' => 'Seleccione la red de conocimiento',
    'placeholder_name' => 'Ej: Desarrollo de Software',
    'placeholder_reference' => 'Ej: REF001',
    'placeholder_moodle_course_base' => 'Ej: MCB001',
    'placeholder_description' => 'Ingrese una descripción detallada del subsector de conocimiento.',

    // --- Textos de Ayuda (Help) ---
    'help_subsector' => 'Código único que identifica el subsector de conocimiento.',
    'help_network' => 'Red de conocimiento a la que pertenece este subsector.',
    'help_reference' => 'Ej: REF001',
    'help_name' => 'Nombre completo y descriptivo del subsector.',
    'help_description' => 'Proporcione una descripción clara de los objetivos y el alcance del subsector.',

    // --- Creación de Subsectores ---
    'create-denied-title' => 'Acceso Denegado',
    'create-denied-message' => 'Su rol en la plataforma no posee los privilegios requeridos para crear nuevos Subsectores. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente.',
    'create-title' => 'Crear Nuevo Subsector',
    'create-errors-title' => '¡Advertencia!',
    'create-errors-message' => 'Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.',
    'create-duplicate-title' => '¡El Subsector ya Existe!',
    'create-duplicate-message' => "El Subsector que intenta crear ya ha sido registrado previamente. Presione 'Continuar' para retornar al listado general de Subsectores.",
    'create-success-title' => '¡Subsector Registrado Exitosamente!',
    'create-success-message' => "El Subsector se registró exitosamente. Para retornar al listado general de Subsectores, presione 'Continuar'.",

    // --- Vista de Subsectores ---
    'view-denied-title' => '¡Acceso Denegado!',
    'view-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar Subsectores en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'view-title' => 'Ver Subsector',
    'view-noexist-title' => '¡El Subsector no Existe!',
    'view-noexist-message' => "El Subsector que intenta visualizar no existe o fue eliminado previamente. Presione 'Continuar' para volver al listado de Subsectores.",

    // --- Edición de Subsectores ---
    'edit-denied-title' => '¡Acceso Denegado!',
    'edit-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar Subsectores en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'edit-title' => 'Actualizar Subsector',
    'edit-errors-title' => '¡Advertencia!',
    'edit-errors-message' => 'Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.',
    'edit-noexist-title' => '¡El Subsector no Existe!',
    'edit-noexist-message' => "El Subsector que intenta actualizar no existe o fue eliminado previamente. Presione 'Continuar' para retornar al listado general de Subsectores.",
    'edit-success-title' => '¡Subsector Actualizado!',
    'edit-success-message' => "Los datos del Subsector se <b>actualizaron exitosamente</b>. Para retornar al listado general de Subsectores, presione el botón 'Continuar'.",

    // --- Eliminación de Subsectores ---
    'delete-denied-title' => '¡Acceso Denegado!',
    'delete-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar Subsectores en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'delete-title' => 'Eliminar Subsector',
    'delete-message' => "Para confirmar la eliminación del Subsector <b>%s</b>, presione 'Eliminar'. Para cancelar y retornar al listado general de Subsectores, presione 'Cancelar'.",
    'delete-errors-title' => '¡Advertencia!',
    'delete-errors-message' => 'No se pudo eliminar el Subsector debido a un error. Por favor, inténtelo nuevamente.',
    'delete-noexist-title' => '¡El Subsector no Existe!',
    'delete-noexist-message' => "El Subsector que intenta eliminar no existe o fue eliminado previamente. Presione 'Continuar' para retornar al listado general de Subsectores.",
    'delete-success-title' => '¡Subsector Eliminado Exitosamente!',
    'delete-success-message' => "El Subsector se eliminó exitosamente. Para retornar al listado general de Subsectores, presione el botón 'Continuar'.",
    'delete-locked-title' => "¡Subsector Bloqueado!",
    'delete-locked-message' => "No es posible eliminar el <b>subsector</b> indicado, ya que contiene modulos activos o módulos asociados, lo cual generaría inconsistencias en la plataforma. Cabe señalar que estas redes se crean según normativas vigentes y, por tanto, su eliminación no procede mediante decisiones institucionales.",
    // --- Listado de Subsectores ---
    'list-denied-title' => '¡Acceso Denegado!',
    'list-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de Subsectores. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'list-title' => 'Listado de Subsectores de Conocimiento',
    'list-description' => 'A continuación se presenta el listado de subsectores de conocimiento registrados en el sistema.',
    'list-norecords-title' => 'No se Encontraron Registros',
    'list-norecords-message' => 'No se encontraron Subsectores que coincidan con los criterios de búsqueda. Por favor, intente con otros términos o cree un nuevo subsector.',
];

?>