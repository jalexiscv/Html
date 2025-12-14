# Estándares de Asignaciones (Competencias)

## Definición y Propósito

Las **Asignaciones** (`iris_assignments`) representan la acreditación formal de una **Especialidad** a un **Profesional**.

A diferencia de una membresía (que es política/organizacional), una asignación es **técnica/funcional**:
*   **Competencia**: Certifica que el médico *sabe* y *puede* ejercer dicha especialidad.
*   **Privilegios**: Habilita al profesional para realizar procedimientos específicos de esa especialidad.
*   **Especialidad Principal**: Permite definir cuál es la especialidad primaria de atención (ej. para directorios médicos).

## Relación con HL7
Se alinea con las repeticiones del segmento **PRA-5 (Specialty)**. En IRIS, normalizamos esta relación N:M para permitir consultas eficientes y validaciones de integridad.

## Implementación en Base de Datos (MySQL)

La tabla `iris_assignments` gestiona la relación entre el catálogo de especialidades y los profesionales.

```sql
CREATE TABLE `iris_assignments` (
  `assignment` VARCHAR(13) NOT NULL COMMENT 'ID único de la asignación',
  `professional` VARCHAR(13) NOT NULL COMMENT 'FK: Profesional',
  `specialty` VARCHAR(13) NOT NULL COMMENT 'FK: Especialidad',
  `is_primary` TINYINT(1) DEFAULT 0 COMMENT 'Indica si es la especialidad principal',
  
  -- Auditoría
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME DEFAULT NULL,
  
  PRIMARY KEY (`assignment`),
  CONSTRAINT `fk_assign_prof` FOREIGN KEY (`professional`) REFERENCES `iris_professionals` (`professional`) ON DELETE CASCADE,
  CONSTRAINT `fk_assign_spec` FOREIGN KEY (`specialty`) REFERENCES `iris_specialties` (`specialty`) ON DELETE CASCADE,
  UNIQUE KEY `uk_prof_spec` (`professional`, `specialty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relación N:M entre Profesionales y Especialidades';
```

### Casos de Uso
1.  **Directorio Médico**: Mostrar "Oftalmólogo General" como título principal, aunque también tenga subespecialidad en "Córnea".
2.  **Validación Quirúrgica**: Impedir que un médico sin la asignación de "Retina" programe una vitrectomía.
