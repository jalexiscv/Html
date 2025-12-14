<?php

namespace App\Models;

/**
 * @method where(string $string, $alias)
 */
class Application_Modules extends CachedModel
{
    protected $table = "application_modules";
    protected $primaryKey = "module";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "module",
        "alias",
        "title",
        "description",
        "icon_light",
        "icon_dark",
        "date",
        "time",
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
    protected $DBGroup = "default";//default
    protected $version = '2.0.4';
    protected $cache_time = 18000;

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
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
            ->like("module", "%{$search}%")
            ->orLike("alias", "%{$search}%")
            ->orLike("title", "%{$search}%")
            ->orLike("description", "%{$search}%")
            ->orLike("date", "%{$search}%")
            ->orLike("time", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->orderBy("alias", "ASC")
            ->findAll($limit, $offset);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Retorna el listado de elementos existentes de forma que se pueda cargar un field tipo select.
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
     * Retorna el ID de un modulo especifico, consultandolo por su alias, si el modulo no existe y el parametro
     * $autoregister es verdadero, se crea un nuevo modulo con el alias especificado.
     * @param $alias
     * @param $autoregister
     * @return false|mixed
     */
    public function get_Module($alias, $autoregister = false)
    {
        $strings = service('strings');
        $alias = $strings->get_Strtoupper($alias);
        $data = parent::get_CachedFirst(['alias' => $alias]);
        if (is_array($data) && isset($data['module'])) {
            return ($data['module']);
        } else {
            if ($autoregister) {
                return ($this->register_Module($alias));
            }
        }
        return (false);
    }

    protected function register_Module($alias)
    {
        $strings = service('strings');
        $alias = $strings->get_Strtoupper($alias);
        $data = [
            "module" => $strings->get_Strtoupper(uniqid()),
            "alias" => $alias,
            "title" => $alias . "_MODULE_TITLE",
            "description" => $alias . "_MODULE_DESCRIPTION",
            "date" => date("Y-m-d"),
            "time" => date("H:i:s"),
            "author" => "SYSTEM",
        ];
        $created = $this->insert($data);
        return ($data['module']);
    }


    /**
     * Returns the module code corresponding to the given alias using cache.
     * @param string $alias The module alias to look up
     * @return string|false The module ID if found, false otherwise
     */
    public function get_CachedModuleByAlias(string $alias): string|false
    {
        $strings = service('strings');
        $alias = $strings->get_Strtoupper($alias);
        $conditions = ['alias' => $alias];
        $key = $this->getSearchCacheKey($conditions, 1, 0, 'created_at DESC', 1);
        $cache = $this->readCache($key);
        if ($cache === null) {
            $cache = $this->get_ModuleByAlias($alias);
            $this->saveCache($key, $cache);
        }
        return ($cache);
    }


    /**
     * Return el codigo del modulo correspondiente con el alias proporsionado
     * la cadena 'null' es simbolica ya que el cache no almacena falsos ni vacios.
     * @param $alias
     * @return false|string
     */
    public function get_ModuleByAlias($alias): false|string
    {
        $strings = service('strings');
        $alias = $strings->get_Strtoupper($alias);
        $data = parent::get_CachedFirst(['alias' => $alias]);
        if (is_array($data) && isset($data['module'])) {
            return ($data['module']);
        }
        return (false);
    }

    public function _get_ModuleByAlias($alias): false|string
    {
        $module = $this->where('alias', $alias)->first();
        if (is_array($module) && isset($module['module'])) {
            return $module['module'];
        } else {
            return false;
        }
    }


    public function getAllModules()
    {
        $all=parent::findAll();
        if(is_array($all)){
            return($all);
        }
        return(false);
    }


}

?>