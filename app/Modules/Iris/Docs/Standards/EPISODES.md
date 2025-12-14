# Estándares de Episodios Clínicos

## Gestión de Episodios y Visitas

El manejo de episodios en IRIS se alinea con los eventos de **Admisión, Alta y Transferencia (ADT)** del estándar HL7.

### Conceptos Clave

*   **Episodio**: Un conjunto de interacciones clínicas relacionadas con una condición o periodo de tiempo específico.
*   **Visita (Encounter)**: Un contacto individual entre el paciente y el proveedor de salud.

### Alineación con HL7

*   **PV1 (Patient Visit)**: La estructura de datos de episodios captura la información del segmento PV1, incluyendo:
    *   **PV1-2 (Patient Class)**: Tipo de paciente (Ambulatorio, Hospitalizado, Emergencia).
    *   **PV1-3 (Assigned Patient Location)**: Ubicación física o lógica del paciente dentro del servicio de oftalmología.
    *   **PV1-7 (Attending Doctor)**: Médico responsable del episodio.
    *   **PV1-19 (Visit Number)**: Identificador único de la visita.
    *   **PV1-44 (Admit Date/Time)**: Fecha y hora de inicio del episodio.

Esta estandarización permite el seguimiento preciso del flujo del paciente a través del proceso de diagnóstico y tratamiento.
