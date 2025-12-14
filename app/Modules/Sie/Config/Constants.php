<?php


const LIST_LINKAGE_TYPES2 = array(
    array("value" => "", "label" => "Seleccione un tipo..."),
    array("value" => "01", "label" => "Nuevo"),
    array("value" => "13", "label" => "Transferencia Interna"),
    array("value" => "02", "label" => "Movilidad interna"),
    array("value" => "03", "label" => "Homologación"),
    array("value" => "04", "label" => "Transferencia entre seccionales"),
    array("value" => "05", "label" => "Doble programa"),
    array("value" => "06", "label" => "Ciclo propedeútico"),
    array("value" => "07", "label" => "Co-Titulación o titulación conjunta o doble titulación"),
    array("value" => "08", "label" => "Estudiante de articulación"),
    array("value" => "09", "label" => "Estudiante SPP"),
    array("value" => "10", "label" => "Opción de grado"),
    array("value" => "11", "label" => "Semestre de intercambio académico"),
    array("value" => "12", "label" => "Requisito para convalidar título o homologación"),
    array("value" => "99", "label" => "Formación por extensión"),
);

const LIST_LINKAGE_TYPES = array(
    array("value" => "", "label" => "Seleccione un tipo..."),
    array("value" => "1", "label" => "Nuevo"),
    array("value" => "13", "label" => "Antiguo"),
    array("value" => "2", "label" => "Transferencia Interna"),
    array("value" => "3", "label" => "Transferencia Externa"),
    array("value" => "4", "label" => "Transferencia entre seccionales"),
    array("value" => "5", "label" => "Doble Programa"),
    array("value" => "6", "label" => "Ciclo propedeútico"),
    array("value" => "7", "label" => "Co-Titulación o Titulación Conjunta o Doble Titulación"),
    array("value" => "8", "label" => "Estudiante de Articulación"),
    array("value" => "9", "label" => "Estudiante SPP"),
    array("value" => "10", "label" => "Opción de Grado"),
    array("value" => "11", "label" => "Semestre de intercambio académico"),
    array("value" => "12", "label" => "Requisito para Convalidar Título o Homologación"),
    array("value" => "99", "label" => "Formación por extensión"),
);


const LIST_LINKAGE_TRAINING_TYPES = array(
    array("value" => "", "label" => "Seleccione un tipo..."),
    array("value" => "20", "label" => "Estudiante"),
    array("value" => "21", "label" => "Egresado"),
    array("value" => "22", "label" => "Comunidad"),
    array("value" => "23", "label" => "Profesor"),
    array("value" => "24", "label" => "Administrativo"),
);


const LIST_ETHNIC_GROUPS = array(
    array("value" => "0", "label" => "N/A (No aplica)"),
    array("value" => "1", "label" => "Pueblo indígena"),
    array("value" => "2", "label" => "Comunidad negra"),
    array("value" => "3", "label" => "Rom (gitano)"),
    array("value" => "4", "label" => "No pertenece"),
    array("value" => "5", "label" => "Raizal del Archipiélago de San Andrés, Providencia y Santa Catalina"),
    array("value" => "6", "label" => "Afrocolombiano"),
    array("value" => "7", "label" => "Palenquero de San Basilio"),
    array("value" => "8", "label" => "Mestizo(a)"),
    array("value" => "9", "label" => "Mulato(a)"),
    array("value" => "10", "label" => "Blanco(a)"),
    array("value" => "11", "label" => "Otro"),
    array("value" => "12", "label" => "No informa"),
);


/**
 * Nivel educativo del padre y madre
 * Sin escolaridad
 * Básica primaria
 * Básica primaria Incompleta
 * Básica secundaria
 * Básica secundaria Incompleta
 * Media (bachillerato) (9°)
 * Técnica
 * Tecnológica
 * Profesional universitario
 * Posgrado
 * No Tengo Información
 */

const LIST_PARENTS_EDUCATION_LEVELS = array(
    array("value" => "", "label" => "Sin información"),
    array("value" => "0", "label" => "Sin escolaridad"),
    array("value" => "1", "label" => "Básica primaria"),
    array("value" => "2", "label" => "Básica primaria Incompleta"),
    array("value" => "3", "label" => "Básica secundaria"),
    array("value" => "4", "label" => "Básica secundaria Incompleta"),
    array("value" => "5", "label" => "Media (bachillerato) (9°)"),
    array("value" => "6", "label" => "Técnica"),
    array("value" => "7", "label" => "Tecnológica"),
    array("value" => "8", "label" => "Profesional universitario"),
    array("value" => "9", "label" => "Posgrado"),
);

/**
 * Dependencia económica (selección única):
 * Dependiente económicamente
 * Parcialmente independiente
 * Totalmente independiente
 */
const LIST_DEPENDENCY_ECONOMIC = array(
    array("value" => "", "label" => "Sin información"),
    array("value" => "1", "label" => "Dependiente económicamente"),
    array("value" => "2", "label" => "Parcialmente independiente"),
    array("value" => "3", "label" => "Totalmente independiente"),
);

/**
 * Tipo de vivienda (selección única):
 * Propia
 * Familiar
 * Arriendo
 * Otra
 */

const LIST_HOUSING_TYPE = array(
    array("value" => "", "label" => "Sin información"),
    array("value" => "1", "label" => "Propia"),
    array("value" => "2", "label" => "Familiar"),
    array("value" => "3", "label" => "Arriendo"),
    array("value" => "4", "label" => "Otra"),
);

/**
 * Recursos propios
 * Recursos  familiares
 * Crédito ICETEX
 * Becas
 * Auxilios institucionales
 * Recursos de salario
 * Retiro de Cesantias
 * Otro ¿Indique Cual?
 * Politica de Gratuidad "Matricula Cero"
 * Descuento 10%  Certificado Electoral
 */

const LIST_FUNDING = array(
    array("value" => "", "label" => "Sin información"),
    array("value" => "1", "label" => "Recursos propios"),
    array("value" => "2", "label" => "Recursos familiares"),
    array("value" => "3", "label" => "Crédito ICETEX"),
    array("value" => "4", "label" => "Becas"),
    array("value" => "5", "label" => "Auxilios institucionales"),
    array("value" => "6", "label" => "Recursos de salario"),
    array("value" => "7", "label" => "Retiro de Cesantías"),
    array("value" => "8", "label" => "Otro"),
    array("value" => "9", "label" => 'Política de Gratuidad'),
    array("value" => '10', 'label' => 'Descuento 10% Certificado Electoral'),
);

/**
 * Ocupación actual :
 * Estudiante
 * Independiente
 * Empleado
 * Desempleado
 * En busqueda Activa de Trabajo
 * Estudia y Trabaja
 * Otro ¿Indique Cual?
 */

const LIST_CURRENT_OCCUPATIONS = array(
    array("value" => "", "label" => "Sin información"),
    array("value" => "1", "label" => "Estudiante"),
    array("value" => "2", "label" => "Independiente"),
    array("value" => "3", "label" => "Empleado/a"),
    array("value" => "4", "label" => "Desempleado/a"),
    array("value" => "5", "label" => "En búsqueda activa de trabajo"),
    array("value" => "6", "label" => "Estudia y trabaja"),
    array("value" => "7", "label" => "Ama/o de casa"),
    array("value" => "8", "label" => "Jubilado/a o pensionado/a"),
    array("value" => "99", "label" => "Otro")
);

/**
 * Tipos de trabajos
 * Formal
 * Informal
 * Otro ¿Indique Cual?
 */
