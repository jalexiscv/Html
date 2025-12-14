<?php

namespace App\Modules\Sie\Models;

use App\Models\CachedModel;
use Config\Services;

/**
 * @Copilot Siempre que en el código se cree una variable llamada $mexecutions, esta deberá ser igualada a model('App\\Modules\\Sie\\Models\\Sie_Executions');
 * @Instruction $mexecutions = model('App\\Modules\\Sie\\Models\\Sie_Executions');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Sie_Executions extends CachedModel
{
    protected $table = "sie_executions";
    protected $primaryKey = "execution";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "execution",
        "registration",
        "progress",
        "course",
        "date_start",
        "date_end",
        "c1",
        "c2",
        "c3",
        "total",
        "period",
        "observation",
        "status",
        "author",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication";//default
    protected $version = '1.0.1';
    protected $cache_time = 60;

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        $this->exec_Migrate();
    }

    /**
     * Ejecuta las migraciones para el módulo actual.
     * @return void
     */
    private function exec_Migrate(): void
    {
        $migrations = Services::migrations();
        try {
            $migrations->setNamespace('App\\Modules\\Sie');// Set the namespace for the current module
            $migrations->latest();// Run the migrations for the current module
            $all = $migrations->findMigrations();// Find all migrations for the current module
        } catch (Throwable $e) {
            echo($e->getMessage());
        }
    }

    /**
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * autor del regsitro que se desea acceder, editar o eliminar.
     * @param type $id codigo primario del registro a consultar
     * @param type $author codigo del usuario del cual se pretende establecer la autoria
     * @return boolean falso o verdadero segun sea el caso
     */
    public function get_Authority($id, $author): bool
    {
        $row = parent::getCachedFirst([$this->primaryKey => $id]);
        if (isset($row["author"]) && $row["author"] == $author) {
            return (true);
        } else {
            return (false);
        }
    }

    /**
     * Obtiene una lista de registros con un rango especificado y opcionalmente filtrados por un término de búsqueda.
     * con opciones de filtrado y paginación.
     * @param int $limit El número máximo de registros a obtener por página.
     * @param int $offset El número de registros a omitir antes de comenzar a seleccionar.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return array|false        Un arreglo de registros combinados o false si no se encuentran registros.
     */
    public function get_List(int $limit, int $offset, string $search = ""): array|false
    {
        $result = $this
            ->groupStart()
            ->like("execution", "%{$search}%")
            ->orLike("progress", "%{$search}%")
            ->orLike("course", "%{$search}%")
            ->orLike("date_start", "%{$search}%")
            ->orLike("date_end", "%{$search}%")
            ->orLike("c1", "%{$search}%")
            ->orLike("c2", "%{$search}%")
            ->orLike("c3", "%{$search}%")
            ->orLike("total", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->orderBy("created_at", "DESC")
            ->findAll($limit, $offset);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    public function get_GridByProgress($progress): array
    {
        $rows = $this->where("progress", $progress)
            ->orderBy("created_at", "DESC")
            ->findAll();
        if (is_array($rows)) {
            return $rows;
        } else {
            return array();
        }
    }


    public function get_LastByProgress($progress): array
    {
        $rows = $this->where("progress", $progress)
            ->orderBy("execution", "DESC")
            ->first();
        if (is_array($rows)) {
            return $rows;
        } else {
            return array();
        }
    }

    public function get_CountByProgress($progress): int
    {
        $result = $this->where("progress", $progress)->countAllResults();
        return $result;
    }

    /**
     * Obtiene el número total de estudiantes de un curso.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int Devuelve el número total de registros que coinciden con el término de búsqueda.
     */
    public function get_StudentsByCourse($course): int
    {
        $result = $this->select('MAX(execution) as execution, progress')
            ->where('course', $course)
            ->orderBy('created_at', 'DESC')
            ->groupBy(['course', 'progress'])
            ->countAllResults();
        return ($result);
    }


    /**
     * SQL: SELECT
     * `sie_progress`.`progress` AS `progress1`,
     * `sie_enrollments`.`enrollment`,
     * `sie_executions`.`progress` AS `progress2`,
     * `sie_executions`.`c3` AS `c31`,
     * `sie_executions`.`c2` AS `c21`,
     * `sie_executions`.`c1` AS `c11`,
     * `sie_executions`.`total` AS `total1`,
     * `sie_registrations`.`registration`,
     * `sie_courses`.`course` AS `course1`,
     * `sie_courses`.`period` AS `period_curso`,
     * `sie_courses`.`name`
     * FROM
     * `sie_executions`
     * INNER JOIN `sie_progress` ON `sie_progress`.`progress` =
     * `sie_executions`.`progress`
     * INNER JOIN `sie_enrollments` ON `sie_enrollments`.`enrollment` =
     * `sie_progress`.`enrollment`
     * INNER JOIN `sie_registrations` ON `sie_registrations`.`registration` =
     * `sie_enrollments`.`registration`
     * INNER JOIN `sie_courses` ON `sie_executions`.`course` = `sie_courses`.`course`
     * WHERE
     * `sie_registrations`.`registration` = "6705258D8AF7F" AND
     * `sie_courses`.`period` = "2025A"
     * @param $period
     * @param $enrollment
     * @return array
     */

    public function get_ExecutionsByPeriodByEnrollment($registration, $period, $enrollment): array
    {
        //echo("Periodo: {$period} | Registro: {$registration}");
        $result = $this
            ->select(" 
            sie_progress.progress AS progress1,
            sie_enrollments.enrollment,
            sie_executions.progress AS progress2,
            sie_executions.c3 AS c31,
            sie_executions.c2 AS c21,
            sie_executions.c1 AS c11,
            sie_executions.total AS total1,
            sie_registrations.registration,
            sie_courses.course AS course1,
            sie_courses.period AS period_curso,
            sie_courses.name AS name_course,
            sie_executions.execution,
            sie_executions.deleted_at,
            sie_pensums.pensum,
            sie_pensums.level,
            sie_pensums.credits,
            sie_pensums.cycle,
            sie_pensums.moment,
            sie_pensums.module,
            sie_pensums.version,
            sie_modules.name AS name_module 
        ")
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner')
            ->join('sie_pensums', 'sie_courses.pensum = sie_pensums.pensum', 'inner')
            ->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner')
            ->where('sie_registrations.registration', $registration)
            ->where('sie_courses.period', $period)
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->findAll();

        return is_array($result) ? $result : [];
    }

    public function get_ExecutionsByPeriodByEnrollment2($registration, $period, $enrollment): array
    {
        // Primera consulta: ejecuciones con curso asociado (igual que la función original)
        $executionsWithCourse = $this
            ->select(" 
        sie_progress.progress AS progress1,
        sie_enrollments.enrollment,
        sie_executions.progress AS progress2,
        sie_executions.c3 AS c31,
        sie_executions.c2 AS c21,
        sie_executions.c1 AS c11,
        sie_executions.total AS total1,
        sie_registrations.registration,
        sie_courses.course AS course1,
        sie_courses.period AS period_curso,
        sie_courses.name AS name_course,
        sie_executions.execution,
        sie_executions.deleted_at,
        sie_pensums.pensum,
        sie_pensums.level,
        sie_pensums.credits,
        sie_pensums.cycle,
        sie_pensums.moment,
        sie_pensums.module,
        sie_pensums.version,
        sie_modules.name AS name_module 
    ")
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner')
            ->join('sie_pensums', 'sie_courses.pensum = sie_pensums.pensum', 'inner')
            ->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner')
            ->where('sie_registrations.registration', $registration)
            ->where('sie_courses.period', $period)
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->where('sie_executions.course IS NOT NULL')
            ->findAll();

        $executionsWithCourse = is_array($executionsWithCourse) ? $executionsWithCourse : [];

        // Segunda consulta: ejecuciones SIN curso asociado
        // Para estas ejecuciones necesitamos obtener la información de otra manera
        $executionsWithoutCourse = $this
            ->select(" 
        sie_progress.progress AS progress1,
        sie_enrollments.enrollment,
        sie_executions.progress AS progress2,
        sie_executions.c3 AS c31,
        sie_executions.c2 AS c21,
        sie_executions.c1 AS c11,
        sie_executions.total AS total1,
        sie_registrations.registration,
        NULL AS course1,
        sie_executions.period AS period_curso,
        sie_executions.name AS name_course,
        sie_executions.execution,
        sie_executions.deleted_at,
        sie_executions.pensum,
        sie_executions.level,
        sie_executions.credits,
        sie_executions.cycle,
        sie_executions.moment,
        sie_executions.module,
        sie_executions.version,
        COALESCE(sie_modules.name, sie_executions.name, 'Módulo sin definir') AS name_module 
    ")
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->join('sie_modules', 'sie_executions.module = sie_modules.module', 'left') // LEFT JOIN para módulos opcionales
            ->where('sie_registrations.registration', $registration)
            ->where('sie_executions.period', $period)
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->where('sie_executions.course IS NULL')
            ->findAll();

        $executionsWithoutCourse = is_array($executionsWithoutCourse) ? $executionsWithoutCourse : [];

        // Combinar ambos resultados
        $allExecutions = array_merge($executionsWithCourse, $executionsWithoutCourse);

        // Ordenar por execution ID para mantener consistencia
        usort($allExecutions, function($a, $b) {
            return strcmp($a['execution'], $b['execution']);
        });

        return $allExecutions;
    }

    public function get_ExecutionsByPeriodByEnrollment3($registration, $period, $enrollment): array
    {
        // Primera consulta: ejecuciones con curso asociado (igual que la función original)
        $executionsWithCourse = $this
            ->select("  
            sie_progress.progress AS progress1,
            sie_enrollments.enrollment,
            sie_executions.progress AS progress2,
            sie_executions.c3 AS c31,
            sie_executions.c2 AS c21,
            sie_executions.c1 AS c11,
            sie_executions.total AS total1,
            sie_registrations.registration,
            sie_courses.course AS course1,
            sie_courses.period AS period_curso,
            sie_courses.name AS name_course,
            sie_executions.execution,
            sie_executions.deleted_at,
            sie_pensums.pensum,
            sie_pensums.level,
            sie_pensums.credits,
            sie_pensums.cycle,
            sie_pensums.moment,
            sie_pensums.module,
            sie_pensums.version,
            sie_modules.name AS name_module 
        ")
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner')
            ->join('sie_pensums', 'sie_courses.pensum = sie_pensums.pensum', 'inner')
            ->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner')
            ->where('sie_registrations.registration', $registration)
            ->where('sie_courses.period', $period)
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->where('sie_executions.course IS NOT NULL')
            ->findAll();

        $executionsWithCourse = is_array($executionsWithCourse) ? $executionsWithCourse : [];

        // Segunda consulta: ejecuciones SIN curso asociado
        $executionsWithoutCourse = $this
            ->select(" 
            sie_progress.progress AS progress1,
            sie_enrollments.enrollment,
            sie_executions.progress AS progress2,
            sie_executions.c3 AS c31,
            sie_executions.c2 AS c21,
            sie_executions.c1 AS c11,
            sie_executions.total AS total1,
            sie_registrations.registration,
            NULL AS course1,
            sie_executions.period AS period_curso,
            'Módulo sin curso' AS name_course,
            sie_executions.execution,
            sie_executions.deleted_at,
            NULL AS pensum,
            NULL AS level,
            NULL AS credits,
            NULL AS cycle,
            NULL AS moment,
            NULL AS module,
            NULL AS version,
            'Módulo sin curso' AS name_module
        ")
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->where('sie_registrations.registration', $registration)
            ->where('sie_executions.period', $period)
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->where('sie_executions.course IS NULL')
            ->findAll();

        $executionsWithoutCourse = is_array($executionsWithoutCourse) ? $executionsWithoutCourse : [];

        // Combinar ambos resultados
        $allExecutions = array_merge($executionsWithCourse, $executionsWithoutCourse);

        // Ordenar por execution ID para mantener consistencia
        usort($allExecutions, function($a, $b) {
            return strcmp($a['execution'], $b['execution']);
        });

        return $allExecutions;
    }


    public function get_ExecutionsByPeriodByEnrollment4($registration, $period, $enrollment): array
    {
        // Primera consulta: ejecuciones con curso asociado
        $executionsWithCourse = $this
            ->select("  
            sie_progress.progress AS progress1,
            sie_enrollments.enrollment,
            sie_executions.progress AS progress2,
            sie_executions.c3 AS c31,
            sie_executions.c2 AS c21,
            sie_executions.c1 AS c11,
            sie_executions.total AS total1,
            sie_executions.status,
            sie_registrations.registration,
            sie_courses.course AS course1,
            sie_courses.period AS period_curso,
            sie_courses.name AS name_course,
            sie_executions.execution,
            sie_executions.deleted_at,
            sie_pensums.pensum,
            sie_pensums.level,
            sie_pensums.credits,
            sie_pensums.cycle,
            sie_pensums.moment,
            sie_pensums.module,
            sie_pensums.version,
            sie_modules.name AS name_module 
        ")
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner')
            ->join('sie_pensums', 'sie_courses.pensum = sie_pensums.pensum', 'inner')
            ->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner')
            ->where('sie_registrations.registration', $registration)
            ->where('sie_courses.period', $period)
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->where('sie_executions.course IS NOT NULL')
            ->findAll();

        $executionsWithCourse = is_array($executionsWithCourse) ? $executionsWithCourse : [];

        // Segunda consulta: ejecuciones SIN curso asociado
        $executionsWithoutCourse = $this
            ->select(" 
            sie_progress.progress AS progress1,
            sie_enrollments.enrollment,
            sie_executions.progress AS progress2,
            sie_executions.c3 AS c31,
            sie_executions.c2 AS c21,
            sie_executions.c1 AS c11,
            sie_executions.total AS total1,
            sie_executions.status,
            sie_registrations.registration,
            NULL AS course1,
            sie_executions.period AS period_curso,
            COALESCE(modules_table.name, 'Módulo sin curso') AS name_course,
            sie_executions.execution,
            sie_executions.deleted_at,
            sie_progress.pensum AS pensum,
            NULL AS level,
            NULL AS credits,
            NULL AS cycle,
            NULL AS moment,
            sie_progress.module AS module,
            NULL AS version,
            COALESCE(modules_table.name, 'Módulo sin curso') AS name_module
        ")
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->join('sie_pensums', 'sie_progress.pensum = sie_pensums.pensum', 'left')
            ->join('sie_modules modules_table', 'sie_pensums.module = modules_table.module', 'left')
            ->where('sie_registrations.registration', $registration)
            ->where('sie_executions.period', $period)
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->where('sie_executions.course IS NULL')
            ->findAll();

        $executionsWithoutCourse = is_array($executionsWithoutCourse) ? $executionsWithoutCourse : [];

        // Combinar ambos resultados
        $allExecutions = array_merge($executionsWithCourse, $executionsWithoutCourse);

        // Ordenar por execution ID para mantener consistencia
        usort($allExecutions, function($a, $b) {
            return strcmp($a['execution'], $b['execution']);
        });

        return $allExecutions;
    }

    public function get_ExecutionsByPeriodByEnrollment5($registration, $period, $enrollment): array
    {
        // Primera consulta: ejecuciones con curso asociado
        $executionsWithCourse = $this
            ->select("  
            sie_progress.progress AS progress1,
            sie_enrollments.enrollment,
            sie_executions.progress AS progress2,
            sie_executions.c3 AS c31,
            sie_executions.c2 AS c21,
            sie_executions.c1 AS c11,
            sie_executions.total AS total1,
            sie_executions.status,
            sie_registrations.registration,
            sie_courses.course AS course1,
            sie_courses.period AS period_curso,
            sie_courses.name AS name_course,
            sie_executions.execution,
            sie_executions.deleted_at,
            sie_pensums.pensum,
            sie_pensums.level,
            sie_pensums.credits,
            sie_pensums.cycle,
            sie_pensums.moment,
            sie_pensums.module,
            sie_pensums.version,
            sie_modules.name AS name_module,
            'standar' AS type
        ")
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner')
            ->join('sie_pensums', 'sie_courses.pensum = sie_pensums.pensum', 'inner')
            ->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner')
            ->where('sie_registrations.registration', $registration)
            ->where('sie_courses.period', $period)
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->where('sie_executions.course IS NOT NULL')
            ->findAll();

        $executionsWithCourse = is_array($executionsWithCourse) ? $executionsWithCourse : [];

        // Segunda consulta: ejecuciones SIN curso asociado
        $executionsWithoutCourse = $this
            ->select(" 
            sie_progress.progress AS progress1,
            sie_enrollments.enrollment,
            sie_executions.progress AS progress2,
            sie_executions.c3 AS c31,
            sie_executions.c2 AS c21,
            sie_executions.c1 AS c11,
            sie_executions.total AS total1,
            sie_executions.status,
            sie_registrations.registration,
            NULL AS course1,
            sie_executions.period AS period_curso,
            COALESCE(modules_table.name, 'Módulo sin curso') AS name_course,
            sie_executions.execution,
            sie_executions.deleted_at,
            sie_progress.pensum AS pensum,
            sie_pensums.level,
            sie_pensums.credits,
            sie_pensums.cycle,
            sie_pensums.moment,
            sie_progress.module AS module,
            sie_pensums.version,
            COALESCE(modules_table.name, 'Módulo sin curso') AS name_module,
            'imported' AS type
        ")
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->join('sie_pensums', 'sie_progress.pensum = sie_pensums.pensum', 'left')
            ->join('sie_modules modules_table', 'sie_pensums.module = modules_table.module', 'left')
            ->where('sie_registrations.registration', $registration)
            ->where('sie_executions.period', $period)
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->where('sie_executions.course IS NULL')
            ->findAll();

        $executionsWithoutCourse = is_array($executionsWithoutCourse) ? $executionsWithoutCourse : [];

        // Combinar ambos resultados
        $allExecutions = array_merge($executionsWithCourse, $executionsWithoutCourse);

        // Ordenar por execution ID para mantener consistencia
        usort($allExecutions, function($a, $b) {
            return strcmp($a['execution'], $b['execution']);
        });

        return $allExecutions;
    }



    /**
     * Obtiene los períodos académicos con ejecuciones para una matrícula específica
     *
     * @param string $enrollment ID de la matrícula
     * @return array Array con períodos y conteo de ejecuciones
     */
    public function getPeriodsByEnrollment($enrollment)
    {
        $builder = $this->builder(); // Usar el constructor de consultas del modelo

        $builder->select('sie_courses.period as period_curso, COUNT(DISTINCT sie_executions.execution) as ejecuciones')
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner')
            ->join('sie_pensums', 'sie_courses.pensum = sie_pensums.pensum', 'inner')
            ->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner')
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->groupBy('sie_courses.period')
            ->orderBy('sie_courses.period');
        $query = $builder->get();
        return $query ? $query->getResultArray() : [];
    }

    /**
     * Obtiene los períodos académicos con ejecuciones para una matrícula específica incluidos
     * si estos no poseen asociatividad con un curso por temas de homologación o importación.
     * @param string $enrollment ID de la matrícula
     * @return array Array con períodos y conteo de ejecuciones
     */
    public function getPeriodsByEnrollment2($enrollment)
    {
        $builder = $this->builder(); // Usar el constructor de consultas del modelo

        // Primera consulta: períodos de ejecuciones con curso asociado
        $builder->select('sie_courses.period as period_curso, COUNT(DISTINCT sie_executions.execution) as ejecuciones')
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner')
            ->join('sie_pensums', 'sie_courses.pensum = sie_pensums.pensum', 'inner')
            ->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner')
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->where('sie_executions.course IS NOT NULL')
            ->groupBy('sie_courses.period')
            ->orderBy('sie_courses.period');

        $queryWithCourse = $builder->get();
        $periodsWithCourse = $queryWithCourse ? $queryWithCourse->getResultArray() : [];

        // Segunda consulta: períodos de ejecuciones SIN curso asociado
        // Para estas ejecuciones, necesitamos obtener el período de otra manera
        $builder2 = $this->db->table('sie_executions');
        $builder2->select('sie_executions.period as period_curso, COUNT(DISTINCT sie_executions.execution) as ejecuciones')
            ->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner')
            ->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner')
            ->join('sie_registrations', 'sie_registrations.registration = sie_enrollments.registration', 'inner')
            ->where('sie_enrollments.enrollment', $enrollment)
            ->where('sie_executions.deleted_at', null)
            ->where('sie_executions.course IS NULL')
            ->where('sie_executions.period IS NOT NULL') // Solo si tienen período definido
            ->groupBy('sie_executions.period')
            ->orderBy('sie_executions.period');

        $queryWithoutCourse = $builder2->get();
        $periodsWithoutCourse = $queryWithoutCourse ? $queryWithoutCourse->getResultArray() : [];

        // Combinar ambos resultados y consolidar períodos duplicados
        $allPeriods = [];
        $periodMap = [];

        // Agregar períodos con curso
        foreach ($periodsWithCourse as $period) {
            $periodKey = $period['period_curso'];
            if (!isset($periodMap[$periodKey])) {
                $periodMap[$periodKey] = [
                    'period_curso' => $periodKey,
                    'ejecuciones' => 0
                ];
            }
            $periodMap[$periodKey]['ejecuciones'] += (int)$period['ejecuciones'];
        }

        // Agregar períodos sin curso
        foreach ($periodsWithoutCourse as $period) {
            $periodKey = $period['period_curso'];
            if (!isset($periodMap[$periodKey])) {
                $periodMap[$periodKey] = [
                    'period_curso' => $periodKey,
                    'ejecuciones' => 0
                ];
            }
            $periodMap[$periodKey]['ejecuciones'] += (int)$period['ejecuciones'];
        }

        // Convertir el mapa a array y ordenar
        $allPeriods = array_values($periodMap);

        // Ordenar por período
        usort($allPeriods, function($a, $b) {
            return strcmp($a['period_curso'], $b['period_curso']);
        });

        return $allPeriods;
    }


    /**
     * Retorna el listado de elementos existentes de forma que se pueda cargar un field tipo select.
     * Ejemplo de uso:
     * $model = model("App\\Modules\\Sie\\Models\\Sie_Modules");
     * $list = $model->get_SelectData();
     * $f->get_FieldSelect("list", array("selected" => $r["list"], "data" => $list, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
     */
    public function get_SelectData()
    {
        $result = $this->select("`{$this->primaryKey}` AS `value`,`name` AS `label`")->findAll();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param $product
     * @return array|false
     */
    public function get_Execution($execution): false|array
    {
        $result = parent::getCached($execution);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }


    /**
     * Obtiene el número total de registros que coinciden con un término de búsqueda.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int Devuelve el número total de registros que coinciden con el término de búsqueda.
     */
    function get_Total(string $search = ""): int
    {
        $result = $this
            ->groupStart()
            ->orLike("progress", "%{$search}%")
            ->orLike("course", "%{$search}%")
            ->orLike("date_start", "%{$search}%")
            ->orLike("date_end", "%{$search}%")
            ->orLike("calification_total", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->countAllResults();
        return ($result);
    }


    /**
     * Obtiene la última ejecución asociada a un progreso determinado.
     * @param string $progress Código del progreso a consultar.
     * @return array|false Un arreglo con los datos de la ejecución, o false si no se encuentra.
     */
    public function getLastExecutionbyProgress($progress): false|array
    {
        $row = $this->where('progress', $progress)->first();
        if (is_array($row)) {
            $value = $row;
        } else {
            $value = false;
        }
        return ($value);
    }

    /**
     * Permite determinar si un estudiante ene l perido indicado esta cursando un modulo de su pensum
     * @param $progress
     * @param $period
     * @return false|array
     */
    public function getExecutionByProgressByPeriod($progress, $period): false|array
    {
        $row = $this
            ->where('progress', $progress)
            ->where('period', $period)
            ->first();
        if (is_array($row)) {
            $value = $row;
        } else {
            $value = false;
        }
        return ($value);
    }

    /**
     * Obtiene todas las ejecuciones asociadas a un progreso determinado.
     * @param string $progress Código del progreso a consultar.
     * @return array|false Un arreglo con los datos de las ejecuciones, o false si no se encuentra.
     */
    public function getExecutionsByProgress($progress, $sql = false): array
    {
        return $this->where('progress', $progress)->findAll();
    }


    /**
     * SQL:
     * SELECT
     * `sie_enrollments`.`enrollment`,
     * `sie_enrollments`.`registration`,
     * `sie_executions`.`execution`,
     * `sie_executions`.`course` AS `course`,
     * `sie_executions`.`progress` AS `course_progress`,
     * `sie_courses`.`program` AS `course_program`,
     * `sie_courses`.`grid` AS `course_grid`,
     * `sie_courses`.`module` AS `course_module`,
     * `sie_courses`.`name` AS `course_name`,
     * `sie_pensums`.`pensum` AS `pensum`,
     * `sie_pensums`.`module` AS `pensum_module`,
     * `sie_modules`.`name` AS `pensum_module_name`,
     * `sie_versions`.`version` AS `version`,
     * `sie_versions`.`reference` AS `version_reference`,
     * `sie_grids`.`grid` AS `grid`,
     * `sie_grids`.`name` AS `grid_name`,
     * `sie_registrations`.`first_name`,
     * `sie_registrations`.`second_name`,
     * `sie_registrations`.`first_surname`,
     * `sie_registrations`.`second_surname`,
     * `sie_registrations`.`identification_number`,
     * `sie_registrations`.`identification_type`,
     * `sie_enrollments`.`period` AS `period`,
     * `sie_enrollments`.`program` AS `enrollment_program`
     * FROM
     * `sie_executions`
     * JOIN `sie_progress` ON `sie_progress`.`progress` = `sie_executions`.`progress`
     * JOIN `sie_enrollments` ON `sie_enrollments`.`enrollment` =
     * `sie_progress`.`enrollment`
     * INNER JOIN `sie_courses` ON `sie_executions`.`course` = `sie_courses`.`course`
     * INNER JOIN `sie_pensums` ON `sie_progress`.`pensum` = `sie_pensums`.`pensum`
     * INNER JOIN `sie_modules` ON `sie_pensums`.`module` = `sie_modules`.`module`
     * INNER JOIN `sie_versions` ON `sie_pensums`.`version` =
     * `sie_versions`.`version`
     * INNER JOIN `sie_grids` ON `sie_grids`.`grid` = `sie_versions`.`grid`
     * INNER JOIN `sie_registrations` ON `sie_enrollments`.`registration` =
     * `sie_registrations`.`registration`
     * WHERE
     * `sie_executions`.`deleted_at` IS NULL
     * GROUP BY
     * `sie_enrollments`.`registration`,
     * `sie_executions`.`course`,
     * `sie_executions`.`progress`,
     * `sie_courses`.`program`,
     * `sie_courses`.`grid`,
     * `sie_courses`.`module`,
     * `sie_courses`.`name`,
     * `sie_pensums`.`pensum`,
     * `sie_pensums`.`module`,
     * `sie_modules`.`name`,
     * `sie_versions`.`version`,
     * `sie_versions`.`reference`,
     * `sie_grids`.`grid`,
     * `sie_grids`.`name`,
     * `sie_registrations`.`first_name`,
     * `sie_registrations`.`second_name`,
     * `sie_registrations`.`first_surname`,
     * `sie_registrations`.`second_surname`,
     * `sie_registrations`.`identification_number`,
     * `sie_registrations`.`identification_type`,
     * `sie_enrollments`.`period`,
     * `sie_courses`.`reference`,
     * `sie_enrollments`.`program`
     * LIMIT 500
     * @param $data
     * @return void
     */

    public function get_Preenrollments(int $limit, int $offset, string $search = ""): array
    {
        $builder = $this->db->table($this->table);
        $builder->select("
        `sie_enrollments`.`enrollment`,
        `sie_enrollments`.`registration`,
        `sie_executions`.`execution`,
        `sie_executions`.`course` AS `course`,
        `sie_executions`.`progress` AS `course_progress`,
        `sie_courses`.`program` AS `course_program`,
        `sie_courses`.`grid` AS `course_grid`,
        `sie_courses`.`pensum` AS `course_pensum`, 
        `sie_courses`.`name` AS `course_name`,
        `sie_pensums`.`pensum` AS `pensum`,
        `sie_pensums`.`module` AS `pensum_module`,
        `sie_modules`.`name` AS `pensum_module_name`,
        `sie_versions`.`version` AS `version`,
        `sie_versions`.`reference` AS `version_reference`,
        `sie_grids`.`grid` AS `grid`,
        `sie_grids`.`name` AS `grid_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_number`,
        `sie_registrations`.`identification_type`,
        `sie_enrollments`.`period` AS `period`,
        `sie_enrollments`.`program` AS `enrollment_program`
    ");
        $builder->join('sie_progress', 'sie_progress.progress = sie_executions.progress');
        $builder->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment');
        $builder->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner');
        $builder->join('sie_pensums', 'sie_progress.pensum = sie_pensums.pensum', 'inner');
        $builder->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner');
        $builder->join('sie_versions', 'sie_pensums.version = sie_versions.version', 'inner');
        $builder->join('sie_grids', 'sie_grids.grid = sie_versions.grid', 'inner');
        $builder->join('sie_registrations', 'sie_enrollments.registration = sie_registrations.registration', 'inner');
        $builder->where('sie_executions.deleted_at', null);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('sie_enrollments.enrollment', $search)
                ->orLike('sie_enrollments.registration', $search)
                ->groupEnd();
        }

        $builder->groupBy([
            'sie_enrollments.registration',
            'sie_executions.course',
            'sie_executions.progress',
            'sie_courses.program',
            'sie_courses.grid',
            'sie_courses.pensum',
            'sie_courses.name',
            'sie_pensums.pensum',
            'sie_pensums.module',
            'sie_modules.name',
            'sie_versions.version',
            'sie_versions.reference',
            'sie_grids.grid',
            'sie_grids.name',
            'sie_registrations.first_name',
            'sie_registrations.second_name',
            'sie_registrations.first_surname',
            'sie_registrations.second_surname',
            'sie_registrations.identification_number',
            'sie_registrations.identification_type',
            'sie_enrollments.period',
            'sie_courses.reference',
            'sie_enrollments.program'
        ]);

        $builder->limit($limit, $offset);
        $query = $builder->get();
        return $query->getResultArray();
    }


    public function get_PreenrollmentsOLD1(int $limit, int $offset, string $search = ""): array
    {
        $builder = $this->db->table($this->table);
        $builder->select("
        `sie_enrollments`.`enrollment`,
        `sie_enrollments`.`registration`,
        `sie_executions`.`execution`,
        COUNT(*) AS `count`");
        $builder->join('sie_progress', 'sie_progress.progress = sie_executions.progress');
        $builder->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment');
        $builder->where('sie_executions.deleted_at', null);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('sie_enrollments.enrollment', $search)
                ->orLike('sie_enrollments.registration', $search)
                ->groupEnd();
        }

        $builder->groupBy('sie_enrollments.registration');
        $builder->limit($limit, $offset);
        $query = $builder->get();
        return $query->getResultArray();
    }

    /**
     * Retorna el número total de preinscripciones
     * @param string $search
     * @return int
     */
    public function get_TotalPreenrollments(string $search = ""): int
    {
        $builder = $this->db->table($this->table);
        $builder->select("COUNT(DISTINCT sie_enrollments.registration) AS total");
        $builder->join('sie_progress', 'sie_progress.progress = sie_executions.progress', 'inner');
        $builder->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner');
        $builder->where('sie_executions.deleted_at', null);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('sie_enrollments.enrollment', $search)
                ->orLike('sie_enrollments.registration', $search)
                ->groupEnd();
        }

        $query = $builder->get();
        $result = $query->getRowArray();
        return (int)$result['total'];
    }


    public function get_PreenrollmentsOLD()
    {
        $builder = $this->db->table($this->table);
        $builder->select("
            `sie_enrollments`.`enrollment`,
            `sie_enrollments`.`registration`,
             COUNT(*) AS `count`
        ");
        $builder->join('sie_progress', 'sie_progress.progress = sie_executions.progress');
        $builder->join('sie_enrollments', 'sie_enrollments.enrollment = sie_progress.enrollment');
        $builder->where('sie_executions.deleted_at', null);
        $builder->groupBy('sie_enrollments.registration');
        $query = $builder->get();
        return $query->getResultArray();
    }


    /**
     * Retorna el listado de ejecuciones de cursos por periodo x matricula x estudiante
     */

    public function get_ByPeriodByRegistration(string $period, string $registration)
    {
        $query = $this->db->table('sie_registrations')
            ->select('
            sie_enrollments.enrollment,
            sie_executions.execution,
            sie_executions.c1,
            sie_executions.c2,
            sie_executions.c3,
            sie_executions.total,
            sie_courses.course,
            CASE 
                WHEN (sie_executions.c1 >= 80 
                    AND sie_executions.c2 >= 80 
                    AND sie_executions.c3 >= 80)
                THEN "APPROVED"
                ELSE "POSTPONED"
            END AS status
        ')
            ->join('sie_enrollments', 'sie_registrations.registration = sie_enrollments.registration')
            ->join('sie_progress', 'sie_enrollments.enrollment = sie_progress.enrollment')
            ->join('sie_executions', 'sie_progress.progress = sie_executions.progress')
            ->join('sie_courses', 'sie_courses.course = sie_executions.course')
            ->where([
                'sie_courses.period' => $period,
                'sie_registrations.registration' => $registration,
                'sie_courses.deleted_at' => null,
                'sie_executions.deleted_at' => null,
                'sie_progress.deleted_at' => null,
                'sie_enrollments.deleted_at' => null
            ])
            ->get();
        return $query->getResultArray();
    }

    public function get_EarnCreditsByPeriodByRegistration(string $period, string $registration)
    {
        $result = $this->db->table('sie_registrations')
            ->select('
            sie_enrollments.enrollment,
            sie_executions.execution,
            sie_executions.c1,
            sie_executions.c2,
            sie_executions.c3,
            sie_executions.total,
            sie_courses.course,
            sie_pensums.credits,
            CASE 
                WHEN (sie_executions.c1 >= 80 
                    AND sie_executions.c2 >= 80 
                    AND sie_executions.c3 >= 80)
                THEN "APPROVED"
                ELSE "POSTPONED"
            END AS status
        ')
            ->join('sie_enrollments', 'sie_registrations.registration = sie_enrollments.registration')
            ->join('sie_progress', 'sie_enrollments.enrollment = sie_progress.enrollment')
            ->join('sie_executions', 'sie_progress.progress = sie_executions.progress')
            ->join('sie_courses', 'sie_courses.course = sie_executions.course')
            ->join('sie_pensums', 'sie_progress.pensum = sie_pensums.pensum')
            ->where([
                'sie_courses.period' => $period,
                'sie_registrations.registration' => $registration,
                'sie_courses.deleted_at' => null,
                'sie_executions.deleted_at' => null,
                'sie_progress.deleted_at' => null,
                'sie_enrollments.deleted_at' => null
            ])
            ->get()
            ->getResultArray();
        return ($result);
    }


    public function get_CountExecutionsByPeriod(string $period)
    {

    }


    /**
     * Obtiene información de ejecuciones, cursos, progreso, matrículas y registros filtrados por período, con paginación.
     *
     * @param string $period El período a filtrar (ej. "2025A").
     * @param int $limit El número máximo de registros a retornar.
     * @param int $offset El punto de inicio para la paginación.
     *
     * @return array|false Un arreglo de resultados o `false` si hay un error.
     */


    public function get_ExecutionsByPeriod(string $period, int $limit = 0, int $offset = 0): array|false
    {
        $builder = $this->builder(); // Obtiene el constructor de consultas asociado al modelo (tabla sie_executions)
        $builder->select("
        `sie_executions`.`progress`,
        `sie_executions`.`course`,
        `sie_executions`.`c1`,
        `sie_executions`.`c2`,
        `sie_executions`.`c3`,
        `sie_executions`.`total`,
        `sie_courses`.`course` AS `course_course`,
        `sie_courses`.`period`,
        `sie_courses`.`agreement`,
        `sie_courses`.`agreement_institution`,
        `sie_courses`.`description` AS `course_description`,
        `sie_courses`.`pensum` AS `course_pensum`,
        `sie_progress`.`enrollment`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_type`,
        `sie_registrations`.`identification_number`,
        `sie_executions`.`deleted_at`,
        `sie_courses`.`name` AS `course_name`, 
        Max(`sie_executions`.`execution`) AS `Max_execution`,
        `sie_registrations`.`registration`,
        `sie_courses`.`teacher` AS `course_teacher`,
        `sie_enrollments`.`program`,
        `sie_enrollments`.`registration`,
        `sie_programs`.`name` AS `program_name`,
        `sie_courses`.`journey`,
        `sie_pensums`.`cycle`,
        `sie_pensums`.`level`,
        `sie_pensums`.`credits`,
        `sie_pensums`.`moment`,
        `sie_modules`.`module`,
        `sie_modules`.`name` AS `module_name`
    ");

        $builder->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner');
        $builder->join('sie_progress', 'sie_executions.progress = sie_progress.progress', 'inner');
        $builder->join('sie_enrollments', 'sie_progress.enrollment = sie_enrollments.enrollment', 'inner');
        $builder->join('sie_registrations', 'sie_enrollments.registration = sie_registrations.registration', 'inner');
        $builder->join('sie_programs', 'sie_enrollments.program = sie_programs.program', 'inner');
        $builder->join('sie_pensums', 'sie_progress.pensum = sie_pensums.pensum', 'inner');
        $builder->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner'); // Nuevo join añadido

        $builder->where('sie_courses.period', $period);
        $builder->where('sie_executions.deleted_at', null);

        $builder->groupBy('
        `sie_executions`.`progress`,
        `sie_executions`.`course`,
        `sie_executions`.`c1`,
        `sie_executions`.`c2`,
        `sie_executions`.`c3`,
        `sie_executions`.`total`,
        `sie_courses`.`course`,
        `sie_courses`.`period`,
        `sie_progress`.`enrollment`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_type`,
        `sie_registrations`.`identification_number`,
        `sie_executions`.`deleted_at`,
        `sie_courses`.`name`,
        `sie_registrations`.`registration`,
        `sie_courses`.`teacher`,
        `sie_enrollments`.`program`,
        `sie_enrollments`.`registration`,
        `sie_programs`.`name`,
        `sie_courses`.`journey`,
        `sie_pensums`.`cycle`,
        `sie_pensums`.`level`,
        `sie_pensums`.`credits`,
        `sie_pensums`.`moment`,
        `sie_modules`.`module`,
        `sie_modules`.`name`
    ');

        $builder->orderBy('`sie_registrations`.`registration`');

        // Aplicar límite y offset solo si son mayores que cero
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }

        $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }


    public function get_ExecutionsByPeriodWithCount(string $period, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->builder(); // Obtiene el constructor de consultas asociado al modelo

        // Primero, obtenemos el conteo total sin aplicar límites
        $countBuilder = clone $builder;
        $countBuilder->select('COUNT(DISTINCT sie_executions.progress) as total_count');
        $countBuilder->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner');
        $countBuilder->where('sie_courses.period', $period);
        $countBuilder->where('sie_executions.deleted_at', null);

        $countResult = $countBuilder->get()->getRowArray();
        $totalCount = $countResult['total_count'] ?? 0;

        // Ahora, obtenemos los resultados con paginación
        $builder->select("
        `sie_executions`.`progress`,
        `sie_executions`.`course`,
        `sie_executions`.`c1`,
        `sie_executions`.`c2`,
        `sie_executions`.`c3`,
        `sie_executions`.`total`,
        `sie_courses`.`course` AS `course_course`,
        `sie_courses`.`period`,
        `sie_courses`.`agreement`,
        `sie_courses`.`agreement_institution`,
        `sie_courses`.`description` AS `course_description`,
        `sie_courses`.`pensum` AS `course_pensum`,
        `sie_progress`.`enrollment`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_type`,
        `sie_registrations`.`identification_number`,
        `sie_executions`.`deleted_at`,
        `sie_courses`.`name` AS `course_name`, 
        Max(`sie_executions`.`execution`) AS `Max_execution`,
        `sie_registrations`.`registration`,
        `sie_registrations`.`email_address`,
        `sie_registrations`.`email_institutional`,
        `sie_courses`.`teacher` AS `course_teacher`,
        `sie_enrollments`.`program`,
        `sie_enrollments`.`registration`,
        `sie_programs`.`name` AS `program_name`,
        `sie_courses`.`journey`,
        `sie_pensums`.`cycle`,
        `sie_pensums`.`level`,
        `sie_pensums`.`credits`,
        `sie_pensums`.`moment`,
        `sie_modules`.`module`,
        `sie_modules`.`name` AS `module_name`
    ");

        $builder->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner');
        $builder->join('sie_progress', 'sie_executions.progress = sie_progress.progress', 'inner');
        $builder->join('sie_enrollments', 'sie_progress.enrollment = sie_enrollments.enrollment', 'inner');
        $builder->join('sie_registrations', 'sie_enrollments.registration = sie_registrations.registration', 'inner');
        $builder->join('sie_programs', 'sie_enrollments.program = sie_programs.program', 'inner');
        $builder->join('sie_pensums', 'sie_progress.pensum = sie_pensums.pensum', 'inner');
        $builder->join('sie_modules', 'sie_pensums.module = sie_modules.module', 'inner');

        $builder->where('sie_courses.period', $period);
        $builder->where('sie_executions.deleted_at', null);

        $builder->groupBy('
        `sie_executions`.`progress`,
        `sie_executions`.`course`,
        `sie_executions`.`c1`,
        `sie_executions`.`c2`,
        `sie_executions`.`c3`,
        `sie_executions`.`total`, 
        `sie_courses`.`course`,
        `sie_courses`.`period`,
        `sie_progress`.`enrollment`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_type`,
        `sie_registrations`.`identification_number`,
        `sie_executions`.`deleted_at`,
        `sie_courses`.`name`,
        `sie_registrations`.`registration`,
        `sie_courses`.`teacher`,
        `sie_enrollments`.`program`,
        `sie_enrollments`.`registration`,
        `sie_programs`.`name`,
        `sie_courses`.`journey`,
        `sie_pensums`.`cycle`,
        `sie_pensums`.`level`,
        `sie_pensums`.`credits`,
        `sie_pensums`.`moment`,
        `sie_modules`.`module`,
        `sie_modules`.`name`
    ');

        $builder->orderBy('`sie_registrations`.`registration`');

        // Aplicar límite y offset solo si son mayores que cero
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }

        $query = $builder->get();
        $results = $query->getResultArray();

        // Retornar un array con los resultados y el conteo total
        return [
            'total' => $totalCount,
            'results' => $results
        ];
    }

    public function get_ExecutionsByPeriodOLD3(string $period, int $limit, int $offset): array|false
    {
        $builder = $this->builder(); // Obtiene el constructor de consultas asociado al modelo (tabla sie_executions)
        $builder->select("
        `sie_executions`.`progress`,
        `sie_executions`.`course`,
        `sie_executions`.`c1`,
        `sie_executions`.`c2`,
        `sie_executions`.`c3`,
        `sie_executions`.`total`,
        `sie_courses`.`course` AS `course_course`,
        `sie_courses`.`period`,
        `sie_courses`.`agreement`,
        `sie_courses`.`agreement_institution`,
        `sie_courses`.`description` AS `course_description`,
        `sie_courses`.`pensum` AS `course_pensum`, 
        `sie_progress`.`enrollment`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_type`,
        `sie_registrations`.`identification_number`,
        `sie_executions`.`deleted_at`,
        `sie_courses`.`name` AS `course_name`,
        Max(`sie_executions`.`execution`) AS `Max_execution`,
        `sie_registrations`.`registration`,
        `sie_courses`.`teacher` AS `course_teacher`,
        `sie_enrollments`.`program`,
        `sie_enrollments`.`registration`,
        `sie_programs`.`name` AS `program_name`,
        `sie_courses`.`journey`,
        `sie_pensums`.`cycle`,
        `sie_pensums`.`level`,
        `sie_pensums`.`credits`,
        `sie_pensums`.`moment`
    ");
        $builder->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner');
        $builder->join('sie_progress', 'sie_executions.progress = sie_progress.progress', 'inner');
        $builder->join('sie_enrollments', 'sie_progress.enrollment = sie_enrollments.enrollment', 'inner');
        $builder->join('sie_registrations', 'sie_enrollments.registration = sie_registrations.registration', 'inner');
        $builder->join('sie_programs', 'sie_enrollments.program = sie_programs.program', 'inner');
        $builder->join('sie_pensums', 'sie_progress.pensum = sie_pensums.pensum', 'inner');
        $builder->where('sie_courses.period', $period); // Añade la condición WHERE para el período
        $builder->where('sie_executions.deleted_at', null); // Añade la condición WHERE para el borrado lógico
        $builder->groupBy('
        `sie_executions`.`progress`,
        `sie_executions`.`course`,
        `sie_executions`.`c1`,
        `sie_executions`.`c2`,
        `sie_executions`.`c3`,
        `sie_executions`.`total`,
        `sie_courses`.`course`,
        `sie_courses`.`period`,
        `sie_progress`.`enrollment`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_type`,
        `sie_registrations`.`identification_number`,
        `sie_executions`.`deleted_at`,
        `sie_courses`.`name`,
        `sie_registrations`.`registration`,
        `sie_courses`.`teacher`,
        `sie_enrollments`.`program`,
        `sie_enrollments`.`registration`,
        `sie_programs`.`name`,
        `sie_courses`.`journey`,
        `sie_pensums`.`cycle`,
        `sie_pensums`.`level`,
        `sie_pensums`.`credits`,
        `sie_pensums`.`moment`
    '); // Añade la cláusula GROUP BY
        $builder->orderBy('`sie_registrations`.`registration`'); // Añade la cláusula ORDER BY
        $builder->limit($limit, $offset); // Aplica la paginación
        $query = $builder->get();
        $result = $query->getResultArray();
        return ($result);
    }

    public function get_ExecutionsByPeriodOLD2(string $period, int $limit, int $offset): array|false
    {
        $builder = $this->builder(); // Obtiene el constructor de consultas asociado al modelo (tabla sie_executions)

        $builder->select("
        `sie_executions`.`progress`,
        `sie_executions`.`course`,
        `sie_executions`.`c1`,
        `sie_executions`.`c2`,
        `sie_executions`.`c3`,
        `sie_executions`.`total`,
        `sie_courses`.`course` AS `course_course`,
        `sie_courses`.`period`,
        `sie_courses`.`journey`,
        `sie_progress`.`enrollment`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_type`,
        `sie_registrations`.`identification_number`,
        `sie_executions`.`deleted_at`,
        `sie_courses`.`name` AS `course_name`,
        Max(`sie_executions`.`execution`) AS `Max_execution`,
        `sie_registrations`.`registration`,
        `sie_courses`.`teacher` AS `course_teacher`,
        `sie_enrollments`.`program`,
        `sie_enrollments`.`registration`,
        `sie_programs`.`name` AS `program_name`
    ");

        $builder->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner');
        $builder->join('sie_progress', 'sie_executions.progress = sie_progress.progress', 'inner');
        $builder->join('sie_enrollments', 'sie_progress.enrollment = sie_enrollments.enrollment', 'inner');
        $builder->join('sie_registrations', 'sie_enrollments.registration = sie_registrations.registration', 'inner');
        $builder->join('sie_programs', 'sie_enrollments.program = sie_programs.program', 'inner');

        $builder->where('sie_courses.period', $period); // Añade la condición WHERE para el período
        $builder->where('sie_executions.deleted_at', null); // Añade la condición WHERE para el borrado lógico

        $builder->groupBy('
        `sie_executions`.`progress`,
        `sie_executions`.`course`,
        `sie_executions`.`c1`,
        `sie_executions`.`c2`,
        `sie_executions`.`c3`,
        `sie_executions`.`total`,
        `sie_courses`.`course`,
        `sie_courses`.`period`,
        `sie_progress`.`enrollment`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_type`,
        `sie_registrations`.`identification_number`,
        `sie_executions`.`deleted_at`,
        `sie_courses`.`name`,
        `sie_registrations`.`registration`,
        `sie_courses`.`teacher`,
        `sie_enrollments`.`program`,
        `sie_enrollments`.`registration`,
        `sie_programs`.`name`
    '); // Añade la cláusula GROUP BY

        $builder->orderBy('`sie_registrations`.`registration`'); // Añade la cláusula ORDER BY

        $builder->limit($limit, $offset); // Aplica la paginación

        $query = $builder->get();


        $result = $query->getResultArray();

        return ($result);
    }

    public function get_ExecutionsByPeriodOLD(string $period, int $limit, int $offset): array|false
    {
        $builder = $this->builder(); // Obtiene el constructor de consultas asociado al modelo (tabla sie_executions)

        $builder->select("
        `sie_executions`.`progress`,
        `sie_executions`.`course`,
        `sie_executions`.`c1`,
        `sie_executions`.`c2`,
        `sie_executions`.`c3`,
        `sie_executions`.`total`,
        `sie_courses`.`course` AS `course_course`,
        `sie_courses`.`period`,
        `sie_courses`.`teacher` AS `course_teacher`,
        `sie_progress`.`enrollment`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_type`,
        `sie_registrations`.`identification_number`,
        `sie_executions`.`deleted_at`,
        `sie_courses`.`name` AS `course_name`,
        Max(`sie_executions`.`execution`) AS `Max_execution`,
        `sie_registrations`.`registration`,
        `sie_enrollments`.`program` AS `enrollment_program`
    ");

        $builder->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner');
        $builder->join('sie_progress', 'sie_executions.progress = sie_progress.progress', 'inner');
        $builder->join('sie_enrollments', 'sie_progress.enrollment = sie_enrollments.enrollment', 'inner');
        $builder->join('sie_registrations', 'sie_enrollments.registration = sie_registrations.registration', 'inner');

        $builder->where('sie_courses.period', $period); // Añade la condición WHERE para el período
        $builder->where('sie_executions.deleted_at', null); // Añade la condición WHERE para el borrado lógico

        $builder->groupBy('
        `sie_executions`.`progress`,
        `sie_executions`.`course`,
        `sie_executions`.`c1`,
        `sie_executions`.`c2`,
        `sie_executions`.`c3`,
        `sie_executions`.`total`,
        `sie_courses`.`course`,
        `sie_courses`.`period`,
        `sie_courses`.`teacher`, 
        `sie_progress`.`enrollment`,
        `sie_registrations`.`second_name`,
        `sie_registrations`.`first_name`,
        `sie_registrations`.`first_surname`,
        `sie_registrations`.`second_surname`,
        `sie_registrations`.`identification_type`,
        `sie_registrations`.`identification_number`,
        `sie_executions`.`deleted_at`,
        `sie_courses`.`name`,
        `sie_registrations`.`registration`
    '); // Añade la cláusula GROUP BY
        $builder->orderBy('`sie_registrations`.`registration`');
        $builder->limit($limit, $offset); // Aplica la paginación

        $query = $builder->get();
        $result = $query->getResultArray();

        return ($result);
    }


}

?>