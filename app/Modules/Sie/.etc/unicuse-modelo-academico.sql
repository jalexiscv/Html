-- =====================================================
-- Script de Migración: Modelo Académico UNICUCES
-- Añade campos: CR, HT, HP, HTI, HTT (nombres en inglés)
-- Tabla: sie_pensums
-- =====================================================

-- Añadir los nuevos campos del modelo de créditos académicos
ALTER TABLE `sie_pensums`
    -- Créditos Académicos (ya existe como 'credits', lo mantenemos)

    -- Horas Teóricas (presenciales con docente)
    ADD COLUMN `theoretical_hours` INT NULL DEFAULT NULL COMMENT 'HT: Theoretical hours (classroom with teacher)' AFTER `credits`,

  -- Horas Prácticas (laboratorios, talleres)
  ADD COLUMN `practical_hours` INT NULL DEFAULT NULL COMMENT 'HP: Practical hours (labs, workshops)' AFTER `theoretical_hours`,

  -- Horas de Trabajo Independiente (estudio autónomo)
  ADD COLUMN `independent_work_hours` INT NULL DEFAULT NULL COMMENT 'HTI: Independent work hours (autonomous study)' AFTER `practical_hours`,

  -- Horas Totales de Trabajo (calculado: HT + HP + HTI)
  ADD COLUMN `total_hours` INT NULL DEFAULT NULL COMMENT 'HTT: Total work hours (HT+HP+HTI). Must be multiple of 48 per credit' AFTER `independent_work_hours`,

  -- Área de formación según PEI UNICUCES
  ADD COLUMN `training_area` ENUM('BASIC','PROFESSIONAL','COMPLEMENTARY','SPECIALIZATION') NULL DEFAULT NULL COMMENT 'Training area according to UNICUCES model' AFTER `total_hours`,

  -- Tipo de asignatura
  ADD COLUMN `subject_type` ENUM('MANDATORY','ELECTIVE','OPTIONAL') NULL DEFAULT 'MANDATORY' COMMENT 'Subject type in curriculum' AFTER `training_area`,

  -- Prerrequisitos (JSON para flexibilidad)
  ADD COLUMN `prerequisites` JSON NULL DEFAULT NULL COMMENT 'JSON array of prerequisite subject codes' AFTER `subject_type`,

  -- Observaciones adicionales
  ADD COLUMN `notes` TEXT NULL DEFAULT NULL COMMENT 'Additional notes about the subject in curriculum' AFTER `prerequisites`;

-- =====================================================
-- Crear índices para mejorar consultas
-- =====================================================

-- Índice para filtrar por área de formación
CREATE INDEX `idx_training_area` ON `sie_pensums` (`training_area`) USING BTREE;

-- Índice para filtrar por tipo de asignatura
CREATE INDEX `idx_subject_type` ON `sie_pensums` (`subject_type`) USING BTREE;

-- Índice compuesto para consultas frecuentes
CREATE INDEX `idx_pensum_cycle_level` ON `sie_pensums` (`pensum`, `cycle`, `level`) USING BTREE;
