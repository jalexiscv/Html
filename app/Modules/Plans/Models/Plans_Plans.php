<?php

namespace App\Modules\Plans\Models;

use App\Models\CachedModel;
use Config\Services;

/**
 * @Copilot Siempre que en el código se cree una variable llamada $mplans, esta deberá ser igualada a  model('App\Modules\Plans\Models\Plans_Plans');
 * @Instruction $mplans = model('App\Modules\Plans\Models\Plans_Plans');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method getCachedFirst(array $conditions): array|object|null
 * @method getCachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Plans_Plans extends CachedModel
{
    protected $table = "plans_plans";
    protected $primaryKey = "plan";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "plan",
        "module",
        "reference",
        "plan_institutional",
        "activity",
        "manager",
        "manager_subprocess",
        "manager_position",
        "order",
        "description",
        "formulation",
        "score",
        "value",
        "start",
        "end",
        "evaluation",
        "status",
        "status_approval",
        "status_approval_date",
        "status_approval_time",
        "status_approve",
        "status_approve_date",
        "status_approve_time",
        "status_evaluate",
        "status_evaluate_date",
        "status_evaluate_time",
        "status_evaluation",
        "status_evaluation_date",
        "status_evaluation_time",
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
            $migrations->setNamespace('App\Modules\Plans');// Set the namespace for the current module
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
        $row = parent::get_CachedFirst([$this->primaryKey => $id]);
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
            ->like("plan", "%{$search}%")
            ->orLike("module", "%{$search}%")
            ->orLike("reference", "%{$search}%")
            ->orLike("plan_institutional", "%{$search}%")
            ->orLike("activity", "%{$search}%")
            ->orLike("manager", "%{$search}%")
            ->orLike("manager_subprocess", "%{$search}%")
            ->orLike("manager_position", "%{$search}%")
            ->orLike("order", "%{$search}%")
            ->orLike("description", "%{$search}%")
            ->orLike("formulation", "%{$search}%")
            ->orLike("value", "%{$search}%")
            ->orLike("start", "%{$search}%")
            ->orLike("end", "%{$search}%")
            ->orLike("evaluation", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->orLike("status_approval", "%{$search}%")
            ->orLike("status_approval_date", "%{$search}%")
            ->orLike("status_approval_time", "%{$search}%")
            ->orLike("status_approve", "%{$search}%")
            ->orLike("status_approve_date", "%{$search}%")
            ->orLike("status_approve_time", "%{$search}%")
            ->orLike("status_evaluate", "%{$search}%")
            ->orLike("status_evaluate_date", "%{$search}%")
            ->orLike("status_evaluate_time", "%{$search}%")
            ->orLike("status_evaluation", "%{$search}%")
            ->orLike("status_evaluation_date", "%{$search}%")
            ->orLike("status_evaluation_time", "%{$search}%")
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
    public function getPlan($plan): false|array
    {
        $result = parent::getCached($plan);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Obtiene el siguiente número de boleto disponible.
     *
     * @return int El siguiente número de boleto disponible.
     */
    public function get_NextPlanNumber(): int
    {
        // Consulta el valor máximo del campo "number"
        $query = $this->selectMax('order')->get();
        $result = $query->getRowArray();
        $maxNumber = $result['order'];
        $nextNumber = $maxNumber + 1;
        return $nextNumber;
    }


}

?>