const LIST_WORK_TYPES = array(
    array("value" => "", "label" => "Sin información"),
    array("value" => "1", "label" => "Trabajo formal"),
    array("value" => "2", "label" => "Trabajo informal"),
    array("value" => "3", "label" => "Freelancer / Autónomo"),
    array("value" => "4", "label" => "Temporal / Por proyecto"),
    array("value" => "5", "label" => "Trabajo voluntario"),
    array("value" => "6", "label" => "Pasantía / Práctica"),
    array("value" => "7", "label" => "Solo estudiante"),
    array("value" => "99", "label" => "Otro")
);

const LIST_JOB_POSITIONS = array(
    array("value" => "", "label" => "Sin información"),

    // Alta Dirección
    array("value" => "1", "label" => "Director General / CEO"),
    array("value" => "2", "label" => "Gerente General"),
    array("value" => "3", "label" => "Subdirector / Subgerente"),

    // Recursos Humanos
    array("value" => "4", "label" => "Gerente de Recursos Humanos"),
    array("value" => "5", "label" => "Analista de Recursos Humanos"),
    array("value" => "6", "label" => "Asistente de Recursos Humanos"),

    // Finanzas y Contabilidad
    array("value" => "7", "label" => "Director Financiero / CFO"),
    array("value" => "8", "label" => "Contador/a"),
    array("value" => "9", "label" => "Analista Financiero"),
    array("value" => "10", "label" => "Auxiliar Contable"),

    // Tecnología e Informática
    array("value" => "11", "label" => "Gerente de Tecnología / CTO"),
    array("value" => "12", "label" => "Desarrollador de Software"),
    array("value" => "13", "label" => "Administrador de Sistemas"),
    array("value" => "14", "label" => "Soporte Técnico / Mesa de ayuda"),

    // Ventas y Comercial
    array("value" => "15", "label" => "Gerente Comercial"),
    array("value" => "16", "label" => "Ejecutivo de Ventas"),
    array("value" => "17", "label" => "Representante Comercial"),
    array("value" => "18", "label" => "Vendedor/a"),

    // Marketing y Comunicación
    array("value" => "19", "label" => "Director de Marketing"),
    array("value" => "20", "label" => "Especialista en Marketing Digital"),
    array("value" => "21", "label" => "Diseñador Gráfico"),
    array("value" => "22", "label" => "Community Manager"),

    // Producción y Operaciones
    array("value" => "23", "label" => "Jefe de Producción"),
    array("value" => "24", "label" => "Operario de Producción"),
    array("value" => "25", "label" => "Supervisor de Planta"),
    array("value" => "26", "label" => "Técnico de Mantenimiento"),

    // Logística y Transporte
    array("value" => "27", "label" => "Jefe de Logística"),
    array("value" => "28", "label" => "Almacenista / Bodeguero"),
    array("value" => "29", "label" => "Conductor / Repartidor"),

    // Atención al Cliente
    array("value" => "30", "label" => "Gerente de Servicio al Cliente"),
    array("value" => "31", "label" => "Recepcionista"),
    array("value" => "32", "label" => "Agente de Atención al Cliente"),

    // Otros
    array("value" => "33", "label" => "Personal de Limpieza / Servicios generales"),

    array("value" => "34", "label" => "Multioperario / Polivalente"),
    array("value" => "35", "label" => "Trabajador de labores generales"),
    array("value" => "36", "label" => "Personal operativo / de planta"),

    array("value" => "99", "label" => "Otro")
);

/**
 * Horas semanales dedicadas al trabajo (selección única):
 * 0 horas
 * 1– 10 horas
 * 11– 20 horas
 * 21 – 30 horas
 * 31– 40 horas
 * 40 – 46 horas
 * Más de 46 horas
 */
const LIST_HOURS_WORK = array(
    array("value" => "", "label" => "Sin información"),
    array("value" => "0", "label" => "0 horas"),
    array("value" => "1", "label" => "1– 10 horas"),
    array("value" => "2", "label" => "11– 20 horas"),
    array("value" => "3", "label" => "21 – 30 horas"),
    array("value" => "4", "label" => "31– 40 horas"),
    array("value" => "5", "label" => "40 – 46 horas"),
    array("value" => "6", "label" => "Más de 46 horas"),
);

/**
 * Ingresos mensuales aproximados (selección única):
 * Sin ingresos
 * Menos de 1 SMMLV
 * 1 SMMLV
 * Entre 1 y 2 SMMLV
 * Entre 2 y 3 SMMLV
 * Más de 3 SMMLV
 */
const LIST_MONTHLY_INCOMES = array(
    array("value" => "", "label" => "Sin información"),
    array("value" => "0", "label" => "Sin ingresos"),
    array("value" => "1", "label" => "Menos de 1 SMMLV"),
    array("value" => "2", "label" => "1 SMMLV"),
    array("value" => "3", "label" => "Entre 1 y 2 SMMLV"),
    array("value" => "4", "label" => "Entre 2 y 3 SMMLV"),
    array("value" => "5", "label" => "Más de 3 SMMLV"),
);

/**
 * Sectores productivos, empleo y/o actividades Economicas
 * Actividades de  ganadería, agrícola, pesquero, minero y sector forestal.
 * Manufactura, fabricación, industria, energético,  construcción y la industria metalurgia.
 * Sector terciario o servicios: las telecomunicaciones, el transporte, la medicina, la enseñanza, el comercio, el turismo, el gobierno, el sector financiero, administrativo y el sector de salud., Ocio, las artes y la cultura
 * Otro ¿Indique Cual?
 */
const LIST_PRODUCTIVE_SECTORS = array(
    array("value" => "", "label" => "Sin información"),
    // Sector primario
    array("value" => "1", "label" => "Agricultura"),
    array("value" => "2", "label" => "Ganadería"),
    array("value" => "3", "label" => "Pesca"),
    array("value" => "4", "label" => "Minería"),
    array("value" => "5", "label" => "Silvicultura / Sector forestal"),
    // Sector secundario
    array("value" => "6", "label" => "Manufactura / Industria de transformación"),
    array("value" => "7", "label" => "Construcción"),
    array("value" => "8", "label" => "Producción de energía"),
    array("value" => "9", "label" => "Industria metalúrgica"),
    // Sector terciario (servicios)
    array("value" => "10", "label" => "Comercio"),
    array("value" => "11", "label" => "Transporte"),
    array("value" => "12", "label" => "Telecomunicaciones"),
    array("value" => "13", "label" => "Educación"),
    array("value" => "14", "label" => "Salud / Servicios médicos"),
    array("value" => "15", "label" => "Turismo"),
    array("value" => "16", "label" => "Gobierno / Administración pública"),
    array("value" => "17", "label" => "Finanzas y seguros"),
    array("value" => "18", "label" => "Servicios administrativos y de apoyo"),
    array("value" => "19", "label" => "Arte, cultura y recreación"),
    array("value" => "20", "label" => "Ocio y entretenimiento"),
    // Otro
    array("value" => "99", "label" => "Otro")
);

