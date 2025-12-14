<?php

namespace App\Modules\Sie\Models;

use App\Models\CachedModel;

/**
 * Ejemplo: $mgraduations = model('App\Modules\Sie\Models\Sie_Graduations');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Sie_Graduations extends CachedModel
{
    protected $table = "sie_graduations";
    protected $primaryKey = "graduation";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "graduation",
        "city",
        "date",
        "application_type",
        "full_name",
        "document_type",
        "document_number",
        "expedition_place",
        "address",
        "phone_1",
        "email",
        "phone_2",
        "degree",
        "doc_id",
        "highschool_diploma",
        "highschool_graduation_act",
        "icfes_results",
        "saber_pro",
        "academic_clearance",
        "financial_clearance",
        "graduation_fee_receipt",
        "graduation_request",
        "admin_graduation_request",
        "ac",
        "ac_score",
        "ek",
        "ek_score",
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
        $migrations = \Config\Services::migrations();
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


    public function getSearch(array $conditions = [], int $limit = 0, int $offset = 0, string $orderBy = '', int $page = 1): array
    {
        $search = @$conditions['search'];
        if (!empty($search)) {
            $this->groupStart();
            $this->like("graduation", "%{$search}%");
            $this->orLike("city", "%{$search}%");
            $this->orLike("date", "%{$search}%");
            $this->orLike("application_type", "%{$search}%");
            $this->orLike("full_name", "%{$search}%");
            $this->orLike("document_type", "%{$search}%");
            $this->orLike("document_number", "%{$search}%");
            $this->orLike("expedition_place", "%{$search}%");
            $this->orLike("address", "%{$search}%");
            $this->orLike("phone_1", "%{$search}%");
            $this->orLike("email", "%{$search}%");
            $this->orLike("phone_2", "%{$search}%");
            $this->orLike("degree", "%{$search}%");
            $this->orLike("doc_id", "%{$search}%");
            $this->orLike("highschool_diploma", "%{$search}%");
            $this->orLike("highschool_graduation_act", "%{$search}%");
            $this->orLike("icfes_results", "%{$search}%");
            $this->orLike("saber_pro", "%{$search}%");
            $this->orLike("academic_clearance", "%{$search}%");
            $this->orLike("financial_clearance", "%{$search}%");
            $this->orLike("graduation_fee_receipt", "%{$search}%");
            $this->orLike("graduation_request", "%{$search}%");
            $this->orLike("admin_graduation_request", "%{$search}%");
            $this->orLike("ac", "%{$search}%");
            $this->orLike("ac_score", "%{$search}%");
            $this->orLike("ek", "%{$search}%");
            $this->orLike("ek_score", "%{$search}%");
            $this->orLike("author", "%{$search}%");
            $this->groupEnd();
            $data = $this
                ->orderBy($orderBy)
                ->findAll($limit, $offset);
            $sql_search = $this->getLastQuery()->getQuery();
            $totalResults = $this->countAllResults();
            $sql_count = $this->getLastQuery()->getQuery();
            $totalPages = 0;//ceil($totalResults / $limit);
            $result = [
                'data' => $data,
                'total' => $totalResults,
                'limit' => $limit,
                'offset' => $offset,
                'page' => $page,
                'totalPages' => $totalPages,
                'sql-search' => $sql_search,
                'sql-count' => $sql_count,
            ];
        } else {
            $result = $this
                ->orderBy($orderBy)
                ->findAll($limit, $offset);
            $sql_search = $this->getLastQuery()->getQuery();
            $totalResults = $this->countAllResults();
            $sql_count = $this->getLastQuery()->getQuery();
            $result = [
                'data' => $result,
                'total' => $totalResults,
                'limit' => $limit,
                'offset' => $offset,
                'page' => $page,
                'totalPages' => 0,
                'sql-search' => $sql_search,
                'sql-count' => $sql_count,
            ];
        }
        return $result;
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
            ->like("graduation", "%{$search}%")
            ->orLike("city", "%{$search}%")
            ->orLike("date", "%{$search}%")
            ->orLike("application_type", "%{$search}%")
            ->orLike("full_name", "%{$search}%")
            ->orLike("document_type", "%{$search}%")
            ->orLike("document_number", "%{$search}%")
            ->orLike("expedition_place", "%{$search}%")
            ->orLike("address", "%{$search}%")
            ->orLike("phone_1", "%{$search}%")
            ->orLike("email", "%{$search}%")
            ->orLike("phone_2", "%{$search}%")
            ->orLike("degree", "%{$search}%")
            ->orLike("doc_id", "%{$search}%")
            ->orLike("highschool_diploma", "%{$search}%")
            ->orLike("highschool_graduation_act", "%{$search}%")
            ->orLike("icfes_results", "%{$search}%")
            ->orLike("saber_pro", "%{$search}%")
            ->orLike("academic_clearance", "%{$search}%")
            ->orLike("financial_clearance", "%{$search}%")
            ->orLike("graduation_fee_receipt", "%{$search}%")
            ->orLike("graduation_request", "%{$search}%")
            ->orLike("admin_graduation_request", "%{$search}%")
            ->orLike("ac", "%{$search}%")
            ->orLike("ac_score", "%{$search}%")
            ->orLike("ek", "%{$search}%")
            ->orLike("ek_score", "%{$search}%")
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
    public function get_Graduation($graduation): false|array
    {
        $result = parent::getCached($graduation);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }
}

?>