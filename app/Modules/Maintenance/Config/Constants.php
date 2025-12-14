<?php





const MAINTENANCE_TYPES= array(
    array("value" => "", "label" => "Seleccione un tipo"),
    array("value" => "EQUIPMENT", "label" => "Equipos Informáticos"),
    array("value" => "ELECTROMECHANICAL", "label" => "Equipos Electromecánico"),
    array("value" => "VEHICLE", "label" => "Vehículos"),
    array("value" => "MACHINERY", "label" => "Maquinaria"),
    array("value" => "OFFICE_EQUIPMENT", "label" => "Equipos de Oficina"),
    array("value" => "APPLIANCES", "label" => "Electrodomésticos"),
    array("value" => "HAND_TOOLS", "label" => "Herramientas y Equipos Manuales"),
    array("value" => "SECURITY_EQUIPMENT", "label" => "Equipos de Seguridad"),
    array("value" => "FACILITIES", "label" => "Instalaciones Físicas"),
    array("value" => "AUDIO_VIDEO_EQUIPMENT", "label" => "Equipos de Audio y Video"),
    array("value" => "NETWORK_SYSTEMS", "label" => "Sistemas de Redes"),
    array("value" => "FURNITURE", "label" => "Mobiliario"),
    array("value" => "MEDICAL_EQUIPMENT", "label" => "Equipos Médicos"),
    array("value" => "ENERGY_EQUIPMENT", "label" => "Equipos de Energía"),
    array("value" => "PRODUCTION_EQUIPMENT", "label" => "Equipos de Producción"),
    array("value" => "CONSTRUCTION_TOOLS", "label" => "Herramientas de Construcción"),
    array("value" => "STORAGE_EQUIPMENT", "label" => "Equipos de Almacenaje"),
    array("value" => "TELECOMMUNICATION_EQUIPMENT", "label" => "Equipos de Telecomunicaciones"),
    array("value" => "AGRICULTURE_EQUIPMENT", "label" => "Equipos de Agricultura"),
    array("value" => "LAB_EQUIPMENT", "label" => "Equipos de Investigación y Laboratorio"),
    array("value" => "OTHER", "label" => "Otros")
);

const MAINTENANCES_TYPES  = array(
    array("value"=>"PREVENTIVE","label"=>"Preventivo"),
    array("value"=>"CORRECTIVE","label"=>"Correctivo"),
    array("value"=>"PREDICTIVE","label"=>"Predictivo"),
    array("value"=>"PROGRAMMED","label"=>"Programado"),
    array("value"=>"ROUTINE","label"=>"Rutinario"),
    array("value"=>"EMERGENCY","label"=>"Urgente"),
    array("value"=>"SCHEDULED","label"=>"Planificado"),
    array("value"=>"UNSCHEDULED","label"=>"No planificado"),
);

const MAINTENANCES_STATUSES = array(
    ['value' => 'PLANNED','label' => 'Mantenimiento programado pero aún no iniciado'],
    ['value' => 'PENDING','label' => 'Esperando autorización para ser ejecutado'],
    ['value' => 'SCHEDULED','label' => 'Fecha de ejecución ya asignada'],
    ['value' => 'INPROGRESS','label' => 'Mantenimiento actualmente en ejecución'],
    ['value' => 'AWAITING','label' => 'Pausado por falta de repuestos o materiales'],
    ['value' => 'COMPLETED','label' => 'Mantenimiento finalizado correctamente'],
    ['value' => 'POSTPONED','label' => 'Fue reprogramado para una fecha futura'],
    ['value' => 'OVERDUE','label' => 'No se ha realizado en la fecha prevista'],
    ['value' => 'CANCELLED','label' => 'Fue cancelado y no se realizará']
);


const MAINTENANCES_LIST_FILE_TYPES=array(
    // Documentos comerciales y administrativos
    array("value" => "QUOTATION", "label" => "Cotización"),
    array("value" => "CONTROL", "label" => "Control de actividades de mantenimiento"),
    array("value" => "PURCHASE-REQUEST", "label" => "Solicitud de Compra"),
    array("value" => "PURCHASE-ORDER", "label" => "Orden de Compra"),
    array("value" => "FACTURE", "label" => "Factura"),
    array("value" => "CERTIFICATION", "label" => "Certificación"),
    array("value" => "SUPPLIER-PERFORMANCE-TRACKING", "label" => "Verificación y Seguimiento al Desempeño de Proveedores de Servicios"),
    array("value" => "TECHNICAL-REPORT-SUPPLIERS", "label" => "Informe Técnico Proveedores Área de Mantenimiento"),
    // Otros documentos
    array("value" => "OTHER-DOCUMENT", "label" => "Otro Documento")
);

const MAINTENANCE_STATUSES  = array(
    array("value" => "", "label" => "Seleccione un estado"),
    array("value" => "OPERATIONAL", "label" => "Operativo"),
    array("value" => "UNDER_MAINTENANCE", "label" => "En Mantenimiento"),
    array("value" => "OUT_OF_SERVICE", "label" => "Fuera de Servicio"),
    array("value" => "DAMAGED", "label" => "Dañado"),
    array("value" => "REPAIRED", "label" => "Reparado"),
    array("value" => "DECOMMISSIONED", "label" => "Desincorporado"),
    array("value" => "PENDING", "label" => "Pendiente"),
    array("value" => "COMPLETED", "label" => "Completado"),
    array("value" => "IN_TRANSIT", "label" => "En Tránsito"),
    array("value" => "INSTALLED", "label" => "Instalado"),
    array("value" => "EXPIRED", "label" => "Vencido"),
    array("value" => "AVAILABLE", "label" => "Disponible"),
    array("value" => "NOT_AVAILABLE", "label" => "No Disponible"),
    array("value" => "IN_USE", "label" => "En Uso"),
    array("value" => "RETIRED", "label" => "Retirado"),
    array("value" => "PARKED", "label" => "Estacionado"),
    array("value" => "SUSPENDED", "label" => "Suspendido"),
    array("value" => "RETURNED", "label" => "Devuelto")
);