const LIST_FILE_TYPES = array(
    array("value" => "SIE-DT-02", "label" => "Acta de grado bachiller"),
    array("value" => "SIE-DT-19", "label" => "Acta de Homologación"),
    array("value" => "SIE-DT-03", "label" => "Diploma bachiller o certificado de noveno grado concluido"),
    array("value" => "SIE-DT-10", "label" => "Documentos de Homologación"),
    array("value" => "SIE-DT-01", "label" => "Documento de Identidad"),
    array("value" => "SIE-DT-21", "label" => "Documentos Institucionales"),
    array("value" => "SIE-DT-08", "label" => "Certificado Electoral"),
    array("value" => "SIE-DT-16", "label" => "Certificado EPS"),
    array("value" => "SIE-DT-17", "label" => "Certificado de Población Especial"),
    array("value" => "SIE-DT-04", "label" => "Certificado Prueba de SABER11"),
    array("value" => "SIE-DT-20", "label" => "Certificados RYC"),
    array("value" => "SIE-DT-06", "label" => "Certificado SISBEN"),
    array("value" => "SIE-DT-05", "label" => "Un recibo de servicios públicos (lugar residencia)"),
    array("value" => "SIE-DT-07", "label" => "Soporte de pago de inscripción"),
    array("value" => "SIE-DT-09", "label" => "Foto tipo documento fondo blanco"),
    array("value" => "SIE-DT-12", "label" => "Foto evidencia de discapacidad"),
    array("value" => "SIE-DT-13", "label" => "Foto evidencia de situación de vulnerabilidad"),
    array("value" => "SIE-DT-14", "label" => "Foto evidencia de situación de excepcionalidad"),
    array("value" => "SIE-DT-15", "label" => "Foto evidencia de vandalismo"),
    array("value" => "SIE-DT-18", "label" => "Pruebas TyT"),
    array("value" => "SIE-DT-19", "label" => "Formato de cancelación o aplazamiento"),
    //array("value" => "AVATAR", "label" => "Foto tipo perfil (Avatar)"),
    array("value" => "CP", "label" => "Comprobante de pago"),
    array("value" => "CPFC", "label" => "Comprobante de pago formación continua"),
    array("value" => "Q10RA", "label" => "Q10 - Resultados académicos técnico profesional"),
    array("value" => "Q10RB", "label" => "Q10 - Resultados académicos tecnología"),
    array("value" => "Q10RC", "label" => "Q10 - Resultados académicos profesional universitario"),
    array("value" => "Q10RD", "label" => "Q10 - Resultados académicos extensión"),
    array("value" => "Q10RE", "label" => "Q10 - Resultados académicos otros"),
    array("value" => "SIE-DT-99", "label" => "Otro (Fuera del listado)"),
);

const LIST_TYPES_OBSERVATIONS = array(
    array("value" => "", "label" => "Seleccione una opción..."),
    array("value" => "37", "label" => "Acádemica"),
    array("value" => "27", "label" => "Admisión - Psicología"),
    array("value" => "22", "label" => "Caso Revisión por Comité"),
    array("value" => "05", "label" => "Certificado 9° Aprobado pendiente"),
    array("value" => "06", "label" => "Condición Bajo rendimiento"),
    array("value" => "25", "label" => "Deserción - Factores Académicos"),
    array("value" => "26", "label" => "Deserción - Factores Familiares"),
    array("value" => "24", "label" => "Deserción - Factores Personales"),
    array("value" => "23", "label" => "Deserción - Factores Socioeconómicos"),
    array("value" => "04", "label" => "Diploma o acta de grado bachiller pendientes"),
    array("value" => "01", "label" => "Documento ICFES"),
    array("value" => "39", "label" => "Entrevista Psicología"),
    array("value" => "19", "label" => "Grado ciclo anterior pendiente"),
    array("value" => "07", "label" => "Homologación"),
    array("value" => "15", "label" => "Incapacidad Médica"),
    array("value" => "35", "label" => "Matrícula Académica"),
    array("value" => "40", "label" => "Matrícula Extensión"),
    array("value" => "34", "label" => "Matrícula Financiera"),
    array("value" => "21", "label" => "Matrícula Módulo (3) vez - Revisión caso"),
    array("value" => "20", "label" => "Matrícula Módulo (2) vez notificación académica"),
    array("value" => "36", "label" => "Material Bibliográfico en Préstamo"),
    array("value" => "03", "label" => "Módulos Pendientes"),
    array("value" => "41", "label" => "Política de gratuidad"),
    array("value" => "12", "label" => "Proceso de Grado"),
    array("value" => "08", "label" => "Revisión de caso por Bienestar"),
    array("value" => "38", "label" => "Revisión de caso por deserción"),
    array("value" => "09", "label" => "Revisión caso Coordinación programa"),
    array("value" => "18", "label" => "Saber Pro"),
    array("value" => "28", "label" => "Seguimiento Enfermería"),
    array("value" => "29", "label" => "Seguimiento Psicología"),
    array("value" => "14", "label" => "SNIES desactualizado"),
    array("value" => "10", "label" => "Solicitud Aplazamiento-Cancelación"),
    array("value" => "11", "label" => "Solicitud Cambio de programa o jornada"),
    array("value" => "13", "label" => "Suficiencia Inglés"),
    array("value" => "33", "label" => "Tamizaje - Enfermería"),
    array("value" => "31", "label" => "Tamizaje - Prueba de aptitud física"),
    array("value" => "30", "label" => "Tamizaje - Prueba de suficiencia Inglés"),
    array("value" => "32", "label" => "Tamizaje - Psicología"),
    array("value" => "16", "label" => "TyT Técnico"),
    array("value" => "17", "label" => "TyT Tecnológico"),
    array("value" => "02", "label" => "UC Pendientes"),
    array("value" => "99", "label" => "Otro"),
);


const LIST_TYPES_OBSERVATIONS_TEACHERS = array(
    array("value" => "", "label" => "Seleccione una opción..."),
    array("value" => "37", "label" => "Acádemica"),
    array("value" => "38", "label" => "Revisión de caso por deserción"),
    array("value" => "99", "label" => "Otro"),
);


