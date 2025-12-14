<?php

namespace App\Modules\Sie\Models;

use App\Models\CachedModel;

/**
 * Modelo de datos para Sie_Statuses
 * @Copilot Siempre que en el código se cree una variable llamada $mstatuses, esta deberá ser igualada a model('App\Modules\Sie\Models\Sie_Statuses');
 * @Instruction $mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Sie_Statuses extends CachedModel
{
    protected $table = "sie_statuses";
    protected $primaryKey = "status";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "status",
        "registration",
        "identification_number",
        "program",
        "grid",
        "version",
        "period",
        "moment",
        "cycle",
        "journey",
        "reference",
        "observation",
        "date",
        "time",
        "enrollment",
        "enrollment_date",
        "degree_certificate",
        "degree_folio",
        "degree_date",
        "degree_diploma",
        "degree_book",
        "degree_resolution",
        "import",
        "author",
        "locked_at",
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
        //$this->exec_Migrate();
    }


    public function getLastByRegistration($registration)
    {
        $statuses = $this->where("registration", $registration)
            ->orderBy("date,time", "DESC")
            ->findAll(2);

        if (count($statuses) === 0) {
            return false;
        }

        if (count($statuses) === 1) {
            return $statuses[0];
        }

        $lastStatus = $statuses[0];
        $previousStatus = $statuses[1];

        if (
            isset($lastStatus['reference']) && $lastStatus['reference'] === 'GRADUATED' &&
            isset($previousStatus['program']) && isset($lastStatus['program']) &&
            $lastStatus['program'] !== $previousStatus['program']
        ) {
            return $previousStatus;
        }

        return $lastStatus;
    }

    public function getLastByRegistrationAndProgram($registration, $program)
    {
        $result = $this
            ->where("registration", $registration)
            ->where("program", $program)
            ->orderBy("created_at", "DESC")
            ->first();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
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
            ->like("status", "%{$search}%")
            ->orLike("registration", "%{$search}%")
            ->orLike("program", "%{$search}%")
            ->orLike("cycle", "%{$search}%")
            ->orLike("reference", "%{$search}%")
            ->orLike("date", "%{$search}%")
            ->orLike("time", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->orLike("locked_at", "%{$search}%")
            ->groupEnd()
            ->orderBy("created_at", "DESC")
            ->findAll($limit, $offset);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
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

    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param $product
     * @return array|false
     */
    public function get_Status($status): false|array
    {
        $result = parent::getCached($status);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Retorna el último estatus asociado un registro
     * @param $registration
     * @return false|array
     */
    public function get_LastStatus($registration): false|array
    {
        $statuses = $this->where("registration", $registration)
            ->orderBy("date,time", "DESC")
            ->findAll(2);

        if (count($statuses) === 0) {
            return false;
        }

        if (count($statuses) === 1) {
            return $statuses[0];
        }

        $lastStatus = $statuses[0];
        $previousStatus = $statuses[1];

        if (
            isset($lastStatus['reference']) && $lastStatus['reference'] === 'GRADUATED' &&
            isset($previousStatus['program']) && isset($lastStatus['program']) &&
            $lastStatus['program'] !== $previousStatus['program']
        ) {
            return $previousStatus;
        }

        return $lastStatus;
    }

    public function get_StatusesAndRegistrations($period, $statusArray, $program, $limit, $offset): false|array
    {
        if (!empty($program)) {
            $statuses = $this
                ->select([
                    'sie_statuses.*',
                    'sie_statuses.period AS status_period',
                    'sie_registrations.*'
                ])
                ->join(
                    'sie_registrations',
                    'sie_statuses.registration = sie_registrations.registration'
                )
                ->where('sie_statuses.period', $period)
                ->whereIn('sie_statuses.reference', $statusArray)
                ->where('sie_statuses.program', $program)
                ->orderBy('sie_statuses.created_at', 'ASC')
                ->limit($limit, $offset)
                ->find();
        } else {
            $statuses = $this
                ->select([
                    'sie_statuses.*',
                    'sie_statuses.period AS status_period',
                    'sie_registrations.*'
                ])
                ->join(
                    'sie_registrations',
                    'sie_statuses.registration = sie_registrations.registration'
                )
                ->where('sie_statuses.period', $period)
                ->whereIn('sie_statuses.reference', $statusArray)
                ->orderBy('sie_statuses.created_at', 'ASC')
                ->limit($limit, $offset)
                ->find();
        }
        if (is_array($statuses)) {
            return ($statuses);
        } else {
            return (false);
        }
    }

    /**
     * Retorna el ultimo estado asociable con une studiante en un programa especificado
     * @param $registration
     * @return false|array
     */
    public function get_LastStatusByRegistrationByProgram($registration, $program): false|array
    {
        $result = $this
            ->where("registration", $registration)
            ->where("program", $program)
            ->orderBy("date,time", "DESC")
            ->first();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Obtiene el último estado de CANCELED o POSTPONED
     * @param $registration
     * @return false|array
     */
    public function get_LastStatusCanceledOrPostponed($registration): false|array
    {
        $result = $this
            ->where("registration", $registration)
            ->whereIn("reference", ["CANCELED", "POSTPONED"])
            ->orderBy("date,time", "DESC")
            ->first();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    public function get_LastStatusEnrolledInCurrentPeriod($registration): false|array
    {
        $currentPeriod=date('Y') . ((int)date('n') <= 6 ? 'A' : 'B');
        $result = $this
            ->where("registration", $registration)
            ->whereIn("reference", ["ENROLLED", "ENROLLED-OLD", "ENROLLED-EXT"])
            ->where("period", $currentPeriod)
            ->orderBy("date,time", "DESC")
            ->first();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }



    public function get_LastStatusEnrolled($registration): false|array
    {
        $result = $this
            ->where("registration", $registration)
            ->where("reference", "ENROLLED")
            ->orderBy("date,time", "DESC")
            ->first();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    public function get_DetailsMultiStatus(
        string $program,
        string $period,
        array  $references = ['ENROLLED', 'ENROLLED-OLD', 'ENROLLED-EXT'],
        int    $limit = 10,
        int    $offset = 0
    ): array
    {
        $this->select([
            'sie_statuses.status',
            'sie_statuses.registration AS statuses_registration',
            'sie_registrations.registration AS registration_registration',
            'sie_statuses.program',
            'sie_statuses.period AS status_period',  // Renombrada para evitar duplicación
            'sie_statuses.reference',
            'sie_statuses.grid',
            'sie_statuses.version',
            'sie_statuses.moment',
            'sie_statuses.cycle',
            'sie_statuses.author AS statuses_author',
            'sie_registrations.journey AS registration_journey',
            'sie_registrations.identification_type AS identification_type',
            'sie_registrations.identification_number AS identification_number',
            "sie_registrations.first_name",
            "sie_registrations.second_name",
            "sie_registrations.first_surname",
            "sie_registrations.second_surname",
            "sie_registrations.gender AS gender",
            "sie_registrations.birth_date AS birth_date",
            "sie_registrations.stratum AS stratum",
            "sie_registrations.email_address AS email_address",
            "sie_registrations.email_institutional AS email_institutional",
            "sie_registrations.phone AS phone",
            "sie_registrations.mobile AS mobile",
            "sie_registrations.snies_id_validation_requisite AS snies_id_validation_requisite",
            // ... otras columnas específicas de sie_registrations que necesites
            'sie_programs.program AS program_program',
            'sie_programs.name AS program_name',
            'sie_programs.snies AS program_snies',
            'sie_statuses.deleted_at AS deleted_at1',
            'MAX(sie_statuses.created_at) AS created_at1',
            'sie_programs.value',
            'sie_programs.snies',
            'sie_programs.credits AS program_credits',
            'sie_programs.education_level AS education_level',
            'sie_agreements.agreement',
            'sie_agreements.name AS agreement_name'
        ]);

        $this->join(
            'sie_registrations',
            'sie_statuses.registration = sie_registrations.registration'
        );

        $this->join(
            'sie_programs',
            'sie_statuses.program = sie_programs.program'
        );

        $this->join(
            'sie_agreements',
            'sie_registrations.agreement = sie_agreements.agreement',
            'left'
        );

        if (!empty($program) && $program != "ALL") {
            $this->where([
                'sie_statuses.program' => $program,
                'sie_statuses.period' => $period,
                'sie_statuses.deleted_at' => null
            ]);
            $this->whereIn('sie_statuses.reference', $references);
        } else {
            $this->where([
                'sie_statuses.period' => $period,
                'sie_statuses.deleted_at' => null
            ]);
            $this->whereIn('sie_statuses.reference', $references);
        }


        $this->groupBy([
            'sie_statuses.status',
            'sie_statuses.registration',
            'sie_registrations.registration',
            'sie_statuses.program',
            'sie_statuses.period',
            'sie_statuses.reference',
            'sie_statuses.grid',
            'sie_statuses.version',
            'sie_statuses.moment',
            'sie_statuses.cycle',
            'sie_programs.program',
            'sie_programs.name',
            'sie_statuses.deleted_at',
            'sie_programs.value',
            'sie_programs.snies',
            'sie_agreements.agreement',
            'sie_agreements.name'
        ]);

        // Obtener el total de resultados antes de aplicar el límite
        $totalResults = $this->countAllResults(false);

        // Aplicar paginación
        $data = $this->findAll($limit, $offset);

        // Calcular el total de páginas
        $totalPages = ceil($totalResults / $limit);

        $result = [
            'data' => $data,
            'total' => $totalResults,
            'limit' => $limit,
            'offset' => $offset,
            'page' => floor($offset / $limit) + 1,
            'totalPages' => $totalPages,
            'sql' => $this->getLastQuery()->getQuery()
        ];
        return $result;
    }

    /**
     * Obtiene los estados de inscripción con información detallada de registros, programas y convenios
     * para un programa y período específico, con paginación.
     * Ejemplo:
     * $mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
     *      Ejemplo 1: Con valores por defecto para limit y offset
     *      $results = $mstatuses->get_EnrolledDetailsByProgram('6629A4943446D', '2025A', 'ENROLLED');
     *      Ejemplo 2: Especificando limit y offset
     *      $results = $mstatuses->get_EnrolledDetailsByProgram('6629A4943446D', '2025A', 'ENROLLED', 20, 0);
     *      Ejemplo 3: Para obtener la siguiente página
     *      $results = $mstatuses->get_EnrolledDetailsByProgram('6629A4943446D', '2025A', 'ENROLLED', 20, 20);
     * @param string $program Código del programa
     * @param string $period Período académico
     * @param string $reference Referencia del estado (por defecto 'ENROLLED')
     * @param int $limit Número máximo de registros a retornar
     * @param int $offset Número de registros a saltar
     * @return array Retorna un array con los resultados de la consulta y metadata
     */
    public function get_Details(
        string $program,
        string $period,
        string $reference = 'ENROLLED',
        int    $limit = 10,
        int    $offset = 0
    ): array
    {
        $this->select([
            'sie_statuses.status',
            'sie_statuses.registration AS statuses_registration',
            'sie_registrations.registration AS registration_registration',
            'sie_statuses.program',
            'sie_statuses.period AS status_period',  // Renombrada para evitar duplicación
            'sie_statuses.reference',
            'sie_statuses.grid',
            'sie_statuses.version',
            'sie_statuses.moment',
            'sie_statuses.cycle',
            'sie_statuses.author AS statuses_author',
            'sie_registrations.journey AS registration_journey',
            'sie_registrations.identification_type AS identification_type',
            'sie_registrations.identification_number AS identification_number',
            "sie_registrations.first_name",
            "sie_registrations.second_name",
            "sie_registrations.first_surname",
            "sie_registrations.second_surname",
            "sie_registrations.gender AS gender",
            "sie_registrations.birth_date AS birth_date",
            "sie_registrations.stratum AS stratum",
            "sie_registrations.email_address AS email_address",
            "sie_registrations.email_institutional AS email_institutional",
            "sie_registrations.phone AS phone",
            "sie_registrations.mobile AS mobile",
            "sie_registrations.snies_id_validation_requisite AS snies_id_validation_requisite",
            // ... otras columnas específicas de sie_registrations que necesites
            'sie_programs.program AS program_program',
            'sie_programs.name AS program_name',
            'sie_programs.snies AS program_snies',
            'sie_statuses.deleted_at AS deleted_at1',
            'MAX(sie_statuses.created_at) AS created_at1',
            'sie_programs.value',
            'sie_programs.snies',
            'sie_programs.credits AS program_credits',
            'sie_programs.education_level AS education_level',
            'sie_agreements.agreement',
            'sie_agreements.name AS agreement_name'
        ]);

        $this->join(
            'sie_registrations',
            'sie_statuses.registration = sie_registrations.registration'
        );

        $this->join(
            'sie_programs',
            'sie_statuses.program = sie_programs.program'
        );

        $this->join(
            'sie_agreements',
            'sie_registrations.agreement = sie_agreements.agreement',
            'left'
        );

        if (!empty($program) && $program != "ALL") {
            $this->where([
                'sie_statuses.program' => $program,
                'sie_statuses.period' => $period,
                'sie_statuses.reference' => $reference,
                'sie_statuses.deleted_at' => null
            ]);
        } else {
            $this->where([
                'sie_statuses.period' => $period,
                'sie_statuses.reference' => $reference,
                'sie_statuses.deleted_at' => null,
                'sie_registrations.deleted_at' => null
            ]);
        }


        $this->groupBy([
            'sie_statuses.status',
            'sie_statuses.registration',
            'sie_registrations.registration',
            'sie_statuses.program',
            'sie_statuses.period',
            'sie_statuses.reference',
            'sie_statuses.grid',
            'sie_statuses.version',
            'sie_statuses.moment',
            'sie_statuses.cycle',
            'sie_programs.program',
            'sie_programs.name',
            'sie_statuses.deleted_at',
            'sie_programs.value',
            'sie_programs.snies',
            'sie_agreements.agreement',
            'sie_agreements.name'
        ]);

        // Obtener el total de resultados antes de aplicar el límite
        $totalResults = $this->countAllResults(false);

        // Aplicar paginación
        $data = $this->findAll($limit, $offset);

        // Calcular el total de páginas
        $totalPages = ceil($totalResults / $limit);

        $result = [
            'data' => $data,
            'total' => $totalResults,
            'limit' => $limit,
            'offset' => $offset,
            'page' => floor($offset / $limit) + 1,
            'totalPages' => $totalPages,
            'sql' => $this->getLastQuery()->getQuery()
        ];
        return $result;
    }

    /**
     * Cuenta el total de registros de estados de inscripción que coinciden con los criterios especificados
     * Ejemplos:
     *      $mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
     *      Ejemplo básico
     *      $count = $mstatuses->get_CountDetails('6629A4943446D', '2025A');
     *      Ejemplo con todos los parámetros
     *      $count = $mstatuses->get_CountDetails('6629A4943446D', '2025A', 'ENROLLED', 20, 0);
     * @param string $program Código del programa
     * @param string $period Período académico
     * @param string $reference Referencia del estado (por defecto 'ENROLLED')
     * @param int $limit Número máximo de registros a retornar
     * @param int $offset Número de registros a saltar
     * @return array Retorna un array con el conteo y metadata
     */
    public function get_CountDetails(
        string $program,
        string $period,
        string $reference = 'ENROLLED',
        int    $limit = 10,
        int    $offset = 0
    ): array
    {
        $this->select('COUNT(DISTINCT sie_statuses.status) as total_records');

        $this->join(
            'sie_registrations',
            'sie_statuses.registration = sie_registrations.registration'
        );

        $this->join(
            'sie_programs',
            'sie_statuses.program = sie_programs.program'
        );

        $this->join(
            'sie_agreements',
            'sie_registrations.agreement = sie_agreements.agreement',
            'left'
        );

        $this->where([
            'sie_statuses.program' => $program,
            'sie_statuses.period' => $period,
            'sie_statuses.reference' => $reference,
            'sie_statuses.deleted_at' => null
        ]);

        $totalResults = $this->countAllResults(false);
        $totalPages = ceil($totalResults / $limit);

        $result = [
            'total' => $totalResults,
            'limit' => $limit,
            'offset' => $offset,
            'page' => floor($offset / $limit) + 1,
            'totalPages' => $totalPages,
            'sql' => $this->getLastQuery()->getQuery()
        ];

        return ($result["total"]);
    }

    public function getSearchByRegistration(array $conditions = [], int $limit = 0, int $offset = 0, string $orderBy = '', int $page = 1): array
    {
        $registration = @$conditions['registration'];
        $search = @$conditions['search'];

        // Builder for counting
        $countBuilder = $this->builder();
        $countBuilder->where($this->deletedField, null);

        if (!empty($search) || !empty($registration)) {
            $countBuilder->where("registration", $registration);
            $countBuilder->groupStart();
            $countBuilder->like("status", "%{$search}%");
            $countBuilder->orLike("program", "%{$search}%");
            $countBuilder->orLike("cycle", "%{$search}%");
            $countBuilder->orLike("reference", "%{$search}%");
            $countBuilder->orLike("date", "%{$search}%");
            $countBuilder->orLike("time", "%{$search}%");
            $countBuilder->orLike("author", "%{$search}%");
            $countBuilder->groupEnd();
        }
        $totalResults = $countBuilder->countAllResults();

        // Builder for data
        $dataBuilder = $this->builder();
        $dataBuilder->where($this->deletedField, null);
        
        if (!empty($search) || !empty($registration)) {
            $dataBuilder->where("registration", $registration);
            $dataBuilder->groupStart();
            $dataBuilder->like("status", "%{$search}%");
            $dataBuilder->orLike("program", "%{$search}%");
            $dataBuilder->orLike("cycle", "%{$search}%");
            $dataBuilder->orLike("reference", "%{$search}%");
            $dataBuilder->orLike("date", "%{$search}%");
            $dataBuilder->orLike("time", "%{$search}%");
            $dataBuilder->orLike("author", "%{$search}%");
            $dataBuilder->groupEnd();
        }

        if (!empty($orderBy)) {
             $orders = explode(',', $orderBy);
             foreach ($orders as $order) {
                 $dataBuilder->orderBy(trim($order));
             }
        } else {
            $dataBuilder->orderBy("date,time", "DESC");
        }

        if ($limit > 0) {
            $dataBuilder->limit($limit, $offset);
        }
        
        $data = $dataBuilder->get()->getResultArray();

        // Swap logic
        if (
            count($data) > 1 &&
            isset($data[0]['reference']) && $data[0]['reference'] === 'GRADUATED' &&
            isset($data[1]['program']) && isset($data[0]['program']) &&
            $data[0]['program'] !== $data[1]['program']
        ) {
            $temp = $data[0];
            $data[0] = $data[1];
            $data[1] = $temp;
        }

        $totalPages = ($limit > 0) ? ceil($totalResults / $limit) : 1;

        $result = [
            'data' => $data,
            'total' => $totalResults,
            'limit' => $limit,
            'offset' => $offset,
            'page' => $page,
            'totalPages' => $totalPages,
            'sql' => $this->db->getLastQuery(),
        ];
        
        return ($result);
    }

    public function getSearchByRegistrationOLD(array $conditions = [], int $limit = 0, int $offset = 0, string $orderBy = '', int $page = 1): array
    {
        $registration = @$conditions['registration'];
        $search = @$conditions['search'];

        // Builder for counting
        $countBuilder = $this->builder();

        if (!empty($search) || !empty($registration)) {
            $countBuilder->where("registration", $registration);
            $countBuilder->groupStart();
            $countBuilder->like("status", "%{$search}%");
            $countBuilder->orLike("program", "%{$search}%");
            $countBuilder->orLike("cycle", "%{$search}%");
            $countBuilder->orLike("reference", "%{$search}%");
            $countBuilder->orLike("date", "%{$search}%");
            $countBuilder->orLike("time", "%{$search}%");
            $countBuilder->orLike("author", "%{$search}%");
            $countBuilder->groupEnd();
        }
        $totalResults = $countBuilder->countAllResults();

        // Builder for data
        $dataBuilder = $this->builder();
        if (!empty($search) || !empty($registration)) {
            $dataBuilder->where("registration", $registration);
            $dataBuilder->groupStart();
            $dataBuilder->like("status", "%{$search}%");
            $dataBuilder->orLike("program", "%{$search}%");
            $dataBuilder->orLike("cycle", "%{$search}%");
            $dataBuilder->orLike("reference", "%{$search}%");
            $dataBuilder->orLike("date", "%{$search}%");
            $dataBuilder->orLike("time", "%{$search}%");
            $dataBuilder->orLike("author", "%{$search}%");
            $dataBuilder->groupEnd();
        }

        if (!empty($orderBy)) {
            $orders = explode(',', $orderBy);
            foreach ($orders as $order) {
                $dataBuilder->orderBy(trim($order));
            }
        } else {
            $dataBuilder->orderBy("date,time", "DESC");
        }

        if ($limit > 0) {
            $dataBuilder->limit($limit, $offset);
        }

        $data = $dataBuilder->get()->getResultArray();

        // Swap logic
        if (
            count($data) > 1 &&
            isset($data[0]['reference']) && $data[0]['reference'] === 'GRADUATED' &&
            isset($data[1]['program']) && isset($data[0]['program']) &&
            $data[0]['program'] !== $data[1]['program']
        ) {
            $temp = $data[0];
            $data[0] = $data[1];
            $data[1] = $temp;
        }

        $totalPages = ($limit > 0) ? ceil($totalResults / $limit) : 1;

        $result = [
            'data' => $data,
            'total' => $totalResults,
            'limit' => $limit,
            'offset' => $offset,
            'page' => $page,
            'totalPages' => $totalPages,
            'sql' => $this->db->getLastQuery(),
        ];

        return ($result);
    }



    public function getSearch(array $conditions = [], int $limit = 0, int $offset = 0, string $orderBy = '', int $page = 1): array
    {
        $search = @$conditions['search'];

        // Builder para contar
        $builderCount = $this->builder();

        if (!empty($search)) {
            $builderCount->groupStart();
            $builderCount->like("status", $search);
            $builderCount->orLike("registration", $search);
            $builderCount->orLike("program", $search);
            $builderCount->orLike("cycle", $search);
            $builderCount->orLike("reference", $search);
            $builderCount->orLike("date", $search);
            $builderCount->orLike("time", $search);
            $builderCount->orLike("author", $search);
            $builderCount->groupEnd();
        }

        $totalResults = $builderCount->countAllResults();

        // Builder para datos
        $builderData = $this->builder();

        if (!empty($search)) {
            $builderData->groupStart();
            $builderData->like("status", $search);
            $builderData->orLike("registration", $search);
            $builderData->orLike("program", $search);
            $builderData->orLike("cycle", $search);
            $builderData->orLike("reference", $search);
            $builderData->orLike("date", $search);
            $builderData->orLike("time", $search);
            $builderData->orLike("author", $search);
            $builderData->groupEnd();
        }

        // Aplicar ordenamiento
        if (!empty($orderBy)) {
            $orders = explode(',', $orderBy);
            foreach ($orders as $order) {
                $builderData->orderBy(trim($order));
            }
        } else {
            // Ordenamiento personalizado:
            // 1. Primero los que NO tienen enrollment_date
            // 2. Luego por date descendente
            // 3. Finalmente por created_at descendente
            $builderData->orderBy("IF(enrollment_date IS NULL, 0, 1)", '', false);
            $builderData->orderBy("date", "DESC");
            $builderData->orderBy("created_at", "DESC");
        }

        if ($limit > 0) {
            $builderData->limit($limit, $offset);
        }

        $data = $builderData->get()->getResultArray();

        // Swap logic
        if (
            count($data) > 1 &&
            isset($data[0]['reference']) && $data[0]['reference'] === 'GRADUATED' &&
            isset($data[1]['program']) && isset($data[0]['program']) &&
            $data[0]['program'] !== $data[1]['program']
        ) {
            $temp = $data[0];
            $data[0] = $data[1];
            $data[1] = $temp;
        }

        $totalPages = ($limit > 0) ? ceil($totalResults / $limit) : 1;

        return [
            'data' => $data,
            'total' => $totalResults,
            'limit' => $limit,
            'offset' => $offset,
            'page' => $page,
            'totalPages' => $totalPages,
            'sql' => $this->db->getLastQuery(),
        ];
    }


    public function getSearchOLD(array $conditions = [], int $limit = 0, int $offset = 0, string $orderBy = '', int $page = 1): array
    {
        $search = @$conditions['search'];
        if (!empty($search)) {
            $this->groupStart();
            $this->like("status", "%{$search}%");
            $this->orLike("registration", "%{$search}%");
            $this->orLike("program", "%{$search}%");
            $this->orLike("cycle", "%{$search}%");
            $this->orLike("reference", "%{$search}%");
            $this->orLike("date", "%{$search}%");
            $this->orLike("time", "%{$search}%");
            $this->orLike("author", "%{$search}%");
            $this->groupEnd();
            $this->orderBy("created_at", "DESC");
            $data = $this->findAll($limit, $offset);
            $totalResults = $this->countAllResults();
            $totalPages = 0;//ceil($totalResults / $limit);
            $result = [
                'data' => $data,
                'total' => $totalResults,
                'limit' => $limit,
                'offset' => $offset,
                'page' => $page,
                'totalPages' => $totalPages,
                'sql' => $this->getLastQuery()->getQuery(),
            ];
        } else {
            $result = $this->findAll($limit, $offset);
            $this->orderBy("created_at", "DESC");
            $totalResults = $this->countAllResults();
            $result = [
                'data' => $result,
                'total' => $totalResults,
                'limit' => $limit,
                'offset' => $offset,
                'page' => $page,
                'totalPages' => 0,
                'sql' => $this->getLastQuery()->getQuery(),
            ];
        }
        return $result;
    }

    /**
     * Ejecuta las migraciones para el módulo actual.
     * @return void
     */
    private function exec_Migrate(): void
    {
        $migrations = \Config\Services::migrations();
        try {
            $migrations->setNamespace('App\Modules\Sie');// Set the namespace for the current module
            $migrations->latest();// Run the migrations for the current module
            $all = $migrations->findMigrations();// Find all migrations for the current module
        } catch (Throwable $e) {
            echo($e->getMessage());
        }
    }


}

?>
