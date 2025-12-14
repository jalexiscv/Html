<?php

namespace App\Modules\Sie\Models;

use App\Models\CachedModel;
use Config\Services;

/**
 * Ej: $mobservations = model('App\Modules\Sie\Models\Sie_Observations');
 * @method where(mixed $primaryKey, string $id) : \Higgs\Database\BaseBuilder
 * @method groupStart() : \Higgs\Database\BaseBuilder
 */
class Sie_Observations extends CachedModel
{
    protected $table = "sie_observations";
    protected $primaryKey = "observation";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "observation",
        "object",
        "type",
        "content",
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
            ->like("observation", "%{$search}%")
            ->orLike("object", "%{$search}%")
            ->orLike("type", "%{$search}%")
            ->orLike("content", "%{$search}%")
            ->orLike("date", "%{$search}%")
            ->orLike("time", "%{$search}%")
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
     * Obtiene una lista de registros con un rango especificado y opcionalmente filtrados por un término de búsqueda.
     * con opciones de filtrado y paginación.
     * @param int $limit El número máximo de registros a obtener por página.
     * @param int $offset El número de registros a omitir antes de comenzar a seleccionar.
     * @param array $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return array|false        Un arreglo de registros combinados o false si no se encuentran registros.
     */
    public function get_Observations(int $limit, int $offset, array $search): array|false
    {
        $object = $search["object"];
        $author = !empty($search["author"]) ?? "";
        if (!empty($author)) {
            //echo("<br>AUTHOR: ".$author);
            $result = $this
                ->where("object", $object)
                ->where("author", $author)
                ->orderBy("created_at", "DESC")
                ->findAll($limit, $offset);
        } else {
            $result = $this
                ->where("object", $object)
                ->orderBy("created_at", "DESC")
                ->findAll($limit, $offset);
        }
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
     * @param $observation
     * @return array|false
     */
    public function get_Observation($observation): false|array
    {
        $result = parent::find($observation);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }


    /**
     * Retrieves the count of items associated with a specific author from the given object.
     * @param mixed $object The object containing items to be evaluated.
     * @param string $author The author whose associated items are to be counted.
     * @return int The number of items associated with the specified author.
     */
    public function getCountByAuthorInObject($object, $author): int
    {
        return $this->where('object', $object)
            ->where('author', $author)
            ->countAllResults();
    }
    
    
    
    
    
    
}

?>