<?php

namespace App\Modules\Sie\Models;

use App\Models\CachedModel;
use Config\Services;
use Exception;

/**
 * Ejemplo: $mcourses = model('App\Modules\Sie\Models\Sie_Courses');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Sie_Courses extends CachedModel
{
    protected $table = "sie_courses";
    protected $primaryKey = "course";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "course",
        "reference",
        "program",
        "grid",
        "version",
        "pensum",
        "teacher",
        "name",
        "description",
        "maximum_quota",
        "start",
        "end",
        "period",
        "status",
        "journey",
        "start_time",
        "end_time",
        "price",
        "agreement",
        "agreement_institution",
        "agreement_group",
        "moodle_course",
        "cycle",
        "space",
        "day",
        "author",
        "free",
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
            $migrations->setNamespace('App\Modules\Sie');// Set the namespace for the current module
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
            ->like("course", "%{$search}%")
            ->orLike("reference", "%{$search}%")
            ->orLike("program", "%{$search}%")
            ->orLike("grid", "%{$search}%")
            ->orLike("version", "%{$search}%")
            ->orLike("pensum", "%{$search}%")
            ->orLike("teacher", "%{$search}%")
            ->orLike("name", "%{$search}%")
            ->orLike("description", "%{$search}%")
            ->orLike("maximum_quota", "%{$search}%")
            ->orLike("start", "%{$search}%")
            ->orLike("end", "%{$search}%")
            ->orLike("period", "%{$search}%")
            ->orLike("space", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->orLike("journey", "%{$search}%")
            ->orLike("start_time", "%{$search}%")
            ->orLike("end_time", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->orLike("price", "%{$search}%")
            ->groupEnd()
            ->orderBy("created_at", "DESC")
            ->findAll($limit, $offset);

        // Siempre retornar un array, incluso si está vacío
        return is_array($result) ? $result : [];
    }

    /**
     * Retorna el listado de elementos existentes de forma que se pueda cargar un field tipo select.
     * Ejemplo de uso:
     * $model = model("App\Modules\Sie\Models\Sie_Modules");
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


    public function getCourse($course): false|array
    {
        $result = $this->where('course', $course)->first();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_ByPensum($pensum)
    {
        $result = $this
            ->where('status', "ACTIVE")
            ->where('pensum', $pensum)
            ->findAll();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Retorna el conteo de cursos existentes por per odo.
     * @param string $period Per odo que se desea contar.
     * @return int N mero de cursos existentes por per odo.
     */
    public function getCountByPeriod($period): int
    {
        $result = $this->where('period', $period)->countAllResults();
        return $result;
    }

    /**
     * Retrieves the total number of records in the database, without any condition.
     * @return int The total number of records in the database.
     */
    public function getCount(): int
    {
        $result = $this->countAllResults();
        return $result;
    }


    /**
     * Retrieves all courses which are active and associated to a given pensum.
     * @param string $pensum The pensum to retrieve courses from.
     * @return array|false The list of courses associated to the given pensum, or false if an error occurred.
     */
    public function getCoursesByPensum($pensum): array|false
    {
        $result =
            $this
                ->where('status', "ACTIVE")
                ->where('pensum', $pensum)
                ->findAll();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function getCoursesByPensumByJourney($pensum, $journey): array|false
    {
        $result =
            $this
                ->where('status', "ACTIVE")
                ->where('pensum', $pensum)
                ->where('journey', $journey)
                ->findAll();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    public function getCoursesByTeacher($teacher): array|false
    {
        $result = $this
            ->where('teacher', $teacher)
            ->orderBy('created_at', 'DESC')
            ->find();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Obtiene el número total cursos que han sido asignados a un profesor.
     * @param $teacher
     * @return int
     */
    public function get_TotalByTeacher($teacher): int
    {
        $result = $this
            ->where('teacher', $teacher)
            ->countAllResults();
        return ($result);
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
            ->orLike("program", "%{$search}%")
            ->orLike("module", "%{$search}%")
            ->orLike("teacher", "%{$search}%")
            ->orLike("name", "%{$search}%")
            ->orLike("description", "%{$search}%")
            ->orLike("maximum_quota", "%{$search}%")
            ->orLike("start", "%{$search}%")
            ->orLike("end", "%{$search}%")
            ->orLike("period", "%{$search}%")
            ->orLike("space", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->countAllResults();
        return ($result);
    }


    /**
     * Obtiene el número de estudiantes (ejecuciones) asociados a un curso específico.
     *
     * @param string $course El identificador único del curso
     * @return string El número de estudiantes como cadena de texto
     */
    public function get_CountStudentsByCourse(string $course): string
    {
        $builder = $this->db->table($this->table);
        $builder->select("$this->table.course, COUNT(sie_executions.execution) as count");
        $builder->join('sie_executions', "$this->table.course = sie_executions.course");
        $builder->where("$this->table.course", $course);
        $builder->where('sie_executions.deleted_at IS NULL', null, false);
        $builder->groupBy("$this->table.course, sie_executions.deleted_at");
        $result = $builder->get()->getRowArray();
        // Si no hay resultados, devolver "0"
        if (empty($result) || !isset($result['count'])) {
            return "0";
        }
        return (string)$result['count'];
    }


    /**
     * Obtiene el listado total de estudiantes matriculados en los diferentes cursos
     * @param string $period El período académico (por defecto "2025B")
     * @param int $limit Número máximo de registros a retornar (0 = sin límite)
     * @param int $offset Número de registros a omitir desde el inicio (para paginación)
     * @return array Listado de estudiantes matriculados con información del curso
     */
    public function get_EnrolledStudentsByCourses(string $period = "2025B", int $limit = 0, int $offset = 0): array
    {
        $builder = $this->db->table('sie_registrations');

        $builder->select([
            'sie_executions.course',
            'sie_progress.progress',
            'sie_registrations.registration',
            'sie_courses.period',
            'sie_registrations.identification_number',
            'sie_registrations.first_name',
            'sie_registrations.second_name',
            'sie_registrations.first_surname',
            'sie_registrations.second_surname',
            'sie_courses.course AS course_course',
            'sie_courses.name AS course_name',
            'sie_courses.moodle_course AS moodle_course',
            'sie_registrations.identification_number'
        ]);

        // Joins según la consulta SQL original
        $builder->join('sie_enrollments', 'sie_registrations.registration = sie_enrollments.student', 'inner');
        $builder->join('sie_progress', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner');
        $builder->join('sie_executions', 'sie_progress.progress = sie_executions.progress', 'inner');
        $builder->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner');

        // Filtro por período
        $builder->where('sie_courses.period', $period);

        // Aplicar paginación si se especifica
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }

        $result = $builder->get()->getResultArray();

        return $result ?? [];
    }

    /**
     * Obtiene el número total de estudiantes matriculados en los diferentes cursos
     * @param string $period El período académico (por defecto "2025B")
     * @return int Número total de estudiantes matriculados
     */
    public function get_TotalEnrolledStudentsByCourses(string $period = "2025B"): int
    {
        $builder = $this->db->table('sie_registrations');

        // Joins según la consulta SQL original
        $builder->join('sie_enrollments', 'sie_registrations.registration = sie_enrollments.student', 'inner');
        $builder->join('sie_progress', 'sie_enrollments.enrollment = sie_progress.enrollment', 'inner');
        $builder->join('sie_executions', 'sie_progress.progress = sie_executions.progress', 'inner');
        $builder->join('sie_courses', 'sie_executions.course = sie_courses.course', 'inner');

        // Filtro por período
        $builder->where('sie_courses.period', $period);

        $result = $builder->countAllResults();

        return $result;
    }


    /**
     * Obtiene los estudiantes que pueden tomar un curso específico
     * Basado en el progreso de los estudiantes en los módulos del pensum
     *
     * @param string $course ID del curso
     * @param string $search Término de búsqueda opcional (cédula o nombre)
     * @return array|bool Array de estudiantes o false si hay error
     */
    public function getStudentsCanTake(string $course, string $search = ''): array|bool
    {
        try {
            $builder = $this->db->table('sie_courses');

            // SELECT DISTINCT con campos específicos y CONCAT para nombre completo
            $builder->distinct();
            $builder->select([
                'sie_courses.course as course',
                'sie_pensums.module as module',
                'sie_enrollments.enrollment as enrollment',
                'sie_registrations.registration as registration',
                'CONCAT(
                    IFNULL(sie_registrations.first_name, ""), " ",
                    IFNULL(sie_registrations.first_surname, ""),
                    IF(sie_registrations.second_surname IS NOT NULL AND sie_registrations.second_surname != "", 
                       CONCAT(" ", sie_registrations.second_surname), 
                       "")
                ) as fullname',
                'sie_registrations.identification_number as identification',
                'sie_pensums.cycle',
                'sie_pensums.credits',
                'sie_pensums.moment',
                'sie_progress.progress as progress'
            ]);

            // JOINs según el SQL actualizado
            $builder->join('sie_pensums', 'sie_courses.pensum = sie_pensums.pensum', 'inner');
            $builder->join('sie_progress', 'sie_pensums.module = sie_progress.module', 'inner');
            $builder->join('sie_enrollments', 'sie_progress.enrollment = sie_enrollments.enrollment', 'inner');
            $builder->join('sie_registrations', 'sie_enrollments.student = sie_registrations.registration', 'inner');

            // WHERE conditions
            $builder->where('sie_courses.course', $course);
            $builder->where('sie_enrollments.deleted_at IS NULL');
            $builder->where('sie_progress.deleted_at IS NULL');

            // Filtro de búsqueda opcional
            if (!empty($search)) {
                $searchTerm = trim($search);
                $builder->groupStart()
                    ->like('sie_registrations.identification_number', $searchTerm)
                    ->orLike('sie_registrations.first_name', $searchTerm)
                    ->orLike('sie_registrations.first_surname', $searchTerm)
                    ->orLike('sie_registrations.second_surname', $searchTerm)
                    ->groupEnd();
            }

            // ORDER BY fullname
            $builder->orderBy('fullname');

            $query = $builder->get();
            $results = $query->getResultArray();

            // Formatear datos para el frontend
            $students = [];
            foreach ($results as $row) {
                $students[] = [
                    'id' => $row['registration'],
                    'cedula' => $row['identification'],
                    'nombre' => trim($row['fullname']),
                    'email' => '', // No disponible en este SQL, agregar si es necesario
                    'telefono' => '', // No disponible en este SQL, agregar si es necesario
                    'photo' => '/themes/assets/images/profile-portrait.png', // Imagen por defecto
                    'enrollment' => $row['enrollment'],
                    'course_id' => $row['course'],
                    'module' => $row['module'],
                    'cycle' => $row['cycle'],
                    'credits' => $row['credits'],
                    'moment' => $row['moment'],
                    'progress' => $row['progress']
                ];
            }

            return $students;

        } catch (Exception $e) {
            log_message('error', 'Error in getStudentsCanTake: ' . $e->getMessage());
            return false;
        }
    }


    /**
     * Obtiene los estudiantes que deberían ver un curso dado,
     * siempre que:
     *  - El progreso asociado al pensum de ese curso NO esté aprobado
     *    (ni por APPROVED, HOMOLOGATION, AGREEMENT).
     *  - El estudiante NO esté viendo ningún otro curso (de cualquier pensum)
     *    que comparta el mismo módulo base que este curso.
     *  - Incluye una columna que indica si ya tiene ejecución para este curso.
     *
     * @param string $courseId ID del curso (campo sie_courses.course)
     * @return array
     */

    public function getEligibleStudentsForCourse(string $courseId): array
    {
        $builder = $this->db->table('sie_courses c');

        $builder->distinct();
        $builder->select([
            'r.registration',
            'r.first_name',
            'r.second_name',
            'r.first_surname',
            'r.second_surname',
            'r.agreement',
            'p.progress',
            'p.status AS progress_status',
        ]);

        // Columna: ¿ya tiene ejecución para ESTE curso?
        $builder->select(
            "CASE WHEN ex.execution IS NOT NULL THEN 'REGISTERED' ELSE 'NOT_REGISTERED' END AS course_execution_status",
            false
        );

        // --- SUBQUERY: ¿alguna vez tuvo ejecución con el mismo módulo base? ---
        $prevExecSubquery = $this->db->table('sie_executions ex3')
            ->select('1')
            ->join('sie_progress p3', 'p3.progress = ex3.progress')
            ->join('sie_enrollments e3', 'e3.enrollment = p3.enrollment')
            ->join('sie_registrations r3', 'r3.registration = e3.registration')
            ->join('sie_courses c3', 'c3.course = ex3.course')
            ->join('sie_pensums pen3', 'pen3.pensum = c3.pensum')
            // mismo estudiante
            ->where('r3.registration = r.registration', null, false)
            // misma "materia base" (módulo)
            ->where('pen3.module = pen_target.module', null, false)
            // registros "vivos"
            ->where('ex3.deleted_at IS NULL')
            ->where('p3.deleted_at IS NULL')
            ->where('e3.deleted_at IS NULL')
            ->where('c3.deleted_at IS NULL');

        // Columna: ¿tiene alguna ejecución (histórica) con este mismo módulo base?
        $builder->select(
            "(CASE WHEN EXISTS (" . $prevExecSubquery->getCompiledSelect() . ") THEN 'YES' ELSE 'NO' END) AS has_previous_execution_module",
            false
        );

        // JOINS principales
        $builder->join('sie_pensums pen_target', 'pen_target.pensum = c.pensum');
        $builder->join('sie_progress p', 'p.pensum = c.pensum');
        $builder->join('sie_enrollments e', 'e.enrollment = p.enrollment');
        $builder->join('sie_registrations r', 'r.registration = e.registration');
        $builder->join(
            'sie_executions ex',
            'ex.progress = p.progress AND ex.course = c.course AND ex.deleted_at IS NULL',
            'left'
        );

        // Filtros base
        $builder->where('c.course', $courseId);
        $builder->where('c.deleted_at IS NULL');
        $builder->where('p.deleted_at IS NULL');
        $builder->where('e.deleted_at IS NULL');
        $builder->where('r.deleted_at IS NULL');

        // El progreso aún no se considera ganado
        $builder->groupStart()
            ->where('p.status', null)
            ->orWhereNotIn('p.status', ['APPROVED', 'HOMOLOGATION', 'AGREEMENT'])
            ->groupEnd();

        // El estudiante NO debe estar viendo actualmente un curso con el mismo módulo base
        $subquery = $this->db->table('sie_executions ex2')
            ->select('1')
            ->join('sie_progress p2', 'p2.progress = ex2.progress')
            ->join('sie_enrollments e2', 'e2.enrollment = p2.enrollment')
            ->join('sie_registrations r2', 'r2.registration = e2.registration')
            ->join('sie_courses c2', 'c2.course = ex2.course')
            ->join('sie_pensums pen2', 'pen2.pensum = c2.pensum')
            ->where('r2.registration = r.registration', null, false)
            ->where('ex2.deleted_at IS NULL')
            ->where('p2.deleted_at IS NULL')
            ->where('e2.deleted_at IS NULL')
            ->where('c2.deleted_at IS NULL')
            ->where('pen2.module = pen_target.module', null, false)
            ->where('c2.status', 'ACTIVE');

        $builder->where("NOT EXISTS (" . $subquery->getCompiledSelect() . ")", null, false);

        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getEligibleStudentsForCourse_OLD1(string $courseId): array
    {
        $builder = $this->db->table('sie_courses c');

        $builder->distinct();
        $builder->select([
            'r.registration',
            'r.first_name',
            'r.second_name',
            'r.first_surname',
            'r.second_surname',
            'p.progress',
            'p.status AS progress_status',
        ]);
        $builder->select("CASE WHEN ex.execution IS NOT NULL THEN 'REGISTERED' ELSE 'NOT_REGISTERED' END AS course_execution_status", false);

        $builder->join('sie_pensums pen_target', 'pen_target.pensum = c.pensum');
        $builder->join('sie_progress p', 'p.pensum = c.pensum');
        $builder->join('sie_enrollments e', 'e.enrollment = p.enrollment');
        $builder->join('sie_registrations r', 'r.registration = e.registration');
        $builder->join('sie_executions ex', 'ex.progress = p.progress AND ex.course = c.course AND ex.deleted_at IS NULL', 'left');

        $builder->where('c.course', $courseId);
        $builder->where('c.deleted_at IS NULL');
        $builder->where('p.deleted_at IS NULL');
        $builder->where('e.deleted_at IS NULL');
        $builder->where('r.deleted_at IS NULL');

        // El progreso aún no se considera ganado
        $builder->groupStart()
            ->where('p.status', null)
            ->orWhereNotIn('p.status', ['APPROVED', 'HOMOLOGATION', 'AGREEMENT'])
            ->groupEnd();

        // El estudiante NO debe estar viendo ningún curso con el mismo módulo base
        $subquery = $this->db->table('sie_executions ex2')
            ->select('1')
            ->join('sie_progress p2', 'p2.progress = ex2.progress')
            ->join('sie_enrollments e2', 'e2.enrollment = p2.enrollment')
            ->join('sie_registrations r2', 'r2.registration = e2.registration')
            ->join('sie_courses c2', 'c2.course = ex2.course')
            ->join('sie_pensums pen2', 'pen2.pensum = c2.pensum')
            ->where('r2.registration = r.registration', null, false)
            ->where('ex2.deleted_at IS NULL')
            ->where('p2.deleted_at IS NULL')
            ->where('e2.deleted_at IS NULL')
            ->where('c2.deleted_at IS NULL')
            ->where('pen2.module = pen_target.module', null, false)
            ->where('c2.status', 'ACTIVE');

        $builder->where("NOT EXISTS (" . $subquery->getCompiledSelect() . ")", null, false);

        $query = $builder->get();

        return $query->getResultArray();
    }


    /**
     * Obtiene todos los períodos académicos existentes en el sistema
     * junto con el conteo de cursos por período
     * @return array Array con períodos y total de cursos por período
     */
    public function getPeriodsWithCourseCount(): array
    {
        $this->select('period, COUNT(*) as total');
        $this->groupBy('period');
        $this->orderBy('period', "DESC");
        $results = $this->findAll();
        $periods = [];
        foreach ($results as $row) {
            $periods[] = [
                'period' => $row['period'],
                'total_courses' => (int)$row['total']
            ];
        }
        if (empty($periods)) {
            $periods[] = [
                'period' => sie_get_current_academic_period(),
                'total_courses' => 0
            ];
        }
        return $periods;
    }
}

?>