<?php

namespace App\Modules\Sie\Models;

use App\Models\CachedModel;
use Higgs\Model;
use Config\Database;

/**
 * Ejemplo: $mproducts = model('App\Modules\Sie\Models\Sie_Products');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Sie_Products extends CachedModel
{
    protected $table = "sie_products";
    protected $primaryKey = "product";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "product",
        "reference",
        "program",
        "name",
        "description",
        "status",
        "value",
        "taxes",
        "type",
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
     * Obtiene el número total de registros que coinciden con un término de búsqueda.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int Devuelve el número total de registros que coinciden con el término de búsqueda.
     */
    function get_Total(string $search = ""): int
    {
        $result = $this
            ->groupStart()
            ->orLike("reference", "%{$search}%")
            ->orLike("name", "%{$search}%")
            ->orLike("description", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->orLike("value", "%{$search}%")
            ->orLike("taxes", "%{$search}%")
            ->orLike("type", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->countAllResults();
        return ($result);
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
            ->like("product", "%{$search}%")
            ->orLike("reference", "%{$search}%")
            ->orLike("name", "%{$search}%")
            ->orLike("description", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->orLike("value", "%{$search}%")
            ->orLike("taxes", "%{$search}%")
            ->orLike("type", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->orLike("deleted_at", "%{$search}%")
            ->groupEnd()
            ->orderBy("name", "ASC")
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
        $result = $this->select("`{$this->primaryKey}` AS `value`,`name` AS `label`")
            ->orderBy("name", "ASC")
            ->findAll();
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
    public function get_Product($product): false|array
    {
        $result = parent::getCached($product);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }


    public function getProductByReference($product): false|array
    {
        $result = $this->where('reference', $product)->first();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }


}

?>