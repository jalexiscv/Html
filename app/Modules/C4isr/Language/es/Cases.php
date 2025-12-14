<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Cases\Creator\index.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
* El código resultante corresponde con los elementos parciales del vector de 
* lenguaje utilizado para traducir la interface del módulo, estos elementos se deben copiar 
* y pegar en el archivo de traducción modular según corresponda, teniendo por finalidad 
* acelerar el proceso de programación al servir como una plantilla base para las posibles 
* cadenas de lenguaje y traducción asociadas a la creación de los formatos de visualización, 
* creación, edición y eliminación de componentes puntuales.* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
return [
    // - Cases fields
    "label_case" => "Código del caso",
    "label_country" => "País",
    "label_identifier" => "Identificador",
    "label_reference" => "Referencia",
    "label_title" => "Titulo del caso",
    "label_description" => "Descripción ",
    "label_search" => "Búsqueda",
    "label_status" => "Estado",
    "label_cover" => "cover",
    "label_author" => "author",
    "label_created_at" => "created_at",
    "label_updated_at" => "updated_at",
    "label_deleted_at" => "deleted_at",
    "label_dork" => "Dorks",
    "label_template" => "Plantilla",
    "label_submit" => "",
    "label_vulnerability" => "Vulnerabilidad",
    "label_authentication" => "Protocolo",
    "label_service" => "Servicio",
    "label_domain" => "Dominio",
    "label_type" => "Tipo de análisis",
    "label_explore" => "Explorar",
    "label_variant" => "Variante",
    "darkweb_label_submit" => "",
    "darkweb_label_case" => "Caso",
    "darkweb_label_query" => "Búsqueda",
    "placeholder_case" => "",
    "placeholder_search" => "Ej: usuario@mail.com",
    "placeholder_reference" => "Ej: CYBER-2021-0001",
    "placeholder_title" => "Ej: Investigación de fraude",
    "placeholder_description" => "Ej: Caso de violación de datos que involucra la exposición no autorizada de información confidencial y credenciales de acceso de funcionarios activos. La fuga de datos parece haberse originado desde dentro de la organización, lo que sugiere un posible escenario de amenaza interna.",
    "placeholder_status" => "status",
    "placeholder_cover" => "cover",
    "placeholder_domain" => "Ej: mil.co",
    "placeholder_author" => "author",
    "placeholder_query" => "Ej: vuln:MS17-010 country:CO hostname:*.gov.co",
    "placeholder_created_at" => "created_at",
    "placeholder_updated_at" => "updated_at",
    "placeholder_deleted_at" => "deleted_at",
    "darkweb_placeholder_query" => "Ej: usuario@gmail.com",
    "help_case" => "Automático",
    "help_reference" => "reference",
    "help_search" => "Texto: Alias, Email, Teléfono, Nombre, Etc... ",
    "help_description" => "description",
    "help_status" => "status",
    "help_cover" => "cover",
    "help_author" => "author",
    "help_created_at" => "created_at",
    "help_updated_at" => "updated_at",
    "help_deleted_at" => "deleted_at",
    "help_country" => "Seleccione un país",
    "help_identifier" => "Seleccione un identificador",
    "help_submit" => "",
    "help_explore" => "Seleccione un tipo de análisis",
    "help_variant" => "Seleccione una variante",
    "help_domain" => "Dominio o expresión de búsqueda final",
    "help_query" => "Comandos etc",
    "darkweb_help_case" => "Automático",
    "darkweb_help_submit" => "",
    "darkweb_help_query" => "emails, dominios, alias",
    // - Cases creator
    "create-denied-title" => "Acceso denegado!",
    "create-denied-message" => "Su rol en la plataforma no posee los privilegios requeridos para crear nuevos casos, por favor póngase en contacto con el administrador del sistema o en su efecto contacte al personal de soporte técnico para que estos le sean asignados, según sea el caso. Para continuar presioné la opción correspondiente en la parte inferior de este mensaje.",
    "create-title" => "Crear nuevo caso",
    "create-errors-title" => "¡Advertencia!",
    "create-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "create-duplicate-title" => "¡caso existente!",
    "create-duplicate-message" => "Este caso ya se había registrado previamente, presioné continuar en la parte inferior de este mensaje para retornar al listado general de casos.",
    "create-success-title" => "¡caso registrado exitosamente!",
    "create-success-message" => "El caso se registró exitosamente, para retornar al listado general de casos presioné continuar en la parte inferior de este mensaje.",
    // - Cases viewer
    "view-denied-title" => "¡Acceso denegado!",
    "view-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para casos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "view-title" => "Caso %s",
    "view-errors-title" => "¡Advertencia!",
    "view-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "view-noexist-title" => "¡No existe!",
    "view-noexist-message" => "",
    "view-success-title" => "",
    "view-success-message" => "",
    // - Cases editor
    "edit-denied-title" => "¡Advertencia!",
    "edit-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para actualizar casos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "edit-title" => "¡Actualizar casos!",
    "edit-errors-title" => "¡Advertencia!",
    "edit-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "edit-noexist-title" => "¡No existe!",
    "edit-noexist-message" => "El elemento que actualizar no existe o se elimino previamente, para retornar al listado general de XXX presioné continuar en la parte inferior de este mensaje. ",
    "edit-success-title" => "¡caso actualizado!",
    "edit-success-message" => "Los datos de casos se <b>actualizaron exitosamente</b>, para retornar al listado general de casos presioné el botón continuar en la parte inferior del presente mensaje.",
    // - Cases deleter
    "delete-denied-title" => "¡Advertencia!",
    "delete-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para eliminar cases en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "delete-title" => "¡Eliminar caso!",
    "delete-message" => "Para confirmar la eliminación del cases <b>%s</b>, presioné eliminar, para retornar al listado general de cases presioné cancelar.",
    "delete-errors-title" => "¡Advertencia!",
    "delete-errors-message" => "Los datos proporcionados son incorrectos o están incompletos, por favor verifique eh inténtelo nuevamente.",
    "delete-noexist-title" => "¡No existe!",
    "delete-noexist-message" => "\El elemento que intenta eliminar no existe o se elimino previamente, para retornar al listado general de casos presioné continuar en la parte inferior de este mensaje.",
    "delete-success-title" => "¡caso eliminado exitosamente!",
    "delete-success-message" => "El caso se elimino exitosamente, para retornar al listado de general de casos presioné el botón continuar en la parte inferior de este mensaje.",
    // - Cases list
    "list-denied-title" => "¡Advertencia!",
    "list-denied-message" => "Los roles asignados a su perfil, no le conceden los privilegios necesarios para acceder al listado general de casos en esta plataforma. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "list-title" => "Listado de cases",
    //[Search]
    "label_query" => "Consulta avanzada",
    "search-title" => "Buscar de vulnerabilidades",
    "osints-view-forbidden-title" => "Acceso denegado",
    "osints-view-forbidden-message" => "Lamentamos informarle que, según las regulaciones y políticas aplicables en el país y según su licencia actual, en este caso específico usted <u>no posee los permisos necesarios para llevar a cabo investigaciones de datos tipo SINT (Source Intelligence) en la nación especificada</u>. Le solicitamos que respete las leyes y normativas locales establecidas en su modelo de licencia. Si desea obtener más información sobre cómo obtener los permisos adecuados o si tiene alguna consulta relacionada, le recomendamos que se comunique con soporte técnico o comercial según corresponda. Agradecemos su comprensión y cooperación. Contacte al departamento de soporte técnico para información adicional, o la asignación de los permisos necesarios si es el caso. Para continuar seleccione la opción correspondiente en la parte inferior de este mensaje.",
    "sints-info" => "Es una avanzada plataforma de <u>Source Intelligence</u>, que conecta y analiza <u>diversas fuentes de datos</u>, está diseñada para la <u>búsqueda</u> y <u>recuperación</u> de información sobre individuos a través de múltiples vectores, como país, documento de identificación, teléfono o correo electrónico. Al combinar técnicas de <u>ciberseguridad</u>, <u>inteligencia artificial</u> y <u>procesamiento de lenguaje natural</u>, SINT proporciona una solución de inteligencia altamente precisa y eficiente. La arquitectura del sistema SINT se basa en módulos escalables y flexibles, que permiten la integración de diversas fuentes de datos y la adaptación a los constantes cambios en el panorama de la ciberseguridad. ",
    "cve-info" => "Esta herramienta utiliza la información de la base de datos CVE para buscar vulnerabilidades conocidas en sistemas y servidores específicos, utilizando técnicas como el escaneo de puertos y la identificación de servicios. Al ejecutar la herramienta, se puede escanear una red o un sistema individual para detectar las vulnerabilidades conocidas en la base de datos CVE. Una vez que se detectan las vulnerabilidades, el sistema produce informes detallados que incluyen información sobre las vulnerabilidades detectadas, su nivel de peligro y recomendaciones para su mitigación.",
    "darkweb-info" => "Esta herramienta permite la detección de brechas de seguridad alimentado por medios de búsqueda en la web oscura. Este software innovador y poderoso es capaz de buscar y comparar información confidencial almacenada en el sistema y aquella disponible en la red oscura. DarkWeb proporciona una solución eficaz para la detección de brechas de seguridad y garantiza la protección efectiva de la privacidad y seguridad de la información en las organizaciones. Con una interfaz inteligente, fácil de usar y totalmente automatizada, DarkWeb simplifica el monitoreo y gestión de posibles amenazas de seguridad para garantizar la seguridad total de la información de la organización.",
];

?>