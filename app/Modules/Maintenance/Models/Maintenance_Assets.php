<?php

namespace App\Modules\Maintenance\Models;

use App\Models\CachedModel;
use Config\Database;

/**
 * @Copilot Siempre que en el código se cree una variable llamada $massets, esta deberá ser igualada a  model('App\Modules\Maintenance\Models\Maintenance_Assets');
 * @Instruction $massets = model('App\Modules\Maintenance\Models\Maintenance_Assets');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Maintenance_Assets extends CachedModel
{
    protected $table = "maintenance_assets";
    protected $primaryKey = "asset";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'asset',
        'reference',
        'fixedcode',
        'name',
        'type',
        'status',
        'description',
        'entry_date',
        'location',
        'code',
        'brand',
        'serial_number',
        'voltage',
        'amperage',
        'frequency',
        'power',
        'model',
        'rpm',
        'operation_hours',
        'other_specifications',
        'document_type',
        'document_location',
        'equipment_function',
        'authorized_personnel',
        'observations',
        'license_plate',
        'vehicle_brand',
        'vehicle_line',
        'engine_displacement',
        'vehicle_model',
        'vehicle_class',
        'body_type',
        'doors_number',
        'engine_number',
        'serial_document',
        'chassis_number',
        'document_number',
        'tonnage_capacity',
        'city',
        'passengers',
        'document_date',
        'vehicle_function',
        'authorized_drivers',
        'maintenance_manager',
        'photo_url',
        'author',
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
            ->like("asset", "%{$search}%")
            ->orLike("name", "%{$search}%")
            ->orLike("type", "%{$search}%")
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
    public function getAsset($assets): false|array
    {
        $result = parent::getCached($assets);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    public function getGrid(int $limit, int $offset, string $field, string $search = ""): array|false
    {
        if (!empty($search)) {
            $searchTerms = explode(' ', trim($search));
            $this->groupStart();
            foreach ($searchTerms as $term) {
                // Para cada término, crear un grupo de condiciones
                $this->groupStart()
                    ->like("asset", "%{$term}%")
                    ->orLike("reference", "%{$term}%")
                    ->orLike("fixedcode", "%{$term}%")
                    ->orLike("name", "%{$term}%")
                    ->orLike("type", "%{$term}%")
                    ->orLike("status", "%{$term}%")
                    ->orLike("description", "%{$term}%")
                    ->orLike("entry_date", "%{$term}%")
                    ->orLike("location", "%{$term}%")
                    ->orLike("code", "%{$term}%")
                    ->orLike("brand", "%{$term}%")
                    ->orLike("serial_number", "%{$term}%")
                    ->orLike("voltage", "%{$term}%")
                    ->orLike("amperage", "%{$term}%")
                    ->orLike("frequency", "%{$term}%")
                    ->orLike("power", "%{$term}%")
                    ->orLike("model", "%{$term}%")
                    ->orLike("rpm", "%{$term}%")
                    ->orLike("operation_hours", "%{$term}%")
                    ->orLike("other_specifications", "%{$term}%")
                    ->orLike("document_type", "%{$term}%")
                    ->orLike("document_location", "%{$term}%")
                    ->orLike("equipment_function", "%{$term}%")
                    ->orLike("authorized_personnel", "%{$term}%")
                    ->orLike("observations", "%{$term}%")
                    ->orLike("license_plate", "%{$term}%")
                    ->orLike("vehicle_brand", "%{$term}%")
                    ->orLike("vehicle_line", "%{$term}%")
                    ->orLike("engine_displacement", "%{$term}%")
                    ->orLike("vehicle_model", "%{$term}%")
                    ->orLike("vehicle_class", "%{$term}%")
                    ->orLike("body_type", "%{$term}%")
                    ->orLike("doors_number", "%{$term}%")
                    ->orLike("engine_number", "%{$term}%")
                    ->orLike("serial_document", "%{$term}%")
                    ->orLike("chassis_number", "%{$term}%")
                    ->orLike("document_number", "%{$term}%")
                    ->orLike("tonnage_capacity", "%{$term}%")
                    ->orLike("city", "%{$term}%")
                    ->orLike("passengers", "%{$term}%")
                    ->orLike("document_date", "%{$term}%")
                    ->orLike("vehicle_function", "%{$term}%")
                    ->orLike("authorized_drivers", "%{$term}%")
                    ->orLike("maintenance_manager", "%{$term}%")
                    ->orLike("photo_url", "%{$term}%")
                    ->groupEnd();
            }
            $this->groupEnd();
        }else{

        }

        $result = $this->orderBy("created_at", "DESC")->findAll($limit, $offset);
        return is_array($result) ? $result : false;
    }

    /**
     * Busca activos con filtros y también coincidencias en la tabla maintenance_sheets
     *
     * Este método es similar a getGrid pero además busca coincidencias en el campo value
     * de la tabla maintenance_sheets relacionados con los activos a través del campo asset
     * 
     * @param int $limit El número máximo de registros a obtener
     * @param int $offset El número de registros a omitir antes de comenzar a seleccionar
     * @param string $field El campo por el cual ordenar los resultados
     * @param string $search El término de búsqueda para filtrar resultados
     * @return array|false Un arreglo de registros o false si no se encuentran registros
     */
    public function getGrid2(int $limit, int $offset, string $field, string $search = ""): array|false
    {
        $db = Database::connect($this->DBGroup);
        $builder = $db->table($this->table);
        $builder->select("{$this->table}.*");
        
        // Unir con la tabla maintenance_sheets para buscar en el campo value
        if (!empty($search)) {
            $searchTerms = explode(' ', trim($search));
            $builder->groupStart();
            
            foreach ($searchTerms as $term) {
                $builder->groupStart();
                // Búsqueda en la tabla maintenance_assets
                $builder->like("{$this->table}.asset", "%{$term}%")
                    ->orLike("{$this->table}.name", "%{$term}%")
                    ->orLike("{$this->table}.reference", "%{$term}%")
                    ->orLike("{$this->table}.fixedcode", "%{$term}%")
                    ->orLike("{$this->table}.type", "%{$term}%")
                    ->orLike("{$this->table}.status", "%{$term}%")
                    ->orLike("{$this->table}.description", "%{$term}%")
                    ->orLike("{$this->table}.entry_date", "%{$term}%")
                    ->orLike("{$this->table}.location", "%{$term}%")
                    ->orLike("{$this->table}.code", "%{$term}%")
                    ->orLike("{$this->table}.brand", "%{$term}%")
                    ->orLike("{$this->table}.serial_number", "%{$term}%")
                    ->orLike("{$this->table}.voltage", "%{$term}%")
                    ->orLike("{$this->table}.amperage", "%{$term}%")
                    ->orLike("{$this->table}.frequency", "%{$term}%")
                    ->orLike("{$this->table}.power", "%{$term}%")
                    ->orLike("{$this->table}.model", "%{$term}%")
                    ->orLike("{$this->table}.rpm", "%{$term}%")
                    ->orLike("{$this->table}.operation_hours", "%{$term}%")
                    ->orLike("{$this->table}.other_specifications", "%{$term}%")
                    ->orLike("{$this->table}.document_type", "%{$term}%")
                    ->orLike("{$this->table}.document_location", "%{$term}%")
                    ->orLike("{$this->table}.equipment_function", "%{$term}%")
                    ->orLike("{$this->table}.authorized_personnel", "%{$term}%")
                    ->orLike("{$this->table}.observations", "%{$term}%")
                    ->orLike("{$this->table}.license_plate", "%{$term}%")
                    ->orLike("{$this->table}.vehicle_brand", "%{$term}%")
                    ->orLike("{$this->table}.vehicle_line", "%{$term}%")
                    ->orLike("{$this->table}.engine_displacement", "%{$term}%")
                    ->orLike("{$this->table}.vehicle_model", "%{$term}%")
                    ->orLike("{$this->table}.vehicle_class", "%{$term}%")
                    ->orLike("{$this->table}.body_type", "%{$term}%")
                    ->orLike("{$this->table}.doors_number", "%{$term}%")
                    ->orLike("{$this->table}.engine_number", "%{$term}%")
                    ->orLike("{$this->table}.serial_document", "%{$term}%")
                    ->orLike("{$this->table}.chassis_number", "%{$term}%")
                    ->orLike("{$this->table}.document_number", "%{$term}%")
                    ->orLike("{$this->table}.tonnage_capacity", "%{$term}%")
                    ->orLike("{$this->table}.city", "%{$term}%")
                    ->orLike("{$this->table}.passengers", "%{$term}%")
                    ->orLike("{$this->table}.document_date", "%{$term}%")
                    ->orLike("{$this->table}.vehicle_function", "%{$term}%")
                    ->orLike("{$this->table}.authorized_drivers", "%{$term}%")
                    ->orLike("{$this->table}.maintenance_manager", "%{$term}%")
                    ->orLike("{$this->table}.photo_url", "%{$term}%");
                    
                $builder->groupEnd();
            }
            $builder->groupEnd();
            
            // Construcción de subconsulta para buscar en tabla maintenance_sheets
            $subQuery = $db->table('maintenance_sheets')
                        ->select('asset')
                        ->groupStart();
                        
            foreach ($searchTerms as $term) {
                $subQuery->orLike('value', "%{$term}%");
            }
            
            $subQuery->groupEnd();
            $subQuery = $subQuery->getCompiledSelect();
            
            // Incluir activos cuyos registros en maintenance_sheets coincidan con la búsqueda
            $builder->orWhere("{$this->table}.asset IN ($subQuery)", null, false);
        }
        
        $builder->where("{$this->table}.deleted_at IS NULL");
        $builder->orderBy("{$this->table}.created_at", "DESC");
        $result = $builder->get($limit, $offset)->getResultArray();
        
        return !empty($result) ? $result : false;
    }

    /**
     * Cuenta el número total de registros que coinciden con un término de búsqueda en getGrid2.
     * 
     * @param string $search El término de búsqueda para filtrar resultados
     * @return int El número total de registros que coinciden con la búsqueda
     */
    public function getGrid2Count(string $search = ""): int
    {
        $db = Database::connect($this->DBGroup);
        $builder = $db->table($this->table);
        
        // Unir con la tabla maintenance_sheets para buscar en el campo value
        if (!empty($search)) {
            $searchTerms = explode(' ', trim($search));
            $builder->groupStart();
            
            foreach ($searchTerms as $term) {
                $builder->groupStart();
                // Búsqueda en la tabla maintenance_assets
                $builder->like("{$this->table}.asset", "%{$term}%")
                    ->orLike("{$this->table}.name", "%{$term}%")
                    ->orLike("{$this->table}.type", "%{$term}%")
                    ->orLike("{$this->table}.status", "%{$term}%")
                    ->orLike("{$this->table}.description", "%{$term}%")
                    ->orLike("{$this->table}.entry_date", "%{$term}%")
                    ->orLike("{$this->table}.location", "%{$term}%")
                    ->orLike("{$this->table}.code", "%{$term}%")
                    ->orLike("{$this->table}.brand", "%{$term}%")
                    ->orLike("{$this->table}.serial_number", "%{$term}%")
                    ->orLike("{$this->table}.voltage", "%{$term}%")
                    ->orLike("{$this->table}.amperage", "%{$term}%")
                    ->orLike("{$this->table}.frequency", "%{$term}%")
                    ->orLike("{$this->table}.power", "%{$term}%")
                    ->orLike("{$this->table}.model", "%{$term}%")
                    ->orLike("{$this->table}.rpm", "%{$term}%")
                    ->orLike("{$this->table}.operation_hours", "%{$term}%")
                    ->orLike("{$this->table}.other_specifications", "%{$term}%")
                    ->orLike("{$this->table}.document_type", "%{$term}%")
                    ->orLike("{$this->table}.document_location", "%{$term}%")
                    ->orLike("{$this->table}.equipment_function", "%{$term}%")
                    ->orLike("{$this->table}.authorized_personnel", "%{$term}%")
                    ->orLike("{$this->table}.observations", "%{$term}%")
                    ->orLike("{$this->table}.license_plate", "%{$term}%")
                    ->orLike("{$this->table}.vehicle_brand", "%{$term}%")
                    ->orLike("{$this->table}.vehicle_line", "%{$term}%")
                    ->orLike("{$this->table}.engine_displacement", "%{$term}%")
                    ->orLike("{$this->table}.vehicle_model", "%{$term}%")
                    ->orLike("{$this->table}.vehicle_class", "%{$term}%")
                    ->orLike("{$this->table}.body_type", "%{$term}%")
                    ->orLike("{$this->table}.doors_number", "%{$term}%")
                    ->orLike("{$this->table}.engine_number", "%{$term}%")
                    ->orLike("{$this->table}.serial_document", "%{$term}%")
                    ->orLike("{$this->table}.chassis_number", "%{$term}%")
                    ->orLike("{$this->table}.document_number", "%{$term}%")
                    ->orLike("{$this->table}.tonnage_capacity", "%{$term}%")
                    ->orLike("{$this->table}.city", "%{$term}%")
                    ->orLike("{$this->table}.passengers", "%{$term}%")
                    ->orLike("{$this->table}.document_date", "%{$term}%")
                    ->orLike("{$this->table}.vehicle_function", "%{$term}%")
                    ->orLike("{$this->table}.authorized_drivers", "%{$term}%")
                    ->orLike("{$this->table}.maintenance_manager", "%{$term}%")
                    ->orLike("{$this->table}.photo_url", "%{$term}%");
                    
                $builder->groupEnd();
            }
            $builder->groupEnd();
            
            // Construcción de subconsulta para buscar en tabla maintenance_sheets
            $subQuery = $db->table('maintenance_sheets')
                        ->select('asset')
                        ->groupStart();
                        
            foreach ($searchTerms as $term) {
                $subQuery->orLike('value', "%{$term}%");
            }
            
            $subQuery->groupEnd();
            $subQuery = $subQuery->getCompiledSelect();
            
            // Incluir activos cuyos registros en maintenance_sheets coincidan con la búsqueda
            $builder->orWhere("{$this->table}.asset IN ($subQuery)", null, false);
        }
        
        $builder->where("{$this->table}.deleted_at IS NULL");
        return $builder->countAllResults();
    }

    public function getGridCount(string $search = ""): int
    {
        if (!empty($search)) {
            $searchTerms = explode(' ', trim($search));
            $this->groupStart();
            foreach ($searchTerms as $term) {
                // Para cada término, crear un grupo de condiciones
                $this->groupStart()
                    ->like("asset", "%{$term}%")
                    ->orLike("name", "%{$term}%")
                    ->orLike("type", "%{$term}%")
                    ->orLike("status", "%{$term}%")
                    ->orLike("description", "%{$term}%")
                    ->orLike("entry_date", "%{$term}%")
                    ->orLike("location", "%{$term}%")
                    ->orLike("code", "%{$term}%")
                    ->orLike("brand", "%{$term}%")
                    ->orLike("serial_number", "%{$term}%")
                    ->orLike("voltage", "%{$term}%")
                    ->orLike("amperage", "%{$term}%")
                    ->orLike("frequency", "%{$term}%")
                    ->orLike("power", "%{$term}%")
                    ->orLike("model", "%{$term}%")
                    ->orLike("rpm", "%{$term}%")
                    ->orLike("operation_hours", "%{$term}%")
                    ->orLike("other_specifications", "%{$term}%")
                    ->orLike("document_type", "%{$term}%")
                    ->orLike("document_location", "%{$term}%")
                    ->orLike("equipment_function", "%{$term}%")
                    ->orLike("authorized_personnel", "%{$term}%")
                    ->orLike("observations", "%{$term}%")
                    ->orLike("license_plate", "%{$term}%")
                    ->orLike("vehicle_brand", "%{$term}%")
                    ->orLike("vehicle_line", "%{$term}%")
                    ->orLike("engine_displacement", "%{$term}%")
                    ->orLike("vehicle_model", "%{$term}%")
                    ->orLike("vehicle_class", "%{$term}%")
                    ->orLike("body_type", "%{$term}%")
                    ->orLike("doors_number", "%{$term}%")
                    ->orLike("engine_number", "%{$term}%")
                    ->orLike("serial_document", "%{$term}%")
                    ->orLike("chassis_number", "%{$term}%")
                    ->orLike("document_number", "%{$term}%")
                    ->orLike("tonnage_capacity", "%{$term}%")
                    ->orLike("city", "%{$term}%")
                    ->orLike("passengers", "%{$term}%")
                    ->orLike("document_date", "%{$term}%")
                    ->orLike("vehicle_function", "%{$term}%")
                    ->orLike("authorized_drivers", "%{$term}%")
                    ->orLike("maintenance_manager", "%{$term}%")
                    ->orLike("photo_url", "%{$term}%")
                    ->groupEnd();
            }
            $this->groupEnd();
        }
        return $this->countAllResults();
    }
}