<?php

return [
    // --- Campos del Modelo de Redes (Etiquetas) ---
    'label_network' => 'Código de la Red',
    'label_reference' => 'Referencia',
    'label_name' => 'Nombre de la Red',
    'label_description' => 'Descripción',
    'label_created_by' => 'Creado Por',
    'label_updated_by' => 'Actualizado Por',
    'label_deleted_by' => 'Eliminado Por',
    'label_created_at' => 'Fecha de Creación',
    'label_updated_at' => 'Fecha de Actualización',
    'label_deleted_at' => 'Fecha de Eliminación',

    // --- Marcadores de Posición (Placeholders) ---
    'placeholder_network' => 'Código único de la red, ej: RED-01',
    'placeholder_reference' => 'Referencia o código alterno',
    'placeholder_name' => 'Ej: Red de Transformación Productiva',
    'placeholder_description' => 'Ingrese una descripción detallada de la red de conocimiento.',

    // --- Textos de Ayuda (Help) ---
    'help_network' => 'Código único que identifica la red de conocimiento.',
    'help_reference' => 'Referencia o código secundario para la red.',
    'help_name' => 'Nombre completo y descriptivo de la red.',
    'help_description' => 'Proporcione una descripción clara de los objetivos y el alcance de la red.',

    // --- Creación de Redes ---
    'create-denied-title' => 'Acceso Denegado',
    'create-denied-message' => 'Su rol en la plataforma no posee los privilegios requeridos para crear nuevas Redes. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente.',
    'create-title' => 'Crear Nueva Red',
    'create-errors-title' => '¡Advertencia!',
    'create-errors-message' => 'Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.',
    'create-duplicate-title' => '¡Red Existente!',
    'create-duplicate-message' => "La Red que intenta crear ya ha sido registrada previamente. Presione 'Continuar' para retornar al listado general de Redes.",
    'create-success-title' => '¡Red Registrada Exitosamente!',
    'create-success-message' => "La Red se registró exitosamente. Para retornar al listado general de Redes, presione 'Continuar'.",

    // --- Vista de Redes ---
    'view-denied-title' => '¡Acceso Denegado!',
    'view-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar Redes en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'view-title' => 'Ver Red',
    'view-noexist-title' => '¡Red no Encontrada!',
    'view-noexist-message' => "La Red que intenta visualizar no existe o fue eliminada previamente. Presione 'Continuar' para volver al listado de Redes.",

    // --- Edición de Redes ---
    'edit-denied-title' => '¡Acceso Denegado!',
    'edit-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar Redes en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'edit-title' => 'Actualizar Red',
    'edit-errors-title' => '¡Advertencia!',
    'edit-errors-message' => 'Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.',
    'edit-noexist-title' => '¡Red no Encontrada!',
    'edit-noexist-message' => "La Red que intenta actualizar no existe o fue eliminada previamente. Presione 'Continuar' para retornar al listado general de Redes.",
    'edit-success-title' => '¡Red Actualizada!',
    'edit-success-message' => "Los datos de la Red se <b>actualizaron exitosamente</b>. Para retornar al listado general de Redes, presione el botón 'Continuar'.",

    // --- Eliminación de Redes ---
    'delete-denied-title' => '¡Acceso Denegado!',
    'delete-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar Redes en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'delete-title' => 'Eliminar Red',
    'delete-message' => "Para confirmar la eliminación de la Red <b>%s</b>, presione 'Eliminar'. Para cancelar y retornar al listado general de Redes, presione 'Cancelar'.",
    'delete-errors-title' => '¡Advertencia!',
    'delete-errors-message' => 'No se pudo eliminar la Red debido a un error. Por favor, inténtelo nuevamente.',
    'delete-noexist-title' => '¡Red no Encontrada!',
    'delete-noexist-message' => "La Red que intenta eliminar no existe o fue eliminada previamente. Presione 'Continuar' para retornar al listado general de Redes.",
    'delete-success-title' => '¡Red Eliminada Exitosamente!',
    'delete-success-message' => "La Red se eliminó exitosamente. Para retornar al listado general de Redes, presione el botón 'Continuar'.",
    'delete-locked-title' => "¡Red Bloqueada!",
    'delete-locked-message' => "No es posible eliminar la <b>Red de Conocimiento</b> indicada, ya que contiene subsectores activos o con historial de módulos asociados, lo cual generaría inconsistencias en la plataforma. Cabe señalar que estas redes se crean según normativas vigentes y, por tanto, su eliminación no procede mediante decisiones institucionales.",
    // --- Listado de Redes ---
    'list-denied-title' => '¡Acceso Denegado!',
    'list-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de Redes. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'list-title' => 'Listado de Redes de Conocimiento',
    'list-description' => 'A continuación se presenta el listado de redes de conocimiento registradas en el sistema.',
    'list-norecords-title' => 'No se Encontraron Registros',
    'list-norecords-message' => 'No se encontraron Redes que coincidan con los criterios de búsqueda. Por favor, intente con otros términos o cree una nueva red.',
];

?>