const LIST_INDIGENOUS_PEOPLE = array(
    array("value" => "", "label" => "Seleccione uno..."),
    array("value" => "88", "label" => "No pertenece(No informa)"),
    array("value" => "1", "label" => "Achagua"),
    array("value" => "2", "label" => "Amorúa"),
    array("value" => "3", "label" => "Andoque o andoke"),
    array("value" => "4", "label" => "Arhuaco (ijka)"),
    array("value" => "5", "label" => "Awa (cuaiker)"),
    array("value" => "6", "label" => "Barea"),
    array("value" => "7", "label" => "Barí (motilón)"),
    array("value" => "8", "label" => "Betoye"),
    array("value" => "9", "label" => "Bara"),
    array("value" => "10", "label" => "Cañamomo"),
    array("value" => "11", "label" => "Carapana"),
    array("value" => "12", "label" => "Carijona o karijona"),
    array("value" => "13", "label" => "Chimila (ette e´neka)"),
    array("value" => "14", "label" => "Chiricoa"),
    array("value" => "15", "label" => "Cocama"),
    array("value" => "16", "label" => "Coconuco"),
    array("value" => "17", "label" => "Coyaima-Natagaima"),
    array("value" => "18", "label" => "Pijaos"),
    array("value" => "19", "label" => "Cubeo o kubeo"),
    array("value" => "20", "label" => "Cuiba o kuiba"),
    array("value" => "21", "label" => "Curripaco o kurripaco"),
    array("value" => "22", "label" => "Desano"),
    array("value" => "23", "label" => "Dujos"),
    array("value" => "24", "label" => "Embera catio o katío"),
    array("value" => "25", "label" => "Embera chami"),
    array("value" => "26", "label" => "Eperara siapidara"),
    array("value" => "27", "label" => "Guambiano"),
    array("value" => "28", "label" => "Guanaca"),
    array("value" => "29", "label" => "Guane"),
    array("value" => "30", "label" => "Guyabero"),
    array("value" => "31", "label" => "Hitnú"),
    array("value" => "32", "label" => "Hupdu"),
    array("value" => "33", "label" => "Inga"),
    array("value" => "34", "label" => "Juhup"),
    array("value" => "35", "label" => "Kamsa o kamëntsá"),
    array("value" => "36", "label" => "Kankuamo"),
    array("value" => "37", "label" => "Kakua"),
    array("value" => "38", "label" => "Kogui"),
    array("value" => "39", "label" => "Koreguaje o coreguaje"),
    array("value" => "40", "label" => "Letuama"),
    array("value" => "41", "label" => "Macaguaje o makaguaje"),
    array("value" => "42", "label" => "Nukak (makú)"),
    array("value" => "43", "label" => "Macuna o makuna (sara)"),
    array("value" => "44", "label" => "Masiguare"),
    array("value" => "45", "label" => "Matapí"),
    array("value" => "46", "label" => "Miraña"),
    array("value" => "47", "label" => "Mokaná"),
    array("value" => "48", "label" => "Muinane"),
    array("value" => "49", "label" => "Muisca"),
    array("value" => "50", "label" => "Nonuya"),
    array("value" => "51", "label" => "Ocaina"),
    array("value" => "52", "label" => "Nasa (paéz)"),
    array("value" => "53", "label" => "Pastos"),
    array("value" => "54", "label" => "Piapoco (dzase)"),
    array("value" => "55", "label" => "Piaroa"),
    array("value" => "56", "label" => "Piratapuyo"),
    array("value" => "57", "label" => "Pisamira"),
    array("value" => "58", "label" => "Puinave"),
    array("value" => "59", "label" => "Sánha"),
    array("value" => "60", "label" => "Sikuani"),
    array("value" => "61", "label" => "Siona"),
    array("value" => "62", "label" => "Siriano"),
    array("value" => "63", "label" => "Siripu o tsiripu (mariposo)"),
    array("value" => "64", "label" => "Taiwano (tajuano)"),
    array("value" => "65", "label" => "Tanimuka"),
    array("value" => "66", "label" => "Tariano"),
    array("value" => "67", "label" => "Tatuyo"),
    array("value" => "68", "label" => "Tikuna"),
    array("value" => "69", "label" => "Tororó"),
    array("value" => "70", "label" => "Tucano (desea) o tukano"),
    array("value" => "71", "label" => "Tule (kuna)"),
    array("value" => "72", "label" => "Tuyuka (dojkapuara)"),
    array("value" => "73", "label" => "U´wa(tunebo)"),
    array("value" => "74", "label" => "Wanano"),
    array("value" => "75", "label" => "Wayuu"),
    array("value" => "76", "label" => "Witoto - huitoto"),
    array("value" => "77", "label" => "Wiwa (arzario)"),
    array("value" => "78", "label" => "Waunan (wuanana)"),
    array("value" => "79", "label" => "Yagua"),
    array("value" => "80", "label" => "Yanacona"),
    array("value" => "81", "label" => "Yauna"),
    array("value" => "82", "label" => "Yukuna"),
    array("value" => "83", "label" => "Yuko (yukpa)"),
    array("value" => "84", "label" => "Yurí (carabayo)"),
    array("value" => "85", "label" => "Yuruti"),
    array("value" => "86", "label" => "Zenú / senú"),
    array("value" => "87", "label" => "Quillacingas"),
    array("value" => "89", "label" => "Otro"),
);


const LIST_YN = array(
    array("value" => "Y", "label" => "Si"),
    array("value" => "N", "label" => "No"),
);

const LIST_NY = array(
    array("value" => "N", "label" => "No"),
    array("value" => "Y", "label" => "Si"),
);


const LIST_TYPES_OF_DISABILITIES = array(
    array("value" => "", "label" => "No aplica..."),
    array("value" => "01", "label" => "Discapacidad Sensorial - Sordera Profunda"),
    array("value" => "02", "label" => "Discapacidad Sensorial - Hipoacusia"),
    array("value" => "03", "label" => "Discapacidad Sensorial - Ceguera"),
    array("value" => "04", "label" => "Discapacidad Sensorial - Baja Visión"),
    array("value" => "05", "label" => "Discapacidad Sensorial - Sordoceguera"),
    array("value" => "06", "label" => "Discapacidad Intelectual"),
    array("value" => "07", "label" => "Discapacidad Psicosocial"),
    array("value" => "08", "label" => "Discapacidad Múltiple"),
    array("value" => "09", "label" => "Discapacidad Fisica o motora"),
    array("value" => "10", "label" => "Discapacidad Sistémica (válido hasta el 2019)"),
);

const LIST_BLACK_COMMUNITY = array(
    array("value" => "", "label" => "No aplica..."),
    array("value" => "1", "label" => "Afrocolombianos"),
    array("value" => "2", "label" => "Raizales"),
    array("value" => "3", "label" => "Palenqueros"),
    array("value" => "4", "label" => "Otras comunidades negras"),
);

const LIST_OF_EXCEPTIONAL_CAPABILITIES = array(
    array("value" => "", "label" => "No aplica..."),
    array("value" => "1", "label" => "Talento excepcional general"),
    array("value" => "2", "label" => "Talento excepcional específico"),
);

const LIST_PERIODS = array(
    array("value" => "", "label" => "Seleccione un periodo..."),
    array("value" => "2026A", "label" => "2026A (Abiertas)"),
    array("value" => "2025B", "label" => "2025B"),
    array("value" => "2025A", "label" => "2025A"),
    array("value" => "2024B", "label" => "2024B"),
    array("value" => "2024A", "label" => "2024A"),
    array("value" => "2023B", "label" => "2023B"),
    array("value" => "2023A", "label" => "2023A"),
    array("value" => "2022B", "label" => "2022B"),
    array("value" => "2022A", "label" => "2022A"),
    array("value" => "2021B", "label" => "2021B"),
    array("value" => "2021A", "label" => "2021A"),
    array("value" => "2020B", "label" => "2020B"),
    array("value" => "2020A", "label" => "2020A"),
    array("value" => "2019B", "label" => "2019B"),
    array("value" => "2019A", "label" => "2019A"),
    array("value" => "2018B", "label" => "2018B"),
    array("value" => "2018A", "label" => "2018A"),
    array("value" => "2017A", "label" => "2017B"),
    array("value" => "2017A", "label" => "2017A"),
    array("value" => "2016B", "label" => "2016B"),
    array("value" => "2016A", "label" => "2016A"),
    array("value" => "2015B", "label" => "2015B"),
    array("value" => "2015A", "label" => "2015A"),
    array("value" => "2014B", "label" => "2014B"),
    array("value" => "2014A", "label" => "2014A"),
);


const LIST_ENRROLMENTS_STATUS = array(
    array("value" => "ACTIVE", "label" => "Activo"),
    array("value" => "DISABLED", "label" => "Inactivo"),
    array("value" => "GRADUATES", "label" => "Egresados"),
    array("value" => "GRADUATE", "label" => "Graduado"),
);

const LIST_PERIODS_PREREGISTRATIONS = array(
    array("value" => "2026A", "label" => "2026A (Abiertas)"),
    //array("value" => "2025B", "label" => "2025B (Abiertas)"),
    //array("value" => "2025B", "label" => "2025B"),
);

const LIST_JOURNEYS = array(
    array("value" => "", "label" => "Seleccione una jornada..."),
    //array("value" => "JM", "label" => "Mañana"),
    array("value" => "DS", "label" => "Diurna"),
    array("value" => "JN", "label" => "Noche"),
    //array("value" => "JT", "label" => "Tarde"),
    array("value" => "JS", "label" => "Sábado"),
    array("value" => "PA", "label" => "Presencialidad Asistida"),
);

