# Estándares de Especialidades (HL7 PRA-5)

## Definición y Propósito

Una **Especialidad** en el contexto de IRIS representa una rama específica de la medicina o una subespecialidad oftalmológica en la que un profesional ha recibido formación avanzada y certificación. No se limita solo a títulos académicos, sino que define las **competencias funcionales** dentro del sistema.

### Características Clave
*   **Competencia Clínica**: Define qué tipos de diagnósticos y tratamientos puede realizar el profesional (ej. un especialista en *Retina* está autorizado para interpretar angiografías).
*   **Gestión de Agenda**: Permite configurar agendas específicas (ej. "Consulta de Glaucoma" vs "Consulta General").
*   **Interoperabilidad**: Se mapea a estándares internacionales (HL7 Table 0146, SNOMED CT) para asegurar que las derivaciones y reportes sean entendibles por otros sistemas.

## Ejemplos de Datos

A continuación se presentan ejemplos de especialidades oftalmológicas comunes configuradas en el catálogo maestro.

```sql
-- Insertar especialidades oftalmológicas (Códigos basados en HL7/SNOMED)
INSERT INTO `iris_specialties` (`specialty`, `code`, `name`, `description`) VALUES
('SPEC-001', 'OPH', 'Oftalmología General', 'Atención primaria de salud visual, refracción y patologías comunes.'),
('SPEC-002', 'RET', 'Retina y Vítreo', 'Diagnóstico y tratamiento de enfermedades de la retina, mácula y cuerpo vítreo.'),
('SPEC-003', 'GLA', 'Glaucoma', 'Manejo de la presión intraocular y neuropatías ópticas asociadas.'),
('SPEC-004', 'COR', 'Córnea y Superficie Ocular', 'Tratamiento de patologías de la córnea, ojo seco y cirugía refractiva.'),
('SPEC-005', 'PED', 'Oftalmología Pediátrica', 'Atención visual especializada para infantes y niños, incluyendo estrabismo.'),
('SPEC-006', 'NEU', 'Neuro-Oftalmología', 'Trastornos visuales relacionados con el sistema nervioso.'),
('SPEC-007', 'OCU', 'Oculoplastia', 'Cirugía plástica y reconstructiva de párpados, órbita y vía lagrimal.');
```

## Implementación en Base de Datos (MySQL)

Para gestionar eficientemente las especialidades, se utiliza un modelo relacional que separa el **Catálogo de Especialidades** de la **Asignación a Profesionales**.

### 1. Catálogo de Especialidades (`iris_specialties`)
Almacena la definición maestra de cada especialidad.

```sql
CREATE TABLE `iris_specialties` (
  `specialty` VARCHAR(13) NOT NULL COMMENT 'ID único de la especialidad',
  `code` VARCHAR(20) NOT NULL COMMENT 'PRA-5: Código estándar (ej. HL7 Table 0146)',
  `name` VARCHAR(100) NOT NULL COMMENT 'Nombre legible de la especialidad',
  `description` TEXT DEFAULT NULL COMMENT 'Descripción detallada y alcance',
  -- Auditoría
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME DEFAULT NULL,
  
  PRIMARY KEY (`specialty`),
  UNIQUE KEY `uk_specialty_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Catálogo maestro de especialidades médicas';
```

### 2. Asignación a Profesionales
La vinculación entre profesionales y especialidades se gestiona a través de la tabla `iris_assignments`. Para más detalles sobre competencias y estructura, consulte:

*   **[Estándares de Asignaciones](ASSIGNMENTS.md)**
