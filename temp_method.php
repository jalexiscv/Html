<?php
/**
 * Obtiene los períodos académicos con ejecuciones para una matrícula específica
 * 
 * @param string $enrollment ID de la matrícula
 * @return array Array con períodos y conteo de ejecuciones
 */
public function getPeriodsByEnrollment($enrollment)
{
    // Subconsulta con todos los campos necesarios
    $subquery = $this->db->table('sie_executions')
        ->select([
            'sie_progress.progress as progress1',
            'sie_enrollments.enrollment',
            'sie_executions.progress as progress2',
            'sie_executions.c3 as c31',
            'sie_executions.c2 as c21',
            'sie_executions.c1 as c11',
            'sie_executions.total as total1',
            'sie_registrations.registration',
            'sie_courses.course as course1',
            'sie_courses.period as period_curso',
            'sie_courses.name as name_course',
            'sie_executions.execution',
            'sie_executions.deleted_at',
            'sie_pensums.pensum',
            'sie_pensums.level',
            'sie_pensums.credits',
            'sie_pensums.cycle',
            'sie_pensums.moment',
            'sie_pensums.module',
            'sie_pensums.version',
            'sie_modules.name as name_module'
        ])
        ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
        ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
        ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.student', 'inner')
        ->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner')
        ->join('sie_pensums', 'sie_courses.pensum = sie_pensums.pensum', 'inner')
        ->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner')
        ->where('sie_enrollments.enrollment', $enrollment)
        ->where('sie_executions.deleted_at IS NULL')
        ->getCompiledSelect();
    
    // Consulta principal con GROUP BY y COUNT
    $result = $this->db->query(
        "SELECT 
            q.period_curso,
            COUNT(DISTINCT q.execution) AS ejecuciones
        FROM ({$subquery}) AS q
        GROUP BY q.period_curso
        ORDER BY q.period_curso"
    );
    
    return $result ? $result->getResultArray() : [];
}
?>