const LIST_IDENTIFICATION_TYPES = array(
    array("value" => "", "label" => "Seleccione un tipo"),
    array("value" => "CC", "label" => "Cédula de Ciudadanía"),
    array("value" => "DE", "label" => "Documento de Identidad de Extranjería"),
    array("value" => "CE", "label" => "Cédula de Extranjería"),
    array("value" => "TI", "label" => "Tarjeta de Identidad"),
    array("value" => "PAS", "label" => "Pasaporte"),
    array("value" => "CA", "label" => "Certificado Cabildo"),
    array("value" => "CD", "label" => "Carné Diplomático"),
    array("value" => "PPT", "label" => "Permiso por Protección Temporal"),
    array("value" => "ETC", "label" => "Otro"),
);

const LIST_APPLICATION_TYPES = array(
    array("value" => "", "label" => "Seleccione un tipo"),
    array("value" => "CEREMONY", "label" => "Ceremonia solemne"),
    array("value" => "ACT", "label" => "Grado acto administrativo"),
);

const LIST_DEGREES_TYPES = array(
    array("value" => "", "label" => "Seleccione un tipo"),
    array("value" => "107953", "label" => "Técnico Profesional en Producción Agrícola Sostenible - 107953"),
    array("value" => "107952", "label" => "Tecnología en Gestión Agroindustrial - 107952"),
    array("value" => "107951", "label" => "Profesional en Agronegocios - 107951"),
    array("value" => "105900", "label" => "Técnico Profesional en Procesos Administrativos - 105900"),
    array("value" => "105899", "label" => "Tecnología en Gestión Empresarial - 105899"),
    array("value" => "105897", "label" => "Técnico Profesional en Operaciones de Importación y Exportación - 105897"),
    array("value" => "104954", "label" => "Tecnología en Gestión Internacional del Comercio - 104954"),
    array("value" => "105725", "label" => "Técnico Profesional en Operación de Cocina y Restauración - 105725"),
    array("value" => "105726", "label" => "Tecnología en Gastronomía - 105726"),
    array("value" => "105603", "label" => "Técnico Profesional en Operación de Equipos Auscultación Minero Energético - 105603"),
    array("value" => "105602", "label" => "Tecnología en Planeación Minero Energético - 105602"),
    array("value" => "105601", "label" => "Técnico Profesional en Operación de Equipos de Muestreo Minero Energético - 105601"),
    array("value" => "104355", "label" => "Tecnología en Suministro de Bienes y Servicios Minero-Energéticos - 104355"),
    array("value" => "104335", "label" => "Tecnología en Gestión de la Recreación y el Deporte - 104335")
);

const LIST_LEVELS = array(
    array("value" => "", "label" => "Seleccione uno..."),
    array("value" => "TP", "label" => "TP - Técnico Profesional"),
    array("value" => "TG", "label" => "TG - Tecnólogo"),
    array("value" => "UN", "label" => "UN - Universitario"),
    array("value" => "EX", "label" => "EX - Extensión"),
);

const LIST_MOMENTS = array(
    //array("value" => "99", "label" => "Antiguo"),
    array("value" => "1", "label" => "I"),
    array("value" => "2", "label" => "II"),
    array("value" => "3", "label" => "III"),
    array("value" => "4", "label" => "IV"),
    array("value" => "5", "label" => "V"),
);
const LIST_CYCLES = array(
    //array("value" => "99", "label" => "Antiguo"),
    array("value" => "1", "label" => "Ciclo I"),
    array("value" => "2", "label" => "Ciclo II"),
    array("value" => "3", "label" => "Ciclo III"),
    array("value" => "4", "label" => "Ciclo IV"),
    array("value" => "5", "label" => "Ciclo V"),
    array("value" => "6", "label" => "Ciclo VI"),
    array("value" => "7", "label" => "Ciclo VII"),
    array("value" => "8", "label" => "Ciclo VIII"),
    array("value" => "9", "label" => "Ciclo IX"),
    array("value" => "10", "label" => "Ciclo X"),
    array("value" => "11", "label" => "Ciclo XI"),
    array("value" => "12", "label" => "Ciclo XII"),
);

const LIST_SEX = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "M", "label" => "Masculino"),
    array("value" => "F", "label" => "Femenino"),
);

const LIST_AREAS = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "RURAL", "label" => "Rural"),
    array("value" => "URBAN", "label" => "Urbana"),
);


const LIST_STRATUMS = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "0", "label" => "0 - No informa"),
    array("value" => "1", "label" => "1 - Bajo-bajo"),
    array("value" => "2", "label" => "2 - Bajo"),
    array("value" => "3", "label" => "3 - Medio-bajo"),
    array("value" => "4", "label" => "4 - Medio"),
    array("value" => "5", "label" => "5 - Medio-alto"),
    array("value" => "6", "label" => "6 - Alto"),
    array("value" => "7", "label" => "7 - Sin estrato"),
);

const LIST_TRANSPORTS = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "PUB", "label" => "Público Bus o Buseta"),
    array("value" => "PUT", "label" => "Público Taxi"),
    array("value" => "PUM", "label" => "Público Metro"),
    array("value" => "PUO", "label" => "Público Otro"),
    array("value" => "PAU", "label" => "Particular Automóvil"),
    array("value" => "PAM", "label" => "Particular Motocicleta"),
    array("value" => "PAB", "label" => "Particular Bicicleta"),
    array("value" => "PAO", "label" => "Particular Otro"),
    array("value" => "SIT", "label" => "SITP o Bus"),
    array("value" => "TRA", "label" => "Transmilenio"),
    array("value" => "TAX", "label" => "Taxi"),
    array("value" => "CAR", "label" => "Carro Particular"),
    array("value" => "PEA", "label" => "Peatón"),
    array("value" => "BIC", "label" => "Bicicleta"),
    array("value" => "MOT", "label" => "Moto"),
    array("value" => "MIO", "label" => "Masivo Integrado de Occidente"),
    array("value" => "API", "label" => "A Pie"),
    array("value" => "OTR", "label" => "Otro"),
    array("value" => "RUT", "label" => "Ruta Escolar"),
    array("value" => "FLU", "label" => "Fluvial")
);

const LIST_SISBEN_GROUPS = array(
    array("value" => "0", "label" => "No aplica"),
    array("value" => "A", "label" => "Grupo A: Población en pobreza extrema, desde A1 hasta A5."),
    array("value" => "B", "label" => "Grupo B: Población en pobreza moderada, desde B1 hasta B7."),
    array("value" => "C", "label" => "Grupo C: Población vulnerable, desde C1 hasta C18."),
    array("value" => "D", "label" => "Grupo D: Población no pobre, no vulnerable, desde D1 hasta D21."),
);

