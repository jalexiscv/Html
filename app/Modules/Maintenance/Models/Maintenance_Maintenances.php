<?php

namespace App\Modules\Maintenance\Models;

use App\Models\CachedModel;
use Higgs\Model;
use Config\Database;
use InvalidArgumentException;

/**
 * @Copilot Siempre que en el código se cree una variable llamada $mmaintenances, esta deberá ser igualada a  model('App\Modules\Maintenance\Models\Maintenance_Maintenances');
 * @Instruction $mmaintenances = model('App\Modules\Maintenance\Models\Maintenance_Maintenances');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Maintenance_Maintenances extends CachedModel
{
    protected $table = "maintenance_maintenances";
    protected $primaryKey = "maintenance";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "maintenance",
        "asset",
        "type",
        "scheduled",
        "execution",
        "responsible",
        "status",
        "description",
        "created_at",
        "updated_at",
        "deleted_at",
        "author",
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
            $migrations->setNamespace('App\Modules\Maintenance');// Set the namespace for the current module
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
            ->like("maintenance", "%{$search}%")
            ->orLike("asset", "%{$search}%")
            ->orLike("type", "%{$search}%")
            ->orLike("scheduled", "%{$search}%")
            ->orLike("execution", "%{$search}%")
            ->orLike("responsible", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->orLike("description", "%{$search}%")
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
    public function getMaintenance($maintenance): false|array
    {
        $result = parent::getCached($maintenance);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }


    /**
     * Busca en la constante MAINTENANCE_TYPES el tipo recibido y devuelve su etiqueta asociada.
     * Si no se encuentra el tipo, devuelve un valor por defecto.
     * @param string $type El tipo de mantenimiento a buscar su etiqueta.
     * @return string La etiqueta asociada al tipo de mantenimiento.
     */
    public function getLabelType($type): string
    {

        // Buscar en la constante MAINTENANCE_TYPES el tipo recibido
        foreach (MAINTENANCES_TYPES as $maintenanceType) {
            if ($maintenanceType['value'] === $type) {
                return $maintenanceType['label'];
            }
        }

        // Si no se encuentra el tipo, retornar un valor por defecto
        return ("Tipo no encontrado: {$type}");
    }


    /**
     * Busca en la constante MAINTENANCE_STATUSES el estado recibido y devuelve su etiqueta asociada.
     * Si no se encuentra el estado, devuelve un valor por defecto.
     * @param string $status El estado de mantenimiento a buscar su etiqueta.
     * @return string La etiqueta asociada al estado de mantenimiento.
     */
    public function getLabelStatus(string $status): string
    {
        foreach (MAINTENANCES_STATUSES as $maintenanceStatus) {
            if ($maintenanceStatus['value'] === $status) {
                return $maintenanceStatus['label'];
            }
        }
        return ("Estado no encontrado: {$status}");
    }



    public function getGrid(int $limit, int $offset, string $field, string $search = ""): array|false
    {
        if (!empty($search)) {
            $searchTerms = explode(' ', trim($search));
            $this->groupStart();
            foreach ($searchTerms as $term) {
                // Para cada término, crear un grupo de condiciones
                $this->groupStart()
                    ->like("maintenance", "%{$term}%")
                    ->orLike("asset", "%{$term}%")
                    ->orLike("type", "%{$term}%")
                    ->orLike("scheduled", "%{$term}%")
                    ->orLike("execution", "%{$term}%")
                    ->orLike("responsible", "%{$term}%")
                    ->orLike("status", "%{$term}%")
                    ->orLike("description", "%{$term}%")
                    ->orLike("author", "%{$term}%")
                    ->groupEnd();
            }
            $this->groupEnd();
        }else{

        }

        $result = $this->orderBy("created_at", "DESC")->findAll($limit, $offset);
        return is_array($result) ? $result : false;
    }

    public function getGridCount(string $search = ""): int
    {
        if (!empty($search)) {
            $searchTerms = explode(' ', trim($search));
            $this->groupStart();
            foreach ($searchTerms as $term) {
                // Para cada término, crear un grupo de condiciones
                $this->groupStart()
                    ->like("maintenance", "%{$term}%")
                    ->orLike("asset", "%{$term}%")
                    ->orLike("type", "%{$term}%")
                    ->orLike("scheduled", "%{$term}%")
                    ->orLike("execution", "%{$term}%")
                    ->orLike("responsible", "%{$term}%")
                    ->orLike("status", "%{$term}%")
                    ->orLike("description", "%{$term}%")
                    ->orLike("author", "%{$term}%")
                    ->groupEnd();
            }
            $this->groupEnd();
        }
        return $this->countAllResults();
    }



}

?>