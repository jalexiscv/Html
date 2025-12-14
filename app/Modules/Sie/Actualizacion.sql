-- 1) Ver cuántas filas se van a afectar (solo para revisar antes)
SELECT COUNT(*) AS filas_a_actualizar
FROM sie_executions
WHERE c1 >= 80
  AND c2 >= 80
  AND c3 >= 80
  AND (status IS NULL OR status <> 'APPROVED');




-- 2) Actualizar solo las ejecuciones aprobadas por nota
UPDATE sie_executions
SET status = 'APPROVED'
WHERE c1 >= 80
  AND c2 >= 80
  AND c3 >= 80
  AND (status IS NULL OR status <> 'APPROVED');


-- 3) Actualizar solo los progresos con una ultima ejecucion en un estado definido
UPDATE sie_progress p
    JOIN (
    SELECT progress, MAX(created_at) AS max_created_at
    FROM sie_executions
    WHERE deleted_at IS NULL
    GROUP BY progress
    ) ult
ON ult.progress = p.progress
    JOIN sie_executions e
    ON e.progress   = ult.progress
    AND e.created_at = ult.max_created_at
    SET p.status = e.status
WHERE e.status IS NOT NULL;
-- Opcionalmente puedes afinar más:
--   AND (p.status IS NULL OR p.status <> e.status);