const LIST_EPS = array(
    ['value' => 'No Aplica', 'label' => 'No Aplica'],
    ['value' => '1', 'label' => 'COOSALUD EPS-S ESS024 - EPS042 ESSC24 - EPSS42 900226715 AMBOS REGÍMENES'],
    ['value' => '2', 'label' => 'NUEVA EPS EPS037 - EPSS41 EPSS37 - EPS041 900156264 AMBOS REGÍMENES'],
    ['value' => '3', 'label' => 'MUTUAL SER ESS207 - EPS048 ESSC07 - EPSS48 806008394 AMBOS REGÍMENES'],
    ['value' => '4', 'label' => 'ALIANSALUD EPS EPS001 EPSS01 830113831 CONTRIBUTIVO'],
    ['value' => '5', 'label' => 'SALUD TOTAL EPS S.A. EPS002 EPSS02 800130907 CONTRIBUTIVO'],
    ['value' => '6', 'label' => 'EPS SANITAS EPS005 EPSS05 800251440 CONTRIBUTIVO'],
    ['value' => '7', 'label' => 'EPS SURA EPS010 EPSS10 800088702 AMBOS REGÍMENES'],
    ['value' => '8', 'label' => 'FAMISANAR EPS017 EPSS17 830003564 CONTRIBUTIVO'],
    ['value' => '9', 'label' => 'SERVICIO OCCIDENTAL DE SALUD EPS SOS EPS018 EPSS18 805001157 CONTRIBUTIVO'],
    ['value' => '10', 'label' => 'SALUD MIA EPS046 EPSS46 900914254 CONTRIBUTIVO'],
    ['value' => '11', 'label' => 'COMFENALCO VALLE EPS012 EPSS12 890303093 CONTRIBUTIVO'],
    ['value' => '12', 'label' => 'COMPENSAR EPS EPS008 EPSS08 860066942 CONTRIBUTIVO'],
    ['value' => '13', 'label' => 'EPM - EMPRESAS PUBLICAS DE MEDELLIN EAS016 N/A 890904996 CONTRIBUTIVO'],
    ['value' => '14', 'label' => 'FONDO DE PASIVO SOCIAL DE FERROCARRILES NACIONALES DE COLOMBIA EAS027 N/A 800112806 CONTRIBUTIVO'],
    ['value' => '15', 'label' => 'CAJACOPI ATLANTICO CCF055 CCFC55 890102044 SUBSIDIADO'],
    ['value' => '16', 'label' => 'CAPRESOCA EPS025 EPSC25 891856000 SUBSIDIADO'],
    ['value' => '17', 'label' => 'COMFACHOCO CCF102 CCFC20 891600091 SUBSIDIADO'],
    ['value' => '18', 'label' => 'COMFAORIENTE CCF050 CCFC50 890500675 SUBSIDIADO'],
    ['value' => '19', 'label' => 'EPS FAMILIAR DE COLOMBIA CCF033 CCFC33 901543761 SUBSIDIADO'],
    ['value' => '20', 'label' => 'ASMET SALUD ESS062 ESSC62 900935126 SUBSIDIADO'],
    ['value' => '21', 'label' => 'EMSSANAR E.S.S. ESS118 ESSC18 901021565 SUBSIDIADO'],
    ['value' => '22', 'label' => 'CAPITAL SALUD EPS-S EPSS34 EPSC34 900298372 SUBSIDIADO'],
    ['value' => '23', 'label' => 'SAVIA SALUD EPS EPSS40 EPS040 900604350 SUBSIDIADO'],
    ['value' => '24', 'label' => 'DUSAKAWI EPSI EPSI01 EPSIC1 824001398 SUBSIDIADO'],
    ['value' => '25', 'label' => 'ASOCIACION INDIGENA DEL CAUCA EPSI EPSI03 EPSIC3 817001773 SUBSIDIADO'],
    ['value' => '26', 'label' => 'ANAS WAYUU EPSI EPSI04 EPSIC4 839000495 SUBSIDIADO'],
    ['value' => '27', 'label' => 'MALLAMAS EPSI EPSI05 EPSIC5 837000084 SUBSIDIADO'],
    ['value' => '28', 'label' => 'PIJAOS SALUD EPSI EPSI06 EPSIC6 809008362 SUBSIDIADO'],
    ['value' => '29', 'label' => 'SALUD BÓLIVAR EPS SAS EPS047 EPSS47 901438242 CONTRIBUTIVO'],
    ['value' => '30', 'label' => 'COMPARTA EPS-S - COOPERATIVA DE SALUD COMUNITARIA EMPRESA PROMOTORA SUBSIDIADA '],
    ['value' => '31', 'label' => 'SANIDAD MILITAR & POLICIAL SSMP'],
);

const LIST_HEALTH_INSURANCES = array(
    array("value" => "1", "label" => "SISBEN"),
    array("value" => "2", "label" => "EPS"),
    array("value" => "3", "label" => "IPS"),
    array("value" => "4", "label" => "OTRO"),
);


const LIST_BLOOD = array(
    array("value" => "", "label" => "Seleccione una opción..."),
    array("value" => "O-", "label" => "O-"),
    array("value" => "O+", "label" => "O&plus;"),
    array("value" => "A-", "label" => "A-"),
    array("value" => "A+", "label" => "A&plus;"),
    array("value" => "B-", "label" => "B-"),
    array("value" => "B+", "label" => "B&plus;"),
    array("value" => "AB-", "label" => "AB-"),
    array("value" => "AB+", "label" => "AB&plus;"),
);


const LIST_MARITALS = array(
    array("value" => "", "label" => "Seleccione una opción..."),
    array("value" => "SOL", "label" => "Soltero"),
    array("value" => "CAS", "label" => "Casado"),
    array("value" => "DIV", "label" => "Divorciado"),
    array("value" => "VIU", "label" => "Viudo"),
    array("value" => "UNI", "label" => "Unión libre"),
    array("value" => "SEP", "label" => "Separado"),
    array("value" => "REL", "label" => "Religioso"),
);

const LIST_COURSES_STATUSES = array(
    array("value" => "", "label" => "Seleccione una opción..."),
    array("value" => "ACTIVE", "label" => "Activo"),
    array("value" => "CLOSED", "label" => "Cerrado"),
    array("value" => "CANCELED", "label" => "Cancelado"),
);


const LIST_ARS = array(
    array("value" => "", "label" => "Ninguna..."),
    array("value" => "AXA", "label" => "Axa Colpatria Seguros S.A."),
    array("value" => "COLMENA", "label" => "Colmena Seguros S.A."),
    array("value" => "AURORA", "label" => "Compañía de Seguros de Vida Aurora S.A."),
    array("value" => "COLSANITA", "label" => "Colsanitas Seguros"),
    array("value" => "BOLIVAR", "label" => "Seguros Bolívar S.A."),
    array("value" => "EQUIDAD", "label" => "La Equidad Seguros Generales Organismo Cooperativo"),
    array("value" => "POSITIVA", "label" => "Positiva Compañía de Seguros S.A."),
    array("value" => "MAPFRE", "label" => "Mapfre Seguros Generales de Colombia S.A."),
    array("value" => "ALFA", "label" => "Seguros Alfa"),
    array("value" => "SURAMERICANA", "label" => "Seguros Generales Suramericana S.A"),
);


const LIST_INSURANCES = [
    array("value" => "", "label" => "Seleccione..."),
    array("value" => "855456566658", "label" => "Aseguradora Sura(EPS)"),
    ["value" => "51000", "label" => "Aseguradora de Vida COLSEGUROS"],
    ["value" => "500012", "label" => "Aseguradora Solidaria"],
    ["value" => "51006", "label" => "BBVA Seguros de Vida Colombia S.A."],
    ["value" => "51001", "label" => "Compañía Agricola de Seguros de Vida S.A."],
    ["value" => "51003", "label" => "Compañía de Seguros de Vida Aurora"],
    ["value" => "51007", "label" => "Compañía Suramericana Administradora de Riesgos Profesionales y Seguros de Vida"],
    ["value" => "85545656", "label" => "Generali"],
    ["value" => "52005", "label" => "Humana Vivir S.A."],
    ["value" => "51013", "label" => "Instituto de Seguros Sociales ISS Riesgos Profesionales"],
    ["value" => "51012", "label" => "La Equidad Seguros de Vida"],
    ["value" => "51008", "label" => "La Previsora Vida S.A."],
    ["value" => "51011", "label" => "Liberty Seguros de Vida"],
    ["value" => "2097473", "label" => "Positiva"],
    ["value" => "51004", "label" => "Riesgos Profesionales Colmena S.A."],
    ["value" => "51002", "label" => "Seguros Bolivar S.A."],
    ["value" => "51009", "label" => "Seguros de Vida Alfa S.A."],
    ["value" => "51005", "label" => "Seguros de Vida Colpatria S.A."],
    ["value" => "51010", "label" => "Seguros de Vida del Estado S.A."],
];


