# Estándares de Profesionales (HL7 STF/PRA)

## Gestión de Profesionales de la Salud

En el módulo IRIS, los profesionales se gestionan siguiendo los segmentos **STF (Staff Identification)** y **PRA (Practitioner Detail)** de HL7.

> [!NOTE]
> **¿Qué es STF?**
> **STF** son las siglas de **Staff Identification** (Identificación del Personal). Es un segmento estándar de HL7 diseñado para transmitir información maestra sobre el personal de la salud (médicos, enfermeros, técnicos, administrativos).
>
> En el contexto de IRIS, el segmento STF actúa como la "hoja de vida" digital del profesional, conteniendo datos inmutables o de larga duración como su identificación (Cédula), nombre, sexo y datos de contacto.

### Estructura de Datos

#### 1. Identificación (Segmento STF)
Utilizado para la información básica y demográfica del personal.
*   **STF-1 (Primary Key Value - Staff ID)**: Identificador único del médico o profesional en el sistema.
*   **STF-2 (Staff Identifier List)**: Otros identificadores (e.g., Cédula de ciudadanía).
*   **STF-3 (Staff Name)**: Nombre completo estructurado.
*   **STF-10 (Phone)**: Números de contacto.
*   **STF-11 (Office/Home Address)**: Direcciones físicas.

#### 2. Detalles Profesionales (Segmento PRA)
Utilizado para la información específica de la práctica clínica.
*   **PRA-2 (Practitioner Group)**: Grupo o departamento al que pertenece (e.g., Retina, Glaucoma).
*   **PRA-5 (Specialty)**: Código de la especialidad médica.
*   **PRA-6 (Practitioner ID Numbers)**: Números de registro profesional o licencias médicas.
*   **PRA-7 (Privileges)**: Privilegios clínicos y autorizaciones dentro del sistema.

### Roles y Relaciones (ROL)
El sistema permite definir roles específicos para cada episodio clínico (e.g., Médico Tratante, Médico Referente, Consultor) utilizando estructuras compatibles con el segmento **ROL**.

## Implementación en Base de Datos (MySQL)

Para persistir esta información respetando el estándar, se propone la siguiente estructura para la tabla `iris_professionals`.

```sql
-- Tabla Principal: Perfil del Profesional
CREATE TABLE `iris_professionals` (
  `professional` VARCHAR(13) NOT NULL COMMENT 'STF-1: Identificador único interno (UUID)',
  `national_id` VARCHAR(20) NOT NULL COMMENT 'STF-2: Cédula o DNI',
  `first_name` VARCHAR(100) NOT NULL COMMENT 'STF-3.2: Nombre(s)',
  `last_name` VARCHAR(100) NOT NULL COMMENT 'STF-3.1: Apellido(s)',
  `gender` ENUM('M','F','O','U') DEFAULT 'U' COMMENT 'STF-5: Sexo Administrativo',
  `birth_date` DATE DEFAULT NULL COMMENT 'STF-6: Fecha de Nacimiento',
  `active` TINYINT(1) DEFAULT 1 COMMENT 'STF-7: Estado Activo/Inactivo',
  `phone_number` VARCHAR(50) DEFAULT NULL COMMENT 'STF-10: Teléfono principal',
  `email` VARCHAR(150) DEFAULT NULL COMMENT 'STF-10: Correo electrónico',
  `address` TEXT DEFAULT NULL COMMENT 'STF-11: Dirección completa',
  
  -- Datos Profesionales (PRA)
  `license_number` VARCHAR(50) DEFAULT NULL COMMENT 'PRA-6: Registro Médico / Tarjeta Profesional',
  `privileges` JSON DEFAULT NULL COMMENT 'PRA-7: Estructura JSON con permisos específicos',
  
  -- Auditoría
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME DEFAULT NULL,
  
  PRIMARY KEY (`professional`),
  UNIQUE KEY `uk_national_id` (`national_id`),
  UNIQUE KEY `uk_license_number` (`license_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Almacena perfiles médicos basados en HL7 STF/PRA';

### Relaciones Extendidas

Para soportar la flexibilidad requerida por HL7 (múltiples especialidades y grupos), se han normalizado estas estructuras en tablas separadas. Consulte su documentación específica para más detalles:

*   **[Especialidades (PRA-5)](SPECIALTIES.md)**: Tabla `iris_specialties`.
*   **[Grupos de Práctica (PRA-2)](GROUPS.md)**: Tabla `iris_groups`.
```

### Mapeo de Campos

| Campo MySQL | Segmento HL7 | Descripción |
| :--- | :--- | :--- |
| `professional` | STF-1 | ID primario del sistema. |
| `national_id` | STF-2 | Identificador legal (Cédula). |
| `first_name` / `last_name` | STF-3 | Componentes del nombre XPN. |
| `specialty_code` (Tabla Relacional) | PRA-5 | Código estandarizado de especialidad (Múltiple). |
| `group_code` (Tabla Relacional) | PRA-2 | Grupo de práctica (Múltiple). |
| `license_number` | PRA-6 | Número de registro profesional para recetas/firmas. |

