# Estándares de Pacientes (HL7 ADT)

## Gestión de Pacientes

La gestión de pacientes en el módulo IRIS se alinea con el estándar HL7, específicamente con los mensajes de tipo **ADT (Admission, Discharge, Transfer)** y el segmento **PID (Patient Identification)**.

### Segmento PID (Patient Identification)

La tabla `Patients` y sus estructuras relacionadas están diseñadas para capturar los datos críticos definidos en el segmento PID:

*   **PID-3 (Patient Identifier List)**: Identificadores únicos del paciente (Cédula, Pasaporte, Historia Clínica).
*   **PID-5 (Patient Name)**: Nombre legal completo, separado en componentes (Apellido, Nombre, Segundo Nombre).
*   **PID-7 (Date/Time of Birth)**: Fecha y hora de nacimiento.
*   **PID-8 (Administrative Sex)**: Sexo administrativo.
*   **PID-11 (Patient Address)**: Dirección de residencia.
*   **PID-13 (Phone Number - Home)**: Información de contacto.

### Flujos de Trabajo
*   **Registro**: Creación de un nuevo registro PID.
*   **Actualización**: Modificación de datos demográficos (ADT^A08).
*   **Fusión**: Unificación de registros duplicados (ADT^A40), manteniendo la integridad histórica.
