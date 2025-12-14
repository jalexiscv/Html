# Estándares de Grupos de Práctica (HL7 PRA-2)

## Definición y Propósito

Un **Grupo de Práctica** en IRIS representa una unidad organizativa o funcional dentro de la institución médica. A diferencia de la especialidad (que define *qué sabe hacer* el médico), el grupo define *dónde o con quién trabaja*.

### Características Clave
*   **Gestión de Turnos**: Asignar horarios rotativos a grupos completos (ej. "Residentes", "Guardia Nocturna").
*   **Reportes Agrupados**: Generar estadísticas de productividad por departamento (ej. "Departamento de Retina").
*   **Control de Acceso**: Limitar la visibilidad de ciertos pacientes a grupos específicos.
*   **Interoperabilidad**: Mapear departamentos internos con códigos de unidades funcionales de HL7.

## Ejemplos de Datos

A continuación se presentan ejemplos de grupos de práctica comunes.

```sql
-- Insertar grupos de práctica
INSERT INTO `iris_groups` (`group`, `code`, `name`, `description`) VALUES
('GRP-001', 'DEPT-RET', 'Departamento de Retina', 'Equipo de especialistas en retina quirúrgica y médica.'),
('GRP-002', 'DEPT-GLA', 'Unidad de Glaucoma', 'Equipo multidisciplinario para manejo de glaucoma.'),
('GRP-003', 'URG', 'Urgencias Oftalmológicas', 'Personal asignado a la atención de emergencias 24/7.'),
('GRP-004', 'RES', 'Residentes', 'Médicos en formación bajo supervisión.'),
('GRP-005', 'ADM', 'Administrativos Clínicos', 'Personal de apoyo para gestión de historias clínicas.');
```

## Implementación en Base de Datos (MySQL)

Para gestionar eficientemente los grupos, se utiliza un modelo relacional que separa el **Catálogo de Grupos** de la **Asignación a Profesionales**.

### 1. Catálogo de Grupos (`iris_groups`)
Almacena la definición maestra de cada grupo o departamento.

```sql
CREATE TABLE `iris_groups` (
  `group` VARCHAR(13) NOT NULL COMMENT 'ID único del grupo',
  `code` VARCHAR(50) NOT NULL COMMENT 'PRA-2: Código del grupo (ej. DEPT-RET)',
  `name` VARCHAR(100) NOT NULL COMMENT 'Nombre legible del grupo',
  `description` TEXT DEFAULT NULL COMMENT 'Descripción de funciones del grupo',
  
  -- Auditoría
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME DEFAULT NULL,
  
  PRIMARY KEY (`group`),
  UNIQUE KEY `uk_group_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Catálogo maestro de grupos de práctica';
```

### 2. Membresías de Grupo
La vinculación entre profesionales y grupos se gestiona a través de la tabla `iris_memberships`. Para más detalles sobre roles, temporalidad y estructura, consulte:

*   **[Estándares de Membresías](MEMBERSHIPS.md)**
