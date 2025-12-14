<?php

namespace App\Models;

use Config\Services;

/**
 * @Copilot Siempre que en el código se cree una variable llamada $mclients, esta deberá ser igualada a  model('App\Modules\Application\Models\Application_Clients_Modules');
 * @Instruction $mclients = model('App\Modules\Application\Models\Application_Clients_Modules');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Application_Clients_Modules extends CachedModel
{
    protected $table = "application_clients_modules";
    protected $primaryKey = "authorization";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "authorization",
        "client",
        "module",
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
    protected $DBGroup = "default";
    protected $version = '1.0.5';
    protected $cache_time = 60;

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        //$this->exec_Migrate();
    }

    /**
     * Ejecuta las migraciones para el módulo actual.
     * @return void
     */
    private function exec_Migrate(): void
    {
        $migrations = Services::migrations();
        try {
            $migrations->setNamespace('App\Modules\Application');// Set the namespace for the current module
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
            ->like("authorization", "%{$search}%")
            ->orLike("client", "%{$search}%")
            ->orLike("module", "%{$search}%")
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
    public function get_Authorization($authorization): false|array
    {
        $result = parent::get_Cached($authorization);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Retorna si el cliente tiene o no autorizacion para acceder al modulo utilizando caché.
     * @param string $client nombre del cliente al que desea acceder
     * @param string $module nombre del módulo al que se desea acceder
     * @return string "authorized" o "noauthorized"
     */
    public function get_CachedAuthorizedClientByModule(string $client, string $module): string
    {
        $conditions = ['client' => $client, 'module' => $module];
        $key = $this->getSearchCacheKey($conditions, 1, 0, 'created_at DESC', 1);
        $cache = $this->readCache($key);
        if ($cache === null) {
            $cache = $this->get_AuthorizedClientByModule($client, $module);
            $this->saveCache($key, $cache);
        }
        return $cache;
    }

    /**
     * Obtiene el listado de módulos autorizados para un cliente específico, incluyendo información adicional de la
     * tabla `application_modules`como alias, título y descripción. Este método realiza un `JOIN` entre las tablas
     * `application_clients_modules` y `application_modules` para combinar los datos relevantes de ambas tablas.
     * @param string $client El identificador único del cliente para el cual se desean obtener los módulos autorizados.
     * @return array|false Retorna un arreglo con los módulos autorizados y su información adicional, o `false`
     * si no se encuentran registros.
     * Nota: El groupBy("application_clients_modules.module"): Agrupa los resultados por el campo module de la tabla
     * application_clients_modules, asegurando que cada módulo aparezca solo una vez por cliente.
     **/
    public function getAuthorizedModulesByClient($client): array|false
    {
        $result = $this
            ->select("application_modules.alias, application_modules.title, application_modules.description, application_modules.icon_light, application_modules.icon_dark, application_clients_modules.*")
            ->join("application_modules", "application_clients_modules.module = application_modules.module")
            ->where("application_clients_modules.client", $client)
            ->groupBy("application_clients_modules.module") // Agrupa por el módulo para evitar duplicados
            ->orderBy("application_clients_modules.created_at", "DESC")
            ->find();
        if (is_array($result)) {
            return $result;
        } else {
            return(false);
        }
    }

    /**
     * Obtiene los módulos autorizados para un cliente específico desde la caché. Si los datos no están en caché, los
     * recupera de la base de datos utilizando el método `getAuthorizedModulesByClient` y los almacena en la caché.
     * @param string $client El identificador único del cliente para el cual se desean obtener los módulos autorizados.
     * @return array|false Retorna un arreglo con los módulos autorizados si existen, o `false` si no se encuentran registros.
     */
    public function getCachedAuthorizedModulesByClient($client): array|false
    {
        $key = $this->getCacheKey($client);
        $cache = $this->readCache($key);
        if ($cache === null) {
            $cache = $this->getAuthorizedModulesByClient($client);
            if ($cache !== false) {
                $this->saveCache($key, $cache);
            }
        }
        return $cache;
    }

    /**
     * Retorna si el cliente tiene o no autorizacion para acceder al modulo.
     * @param $client
     * @param $module
     * @return string
     */
    public function get_AuthorizedClientByModule($client, $module): string
    {
        //echo("client: {$client} module: {$module}");
        $result = $this
            ->where("client", $client)
            ->where("module", $module)
            ->orderBy("created_at", "DESC")
            ->first();
        if (is_array($result)) {
            return ("authorized");
        } else {
            return ("noauthorized");
        }
    }


}

?>