const LIST_EDUCATION_LEVELS = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "1", "label" => "Básica secundaria"),
    array("value" => "2", "label" => "Media (Grado 9 Finalizado)"),
    array("value" => "3", "label" => "Pregrado"),
    array("value" => "4", "label" => "Técnico"),
    array("value" => "5", "label" => "Tecnólogo"),
    array("value" => "6", "label" => "Postgrado"),
    array("value" => "7", "label" => "Sin estudios"),
    array("value" => "8", "label" => "Sin formación"),
);


const LIST_OCCUPATIONS = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "1", "label" => "Empleado"),
    array("value" => "2", "label" => "Estudiante básica"),
    array("value" => "3", "label" => "Estudiante superior"),
    array("value" => "4", "label" => "Desempleado"),
    array("value" => "5", "label" => "Independiente"),
    array("value" => "6", "label" => "Pensionado")
);

const LIST_STATUSES = array(

    array("label" => "Admitido", "value" => "ADMITTED"),
    array("label" => "Admitido por reingreso", "value" => "RE-ENTRY"),
    array("label" => "Admitido proceso homologación", "value" => "HOMOLOGATION"),
    array("label" => "Aplazado", "value" => "POSTPONED"),
    array("label" => "Cancelado", "value" => "CANCELED"),
    array("label" => "Desiste del proceso", "value" => "DESISTEMENT"),
    array("label" => "En proceso", "value" => "PROCESS"),
    array("label" => "Registrado/Preinscrito", "value" => "REGISTERED"),
    array("label" => "Renovación", "value" => "RENEWAL"),
    array("label" => "Renovación - Extensión", "value" => "RENEWAL-EXT"),
    array("label" => "Inactivo", "value" => "INACTIVE"),
    array("label" => "Matriculado", "value" => "ENROLLED"),
    array("label" => "Matriculado - Antiguo", "value" => "ENROLLED-OLD"),
    array("label" => "Matriculado - Extensión", "value" => "ENROLLED-EXT"),
    array("label" => "No admitido", "value" => "UNADMITTED"),
    array("label" => "Aprobado por psicología", "value" => "ABP"),// ABP APRROVED BY PSYCHOLOGY
    array("label" => "Aprobado por psicología - Renovación", "value" => "ABP-RENEWAL"),
    array("label" => "Aprobado por psicología - Reingreso", "value" => "ABP-REENTRY"),
    array("label" => "Aprobado por psicología - Homologación", "value" => "ABP-HOMOLOG"),
    array("label" => "Graduado", "value" => "GRADUATED"),
);


const LIST_STATUSES_ENROLLEDS = array(

    array("label" => "Matriculado", "value" => "ENROLLED"),
    array("label" => "Matriculado - Antiguo", "value" => "ENROLLED-OLD"),
    array("label" => "Matriculado - Extensión", "value" => "ENROLLED-EXT"),
);


const LIST_STATUSES_PROGRESS = array(
    array("value" => "INPROGRESS", "label" => "En curso"),
    array("value" => "PENDING", "label" => "Pendiente"),
    array("value" => "APPROVED", "label" => "Aprobado"),
    array("value" => "HOMOLOGATION", "label" => "Aprobado por homologación"),
    //array("value" => "NOTAPPROVED", "label" => "No aprobado"),
    //array("value" => "REJECTED", "label" => "Rechazado"),
    array("value" => "CANCELED", "label" => "Cancelado"),
    array("value" => "POSTPONED", "label" => "Aplazado"),
    array("value" => "IMPROVEMENT", "label" => "Plan de mejora"),
    array("value" => "AGREEMENT", "label" => "Homologación por convenio"),
);

const LIST_RESPONSIBLE_RELATIONSHIP = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "99", "label" => "Responsable legal"),
    array("value" => "1", "label" => "Padre"),
    array("value" => "2", "label" => "Madre"),
    array("value" => "3", "label" => "Hermano(a)"),
    array("value" => "4", "label" => "Abuelo(a)"),
    array("value" => "5", "label" => "Tío(a)"),
    array("value" => "6", "label" => "Otro"),
);

const LIST_0_10 = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "0", "label" => "0"),
    array("value" => "1", "label" => "1"),
    array("value" => "2", "label" => "2"),
    array("value" => "3", "label" => "3"),
    array("value" => "4", "label" => "4"),
    array("value" => "5", "label" => "5"),
    array("value" => "6", "label" => "6"),
    array("value" => "7", "label" => "7"),
    array("value" => "8", "label" => "8"),
    array("value" => "9", "label" => "9"),
    array("value" => "10", "label" => "10"),
);

const LIST_IDENTIFIED_POPULATION_GROUP = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "1", "label" => "Victima del conflicto armado"),
    array("value" => "2", "label" => "Negro/a, mulato/a, Afrodescendiente, afrocolombiano(a)"),
    array("value" => "3", "label" => "Desplazado"),
    array("value" => "4", "label" => "Población Indígena"),
    array("value" => "5", "label" => "Gitano /Room"),
    array("value" => "6", "label" => "Raizal"),
    array("value" => "7", "label" => "Palenquero"),
    array("value" => "8", "label" => "LGTBIQ+"),
    array("value" => "9", "label" => "Ninguna de las anteriores"),
);

const LIST_HIGHLIGHTED_POPULATION = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("value" => "1", "label" => "Deportistas"),
    array("value" => "2", "label" => "Artistas"),
    array("value" => "3", "label" => "Mejores Pruebas saber 11"),
    array("value" => "4", "label" => "Ninguna de las anteriores"),
);


const LIST_GRADUATION_STATUS = array(
    array("value" => "", "label" => "Seleccione un estado"),
    array("value" => "PROCESS", "label" => "En proceso"),
    array("value" => "APROVED", "label" => "Aprobado"),
    array("value" => "PENDING", "label" => "Pendiente"),
    array("value" => "NOTAPROVED", "label" => "No aprobado"),
    array("value" => "REJECTED", "label" => "Rechazado"),
    array("value" => "CANCELED", "label" => "Cancelado"),
);

/**
 * PI  Población indigena: certificado Min interior
 * PR  Pueblo Rrom: certificado Min interior
 * CN  Comunidades negras afrocolombianas, raizales y palenqueras: certificado Min Interior
 * CC  Comunidad campesina: diploma colegio rural
 * PL  Privado libertad: certificado INPEC
 * DI  Discapacitado: certificado Minsalud
 */
const LIST_SNIES_ID_VALIDATION_REQUISITE = array(
    array("value" => "", "label" => "Seleccione un tipo"),
    array("value" => "PI", "label" => "Población indigena: certificado Min interior"),
    array("value" => "PR", "label" => "Pueblo Rrom: certificado Min interior"),
    array("value" => "CN", "label" => "Comunidades negras afrocolombianas, raizales y palenqueras: certificado Min Interior"),
    array("value" => "CC", "label" => "Comunidad campesina: diploma colegio rural"),
    array("value" => "PL", "label" => "Privado libertad: certificado INPEC"),
    array("value" => "DI", "label" => "Discapacitado: certificado Minsalud"),
    array("value" => "NA", "label" => "Ninguna de las anteriores"),
);

