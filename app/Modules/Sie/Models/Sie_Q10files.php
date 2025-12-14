<?php

namespace App\Modules\Sie\Models;

use App\Models\CachedModel;
use Config\Services;

/**
 * Ejemplo: $mq10files = model('App\Modules\Sie\Models\Sie_Q10files');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Sie_Q10files extends CachedModel
{
    protected $table = "sie_q10files";
    protected $primaryKey = "file";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "file",
        "attachment",
        "identification",
        "reference",
        "type",
        "description",
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
            ->like("file", "%{$search}%")
            ->orLike("attachment", "%{$search}%")
            ->orLike("identification", "%{$search}%")
            ->orLike("reference", "%{$search}%")
            ->orLike("type", "%{$search}%")
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


    public function getSearch(array $conditions = [], int $limit = 0, int $offset = 0, string $orderBy = '', int $page = 1): array
    {
        $search = @$conditions['search'];
        if (!empty($search)) {
            $this->groupStart();
            $this->like("file", "%{$search}%");
            $this->orLike("attachment", "%{$search}%");
            $this->orLike("identification", "%{$search}%");
            $this->orLike("reference", "%{$search}%");
            $this->orLike("type", "%{$search}%");
            $this->orLike("description", "%{$search}%");
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
     * Obtiene la clave de caché para un identificador dado.
     * @param $product
     * @return array|false
     */
    public function get_File($file): false|array
    {
        $result = parent::find($file);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }


    /**
     * Este metodo obtiene el listado de archivos adjuntando los del attachment
     * SELECT
     * `sie_q10files`.`file` AS `file`,
     * `storage_attachments`.`attachment` AS `attachment`,
     * `storage_attachments`.`size` AS `size`,
     * `storage_attachments`.`file` AS `uri`
     * FROM
     * `sie_q10files`
     * INNER JOIN `storage_attachments` ON `sie_q10files`.`file` =
     * `storage_attachments`.`object`
     */
    public function get_FilesAndAttachments(int $limit, int $offset, string $search = ""): array|false
    {
        $result = $this
            ->select("`sie_q10files`.`file` AS `file`,`sie_q10files`.`reference` AS `reference`,`storage_attachments`.`attachment` AS `attachment`,`storage_attachments`.`size` AS `size`,`storage_attachments`.`file` AS `uri`")
            ->join("storage_attachments", "`sie_q10files`.`file` = `storage_attachments`.`object`")
            ->where("sie_q10files.deleted_at", null)
            ->groupStart()
            ->like("sie_q10files.file", "%{$search}%")
            ->orLike("sie_q10files.attachment", "%{$search}%")
            ->orLike("sie_q10files.identification", "%{$search}%")
            ->orLike("sie_q10files.reference", "%{$search}%")
            ->orLike("sie_q10files.type", "%{$search}%")
            ->orLike("sie_q10files.description", "%{$search}%")
            ->orLike("sie_q10files.author", "%{$search}%")
            ->orLike("storage_attachments.file", "%{$search}%")
            ->groupEnd()
            ->orderBy("sie_q10files.created_at", "DESC")
            ->findAll($limit, $offset);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


}

?>