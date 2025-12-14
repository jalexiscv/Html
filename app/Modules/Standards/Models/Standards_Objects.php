<?php

namespace App\Modules\Standards\Models;

use App\Models\CachedModel;

/**
 * @Copilot Siempre que en el código se cree una variable llamada $mobjects, esta deberá ser igualada a  model('App\Modules\Standards\Models\Standards_Objects');
 * @Instruction $mobjects = model('App\Modules\Standards\Models\Standards_Objects');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Standards_Objects extends CachedModel
{
    protected $table = "standards_objects";
    protected $primaryKey = "object";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "object",
        "name",
        "category",
        "parent",
        "weight",
        'description',
        "attributes",
        "value",
        "evaluation",
        "type_content",
        "type_node",
        "attachments",
        "author",
        "created_at",
        "updated_at",
        "deleted_at"
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
            $migrations->setNamespace('App\Modules\Standards');// Set the namespace for the current module
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
            ->like("object", "%{$search}%")
            ->orLike("name", "%{$search}%")
            ->orLike("category", "%{$search}%")
            ->orLike("parent", "%{$search}%")
            ->orLike("attributes", "%{$search}%")
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
    public function get_Object($object): false|array
    {
        $result = $this->where("object", $object)->first();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function getObject($object): false|array
    {
        $result = $this->where("object", $object)->first();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Determina si el objeto es el último en la línea de herencia,
     * es decir, que ningún otro objeto lo tiene como padre.
     * @param string $object ID del objeto a evaluar
     * @return bool Verdadero si no tiene hijos, falso si tiene al menos uno
     */
    public function isLastInLine($object): bool
    {
        $count = $this->where('parent', $object)->countAllResults();
        return ($count === 0);
    }


    /**
     * Recalcula el valor del objeto actual como el promedio de los valores
     * de sus hijos directos. Cada hijo conserva su valor.
     *
     * @param string $objectId ID del objeto a recalcular (padre)
     * @return bool Verdadero si se actualizó, falso si no fue necesario o no tiene hijos.
     */
    public function recalculate(string $objectId): bool
    {
        // Obtener hijos directos
        $children = $this->where('parent', $objectId)->findAll();

        if (empty($children)) {
            return false;
        }

        $sum = 0.0;
        $count = 0;

        foreach ($children as $child) {
            $val = isset($child['value']) && is_numeric($child['value']) ? floatval($child['value']) : 0.0;
            $sum += $val;
            $count++;
        }

        if ($count === 0) {
            return false;
        }

        $average = $sum / $count;

        // Actualizar solo el nodo actual
        return $this->update($objectId, ['value' => $average]);
    }




    /**
     * Propaga recálculo de valores desde el objeto dado hacia arriba en la jerarquía.
     * Asegura que cada padre se actualice en cascada según sus hijos.
     *
     * @param string $objectId El objeto desde donde iniciar la propagación (puede ser un hijo o intermedio)
     * @return void
     */
    public function propagateChangesFrom(string $objectId): void
    {
        $currentId = $objectId;
        while ($currentId) {
            $this->recalculate($currentId); // Asegura que recalcula el nodo actual primero
            $current = $this->find($currentId);
            $currentId = $current['parent'] ?? null;
        }
    }


















































}

?>