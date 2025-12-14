# Estándares de Membresías (Afiliaciones)

## Definición y Propósito

Las **Membresías** (`iris_memberships`) representan el vínculo formal entre un **Profesional** y un **Grupo de Práctica**. 

A diferencia de una simple asignación, una membresía implica:
*   **Pertenencia Institucional**: El profesional es parte del staff de ese departamento.
*   **Roles Contextuales**: Un médico puede ser "Jefe" en el grupo de Retina, pero "Consultor" en el grupo de Urgencias.
*   **Temporalidad**: Las membresías pueden tener fechas de inicio y fin (ej. rotaciones de residentes).

## Relación con HL7
Aunque HL7 define la relación en el segmento PRA, el concepto de membresía se alinea con la gestión de recursos y la estructura organizacional (Segmentos ROL o ORG en versiones más nuevas). En el contexto de IRIS, materializa la relación N:M entre `STF` (Staff) y `PRA-2` (Group).

## Implementación en Base de Datos (MySQL)

La tabla `iris_memberships` actúa como tabla pivote con capacidades extendidas.

```sql
CREATE TABLE `iris_memberships` (
  `membership` VARCHAR(13) NOT NULL COMMENT 'ID único de la membresía',
  `professional` VARCHAR(13) NOT NULL COMMENT 'FK: El profesional afiliado',
  `group` VARCHAR(13) NOT NULL COMMENT 'FK: El grupo al que pertenece',
  
  -- Metadatos de la Afiliación
  `start_date` DATE DEFAULT NULL COMMENT 'Fecha de inicio de la afiliación',
  `end_date` DATE DEFAULT NULL COMMENT 'Fecha de fin (si aplica)',
  `role_in_group` VARCHAR(50) DEFAULT NULL COMMENT 'Rol dentro del grupo (ej. Jefe, Residente, Adjunto)',
  
  -- Auditoría
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME DEFAULT NULL,
  
  PRIMARY KEY (`membership`),
  CONSTRAINT `fk_memb_prof` FOREIGN KEY (`professional`) REFERENCES `iris_professionals` (`professional`) ON DELETE CASCADE,
  CONSTRAINT `fk_memb_grp` FOREIGN KEY (`group`) REFERENCES `iris_groups` (`group`) ON DELETE CASCADE,
  UNIQUE KEY `uk_prof_grp` (`professional`, `group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Afiliaciones de profesionales a grupos de práctica';
```

### Casos de Uso
1.  **Guardias**: Un médico general se une al grupo "Guardia Nocturna" solo por el fin de semana.
2.  **Interconsultas**: Un neurólogo tiene una membresía temporal en "Oftalmología" para casos de Neuro-oftalmología.
3.  **Jerarquía**: Definir quién es el jefe del "Departamento de Córnea".