const FINANCIAL_ENTITIES = array(
    array("value" => "", "label" => "Seleccione un tipo"),
    array("value" => "026", "label" => "Bancolombia"),
);

const PERIODS = array(
    '2026A', '2025B', '2025A', '2024B', '2024A'
);


const LIST_DISCOUNT_TYPES = array(
    array("value" => "ENROLLMENT", "label" => "Beca para matricula"),
    array("value" => "REGISTRATION", "label" => "Descuento para registro"),
    array("value" => "INSURANCE", "label" => "Descuento para seguros"),
    array("value" => "CARD", "label" => "Descuento para carnet estudiantil"),
    array("value" => "FIXED", "label" => "Otros descuentos"),
    array("value" => "CONTRIBUTION", "label" => "Descuento sobre aportes económicos"),
    array("value" => "FEES", "label" => "Descuento por derechos de registro y control"),
);

const LIST_PRODUCTS_TYPES = array(
    array("value" => "", "label" => "Seleccione un tipo"),
    array("value" => "GENERAL", "label" => "General (No se aplican descuentos)"),
    //array("value" => "01", "label" => "Inscripción de Estudiantes"),
    //array("value" => "02", "label" => "Matricula Estudiantes"),
    //array("value" => "03", "label" => "Matricula INTEP"),
    //array("value" => "04", "label" => "Matricula Estudiantes Alcaldia"),
    //array("value" => "05", "label" => "Matricula Estudiantes Bienestar"),
    array("value" => "06", "label" => "Escuela de idiomas"),
    array("value" => "07", "label" => "Diplomado"),
    array("value" => "08", "label" => "Derechos de Grado"),
    array("value" => "09", "label" => "Constancias"),
    array("value" => "10", "label" => "Certificados"),
    array("value" => "11", "label" => "Constancias y certificados"),
    array("value" => "12", "label" => "Duplicado de Diploma"),
    array("value" => "13", "label" => "Estampilla Procultura Diplomas"),
    array("value" => "14", "label" => "Estampilla Certificados y constancias de estudio"),
    array("value" => "15", "label" => "Cobro extemporaneo"),
    array("value" => "REGISTRATION", "label" => "Incripción de Estudiantes"),
    array("value" => "ENROLLMENT", "label" => "Matricula"),
    array("value" => "INSURANCE", "label" => "Seguro de estudiantil"),
    array("value" => "CARD", "label" => "Carnet estudiantil"),
    array("value" => "CONTRIBUTION", "label" => "Aporte económico tipificado"),
    array("value" => "FEES", "label" => "Derechos cobrables de registro y control"),
);


const LIST_CURRENCIES = array(
    array("value" => "COP", "label" => "Peso Colombiano"),
    array("value" => "USD", "label" => "Dolar Estadounidense"),
    array("value" => "EUR", "label" => "Euro"),
    array("value" => "GBP", "label" => "Libra Esterlina"),
    array("value" => "BRL", "label" => "Real Brasilenho"),
    array("value" => "ARS", "label" => "Peso Argentino"),
    array("value" => "CLP", "label" => "Peso Chileno"),
    array("value" => "MXN", "label" => "Peso Mexicano"),
    array("value" => "CNY", "label" => "Yuan Chino"),
    array("value" => "INR", "label" => "Rupia India"),
    array("value" => "IDR", "label" => "Rupia Indonesia"),
    array("value" => "KRW", "label" => "Won Surio"),
    array("value" => "MYR", "label" => "Ringgit Malayo"),
    array("value" => "VND", "label" => "Dong Vietnamita"),
);


const LIST_AWARDED_TITLES = array(
    array("value" => "TÉCNICO PROFESIONAL EN OPERACIÓN DE EQUIPOS DE AUSCULTACIÓN MINERO ENERGÉTICO", "label" => "Técnico Profesional en Operación de Equipos de Auscultación Minero Energético"),
    array("value" => "TECNOLOGO EN PLANEACIÓN MINERO ENERGÉTICA", "label" => "Tecnólogo en Planeación Minero Energética"),
    array("value" => "TECNICO PROFESIONAL EN OPERACIÓN DE COCINA Y RESTAURACION", "label" => "Técnico Profesional en Operación de Cocina y Restauración"),
    array("value" => "TECNOLOGO EN GASTRONOMIA", "label" => "Tecnólogo en Gastronomía"),
    array("value" => "TECNOLOGO EN GESTION EMPRESARIAL", "label" => "Tecnólogo en Gestión Empresarial"),
    array("value" => "TECNICO PROFESIONAL EN PROCESOS", "label" => "Técnico Profesional en Procesos"),
    array("value" => "PROFESIONAL EN AGRONEGOCIOS", "label" => "Profesional en Agronegocios"),
    array("value" => "TECNOLOGO EN GESTIÓN AGROINDUSTRIAL", "label" => "Tecnólogo en Gestión Agroindustrial"),
    array("value" => "TÉCNICO PROFESIONAL EN PRODUCCIÓN", "label" => "Técnico Profesional en Producción"),
    array("value" => "NINGUNO", "label" => "No otorga titulo (Extensión)"),
);

const LIST_EDUCATION_LEVEL = array(
    array("value" => "COURSE", "label" => "Curso"),
    array("value" => "DIPLOMA", "label" => "Diplomado"),
    //array("value" => "EXTENSION", "label" => "Extensión"),
    array("value" => "TECHNICAL", "label" => "Técnico profesional"),
    array("value" => "TECHNOLOGICAL", "label" => "Tecnológico"),
    array("value" => "UNIVERSITY", "label" => "Universitario"),
    array("value" => "POSTGRADUATE", "label" => "Posgrado"),
);


const LIST_MODALITIES = array(
    array("value" => "DISTANCE", "label" => "Distancia"),
    array("value" => "FACE-TO-FACE", "label" => "Presencial"),
    array("value" => "VIRTUAL", "label" => "Virtual"),
);

const LIST_ACADEMIC_LEVELS = array(
    array("value" => "PRIMARY_EDUCATION", "label" => "Educación Primaria"),
    array("value" => "SECONDARY_EDUCATION", "label" => "Educación Secundaria"),
    array("value" => "HIGH_SCHOOL", "label" => "Bachillerato"),
    array("value" => "VOCATIONAL_TRAINING", "label" => "Formación Profesional"),
    array("value" => "UNDERGRADUATE_DEGREE", "label" => "Grado Universitario (Pregrado)"),
    array("value" => "GRADUATE_DEGREE", "label" => "Licenciatura"),
    array("value" => "DIPLOMA", "label" => "Diplomatura"),
    array("value" => "MASTER_DEGREE", "label" => "Maestría"),
    array("value" => "DOCTORATE_DEGREE", "label" => "Doctorado"),
    array("value" => "POST-DOC", "label" => "Post-doctorado"),
    array("value" => "NONE", "label" => "Ninguno (Formación por extensión)"),
);

const LIST_PROGRAMS_STATUSES = array(
    array("value" => "ACTIVE", "label" => "Activo"),
    array("value" => "CLOSED", "label" => "Cerrado"),
);

const LIST_EVALUATIONS_TYPES = array(
    array("value" => "QUALITATIVE", "label" => "Cualitativo"),
    array("value" => "QUANTITATIVE", "label" => "Cuantitativo"),
);

const LIST_FORMATS_TYPES = array(
    array("label" => "Certificado", "value" => "CERTIFICATE"),
    array("label" => "Acreditación", "value" => "ACCREDITATION"),
    array("label" => "Insignia", "value" => "INSIGNIA"),
);

?>