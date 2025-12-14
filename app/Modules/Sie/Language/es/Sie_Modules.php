<?php

return [
    // --- Campos del Modelo de Módulos (Etiquetas) ---
    'label_module' => 'Código del Módulo',
    'label_reference' => 'Referencia',
    'label_acronym' => 'Acrónimo',
    'label_name' => 'Nombre del Módulo',
    'label_status' => 'Estado del Módulo',
    'label_author' => 'Autor',
    'label_red' => 'Red de Conocimiento',
    'label_subsector' => 'Subsector de Conocimiento',
    'label_created_at' => 'Fecha de Creación',
    'label_updated_at' => 'Fecha de Actualización',
    'label_deleted_at' => 'Fecha de Eliminación',

    // --- Marcadores de Posición (Placeholders) ---
    'placeholder_module' => 'Código único del módulo, ej: MOD-01',
    'placeholder_reference' => 'Referencia o código alterno',
    'placeholder_acronym' => 'Ej: CAD',
    'placeholder_name' => 'Ej: Competencias Digitales',
    'placeholder_status' => 'Seleccione el estado del módulo',
    'placeholder_red' => 'Seleccione la red de conocimiento',
    'placeholder_subsector' => 'Seleccione el subsector de conocimiento',

    // --- Textos de Ayuda (Help) ---
    'help_module' => 'Código único que identifica el módulo de conocimiento.',
    'help_reference' => 'Referencia o código secundario para el módulo.',
    'help_acronym' => 'Siglas o acrónimo que identifica al módulo.',
    'help_name' => 'Nombre completo y descriptivo del módulo.',
    'help_status' => 'Estado actual del módulo (Activo/Inactivo).',
    'help_author' => 'Usuario que registra el módulo.',
    'help_red' => 'Red de conocimiento a la que pertenece este módulo.',
    'help_subsector' => 'Subsector de conocimiento al que pertenece este módulo.',

    // --- Creación de Módulos ---
    'create-denied-title' => 'Acceso Denegado',
    'create-denied-message' => 'Su rol en la plataforma no posee los privilegios requeridos para crear nuevos Módulos. Por favor, póngase en contacto con el administrador del sistema o con el personal de soporte técnico para que le sean asignados, según sea el caso. Para continuar, presione la opción correspondiente.',
    'create-title' => 'Crear Nuevo Módulo',
    'create-errors-title' => '¡Advertencia!',
    'create-errors-message' => 'Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.',
    'create-duplicate-title' => '¡El Módulo ya Existe!',
    'create-duplicate-message' => "El Módulo que intenta crear ya ha sido registrado previamente. Presione 'Continuar' para retornar al listado general de Módulos.",
    'create-success-title' => '¡Módulo Registrado Exitosamente!',
    'create-success-message' => "El Módulo se registró exitosamente. Para retornar al listado general de Módulos, presione 'Continuar'.",

    // --- Vista de Módulos ---
    'view-denied-title' => '¡Acceso Denegado!',
    'view-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para visualizar Módulos en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'view-title' => 'Ver Módulo',
    'view-noexist-title' => '¡El Módulo no Existe!',
    'view-noexist-message' => "El Módulo que intenta visualizar no existe o fue eliminado previamente. Presione 'Continuar' para volver al listado de Módulos.",

    // --- Edición de Módulos ---
    'edit-denied-title' => '¡Acceso Denegado!',
    'edit-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para actualizar Módulos en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'edit-title' => 'Actualizar Módulo',
    'edit-errors-title' => '¡Advertencia!',
    'edit-errors-message' => 'Los datos proporcionados son incorrectos o están incompletos. Por favor, verifique e inténtelo nuevamente.',
    'edit-noexist-title' => '¡El Módulo no Existe!',
    'edit-noexist-message' => "El Módulo que intenta actualizar no existe o fue eliminado previamente. Presione 'Continuar' para retornar al listado general de Módulos.",
    'edit-success-title' => '¡Módulo Actualizado!',
    'edit-success-message' => "Los datos del Módulo se <b>actualizaron exitosamente</b>. Para retornar al listado general de Módulos, presione el botón 'Continuar'.",

    // --- Eliminación de Módulos ---
    'delete-denied-title' => '¡Acceso Denegado!',
    'delete-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para eliminar Módulos en esta plataforma. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'delete-title' => 'Eliminar Módulo',
    'delete-message' => "Para confirmar la eliminación del Módulo <b>%s</b>, presione 'Eliminar'. Para cancelar y retornar al listado general de Módulos, presione 'Cancelar'.",
    'delete-errors-title' => '¡Advertencia!',
    'delete-errors-message' => 'No se pudo eliminar el Módulo debido a un error. Por favor, inténtelo nuevamente.',
    'delete-noexist-title' => '¡El Módulo no Existe!',
    'delete-noexist-message' => "El Módulo que intenta eliminar no existe o fue eliminado previamente. Presione 'Continuar' para retornar al listado general de Módulos.",
    'delete-success-title' => '¡Módulo Eliminado Exitosamente!',
    'delete-success-message' => "El Módulo se eliminó exitosamente. Para retornar al listado general de Módulos, presione el botón 'Continuar'.",
    'delete-module-deneged-title' => '¡No se puede eliminar!',
    'delete-module-deneged-message' => "El módulo que intentas eliminar no puede ser borrado, ya que forma parte de uno o varios planes de estudio (pensum) de programas académicos activos. Por motivos de consistencia académica e integridad de la información, los módulos son elementos permanentes en el sistema y deben conservarse, incluso si dejan de usarse en determinados programas. Lo que sí es posible es desvincular el módulo de los pensum donde ya no aplique, pero el módulo como tal permanecerá registrado para garantizar coherencia histórica y trazabilidad académica.",

    // --- Listado de Módulos ---
    'list-denied-title' => '¡Acceso Denegado!',
    'list-denied-message' => 'Los roles asignados a su perfil no le conceden los privilegios necesarios para acceder al listado general de Módulos. Contacte al departamento de soporte técnico para información adicional o para la asignación de los permisos necesarios, si es el caso. Para continuar, seleccione la opción correspondiente.',
    'list-title' => 'Listado de Módulos de Conocimiento',
    'list-description' => 'A continuación se presenta el listado de módulos de conocimiento registrados en el sistema.',
    'list-norecords-title' => 'No se Encontraron Registros',
    'list-norecords-message' => 'No se encontraron Módulos que coincidan con los criterios de búsqueda. Por favor, intente con otros términos o cree un nuevo módulo.',

    // --- Alertas Adicionales ---
    "create-module-alert-title" => "Módulos Transversales y Formación por Extensión",
    "create-module-alert-message" => "Los módulos transversales son asignaturas o componentes de formación que pueden estar presentes en varios programas académicos. Aunque en cada plan de estudios puedan aparecer con nombres ligeramente diferentes (por ejemplo: Informática básica, Competencias digitales o Herramientas TIC), a nivel lógico comparten una misma base de datos y estructura. Esto permite que los módulos sean portables y reutilizables entre diferentes programas, evitando duplicidad y garantizando coherencia académica. Además, existe el programa de Formación por Extensión, que se enfoca en ofrecer cursos cortos y complementarios. Estos cursos están diseñados como espacios de refuerzo académico o actualización de conocimientos, a los que los estudiantes pueden acceder de manera voluntaria para fortalecer competencias específicas. La extensión cumple un papel estratégico en la proyección social y en la formación continua, permitiendo que la institución responda de forma flexible a necesidades de aprendizaje inmediatas. Cuando crees un módulo, ten en cuenta que este podrá ser compartido entre programas formales y también ser ofertado como curso de extensión si la institución así lo decide.",
];

?>