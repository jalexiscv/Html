# Estándares de Órdenes y Resultados (HL7 ORM/ORU)

## Gestión de Órdenes (ORM) y Resultados (ORU)

IRIS gestiona el ciclo completo de diagnóstico desde la solicitud hasta el reporte utilizando los flujos de trabajo definidos por HL7 para órdenes y observaciones.

### Órdenes (ORM - Order Entry)
Las solicitudes de estudios (`Studies`, `Procedures`) se estructuran siguiendo el mensaje **ORM**.
*   **ORC (Common Order)**: Información general de la orden (quién la pide, cuándo, prioridad).
*   **OBR (Observation Request)**: Detalles específicos del estudio solicitado (e.g., "Retinografía AO").

### Resultados (ORU - Observation Result)
Los reportes de diagnóstico (`Reports`) y los análisis de IA (`Diagnostics`) se estructuran como mensajes **ORU**.
*   **OBX (Observation/Result)**: Cada hallazgo clínico o medición de la IA se encapsula en un segmento OBX.
    *   **OBX-3 (Observation Identifier)**: Código del hallazgo (e.g., LOINC o código propietario).
    *   **OBX-5 (Observation Value)**: El valor del hallazgo (e.g., "Presencia de Exudados", "0.85" para probabilidad).
    *   **OBX-11 (Observation Result Status)**: Estado del resultado (Final, Preliminar, Corregido).

Esta separación permite que los resultados generados por la IA de IRIS sean fácilmente consumibles por otros sistemas médicos.
