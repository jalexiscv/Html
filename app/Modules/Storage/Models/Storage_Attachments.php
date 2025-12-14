<?php

namespace App\Modules\Storage\Models;

use Higgs\Model;
use Config\Database;

/**
 * $mattachments = model('App\Modules\Storage\Models\Storage_Attachments');
 * @method where(mixed $primaryKey, string $id) : \Higgs\Database\BaseBuilder
 * @method groupStart() : \Higgs\Database\BaseBuilder
 */
class Storage_Attachments extends Model
{
    protected $table = "storage_attachments";
    protected $primaryKey = "attachment";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "attachment",
        "module",
        "path",
        "service",
        "object",
        "file",
        "type",
        "date",
        "time",
        "alt",
        "title",
        "size",
        "reference",
        "author",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    protected $beforeFind = ['_exec_BeforeFind'];
    protected $afterFind = ['_exec_FindCache'];
    protected $afterInsert = ['_exec_UpdateCache'];
    protected $afterUpdate = ['_exec_UpdateCache'];
    protected $afterDelete = ['_exec_DeleteCache'];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication";//default
    protected $version = '1.0.0';
    protected $cache_time = 60;
    protected $cache;

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        $this->exec_TableRegenerate();
    }

    /**
     * Regenera o recrea la tabla de la base de datos en caso de que esta no exista
     * Ejemplo de campos
     * $fields = [
     *      'id'=> ['type'=>'INT','constraint'=> 5,'unsigned'=> true,'auto_increment' => true],
     *      'title'=>['type'=> 'VARCHAR','constraint'=>'100','unique'  => true,],
     *      'author'=>['type'=>'VARCHAR','constraint'=> 100,'default'=> 'King of Town',],
     *      'description'=>['type'=>'TEXT','null'=>true,],
     *      'status'=>['type'=>'ENUM','constraint'=>['publish','pending','draft'],'default'=>'pending',],
     *   ];
     */
    private function exec_TableRegenerate()
    {
        if (!$this->get_TableExist()) {
            $forge = Database::forge($this->DBGroup);
            $fields = [
                'attachment' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'module' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'path' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'service' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'object' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'type' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'date' => ['type' => 'DATE', 'null' => FALSE],
                'time' => ['type' => 'TIME', 'null' => FALSE],
                'alt' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'size' => ['type' => 'VARCHAR', 'constraint' => 11, 'null' => FALSE],
                'reference' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => FALSE],
                'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'created_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'updated_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE],
            ];
            $forge->addField($fields);
            $forge->addPrimaryKey($this->primaryKey);
//$forge->addKey('post');
//$forge->addKey('profile');
            $forge->addKey('author');
            $forge->createTable($this->table, TRUE);
        }
    }

    /**
     * Este método verifica si la tabla especificada existe en la base de datos utilizando la función tableExists()
     * del objeto db de Higgs. Además, utiliza la caché para almacenar el resultado de la verificación para mejorar
     * el rendimiento y evitar la sobrecarga de la base de datos. La clave de caché se crea utilizando el método
     * get_CacheKey(), que se supone que retorna una clave única para la tabla especificada. El tiempo de duración de
     * la caché se establece en el atributo $cache_time.
     * @return bool Devuelve true si la tabla existe, false en caso contrario.
     */
    private function get_TableExist(): bool
    {
        $cache_key = $this->get_CacheKey($this->table);
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($this->table);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return $data;
    }

    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param mixed $id Identificador único para el objeto en caché.
     * @return string Clave de caché generada para el identificador.
     **/
    protected function get_CacheKey($id)
    {
        $id = is_array($id) ? implode("", $id) : $id;
        $node = APPNODE;
        $table = $this->table;
        $class = urlencode(get_class($this));
        $version = $this->version;
        $key = "{$node}-{$table}-{$class}-{$version}-{$id}";
        return md5($key);
    }

    public function get_CountAllResults($search = "")
    {
        if (!empty($search)) {
            $result = $this
                ->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')
                ->select('cadastre_customers.*, cadastre_profiles.*')
                ->groupStart()
                ->like("cadastre_customers.customer", "%{$search}%")
                ->orLike("cadastre_customers.registration", "%{$search}%")
                ->groupEnd()
                ->orderBy("cadastre_customers.registration", "DESC")
                ->countAllResults();
        } else {
            $result = $this
                ->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')
                ->select('cadastre_customers.*, cadastre_profiles.*')
                ->orderBy("cadastre_customers.registration", "DESC")
                ->countAllResults();
        }
        return ($result);
    }

    public function get_Avatar($user)
    {
        $cache_key = $this->get_CacheKey($user);
        if (!$data = cache($cache_key)) {
            $image = "/themes/bs5/img/avatars/avatar-neutral.png";
            $row = $this->where("object", $user)->where("reference", 'AVATAR')->orderBy('created_at', 'DESC')->first();
            $data = isset($row["file"]) ? $row["file"] : $image;
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($data);
    }


    public function get_AttachmentByObject($object)
    {
        $row = $this->where("object", $object)->orderBy('created_at', 'DESC')->first();
        if (isset($row["file"])) {
            return ($row);
        } else {
            return (false);
        }
    }

    /**
     * Retorna el listado de elementos existentes
     * un mes de un año especifico.
     * @param type $year
     * @param type $month
     */
    public function get_FileListForObject($object): array|bool
    {
        $files = $this->where("object", $object)->orderBy('attachment', 'DESC')->findAll();

        if (is_array($files)) {
            return ($files);
        } else {
            return (false);
        }
    }

    /**
     * Retorna la ruta al archivo COVER mas reciente de un objeto determinado
     * @param type $id
     * @param type $author
     */
    public function get_Cover($oid, $reference = "COVER")
    {
        $cover = $this
            ->where("object", $oid)
            ->where("reference", $reference)
            ->orderBy('date', 'DESC')
            ->orderBy('time', 'DESC')
            ->first();
        if (isset($cover["file"])) {
            return ($cover["file"]);
        } else {
            return (false);
        }
    }


    public function get_Attachment($id)
    {
        $attachment = $this->where("attachment", $id)->first();
        if (is_array($attachment)) {
            return ($attachment);
        } else {
            return (false);
        }
    }

    public function get_File($id)
    {
        $attachment = $this->where("attachment", $id)->first();
        if (is_array($attachment)) {
            return (cdn_url($attachment["file"]));
        } else {
            return ("");
        }
    }




    /**
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * autor del registro que se desea acceder, editar o eliminar.
     * @param string $id código primario del registro a consultar
     * @param string $author código del usuario del cual se pretende establecer la autoría
     * @return boolean falso o verdadero según sea el caso
     */
    public function get_Authority(string $id, string $author): bool
    {
        $key = $this->get_CacheKey("{$id}{$author}");
        $cache = cache($key);
        if (!$this->is_CacheValid($cache)) {
            $row = $this->where($this->primaryKey, $id)->first();
            if (isset($row["author"]) && $row["author"] == $author) {
                $value = true;
            } else {
                $value = false;
            }
            $cache = array('value' => $value, 'retrieved' => true);
            cache()->save($key, $cache, $this->cache_time);
        }
        return ($cache['value']);
    }

    /**
     * Método is_CacheValid
     * Este método verifica si los datos recuperados de la caché son válidos.
     * @param mixed $cache - Los datos recuperados de la caché.
     * @return bool - Devuelve true si los datos de la caché son válidos, false en caso contrario.
     */
    private function is_CacheValid(mixed $cache): bool
    {
        return is_array($cache) && array_key_exists('retrieved', $cache) && $cache['retrieved'] === true;
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
            ->like("attachment", "%{$search}%")
            ->orLike("module", "%{$search}%")
            ->orLike("path", "%{$search}%")
            ->orLike("service", "%{$search}%")
            ->orLike("object", "%{$search}%")
            ->orLike("file", "%{$search}%")
            ->orLike("type", "%{$search}%")
            ->orLike("date", "%{$search}%")
            ->orLike("time", "%{$search}%")
            ->orLike("alt", "%{$search}%")
            ->orLike("title", "%{$search}%")
            ->orLike("size", "%{$search}%")
            ->orLike("reference", "%{$search}%")
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
     * Obtiene el número total de registros que coinciden con un término de búsqueda.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int Devuelve el número total de registros que coinciden con el término de búsqueda.
     */
    function get_Total(string $search = ""): int
    {
        $result = $this
            ->groupStart()
            ->orLike("module", "%{$search}%")
            ->orLike("path", "%{$search}%")
            ->orLike("service", "%{$search}%")
            ->orLike("object", "%{$search}%")
            ->orLike("file", "%{$search}%")
            ->orLike("type", "%{$search}%")
            ->orLike("date", "%{$search}%")
            ->orLike("time", "%{$search}%")
            ->orLike("alt", "%{$search}%")
            ->orLike("title", "%{$search}%")
            ->orLike("size", "%{$search}%")
            ->orLike("reference", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->countAllResults();
        return ($result);
    }

    protected function _exec_BeforeFind(array $data)
    {
        if (isset($data['id']) && $item = $this->get_CachedItem($data['id'])) {
            $data['data'] = $item;
            $data['returnData'] = true;
            return $data;
        }
    }

    private function get_CachedItem($id)
    {
        $cacheKey = $this->get_CacheKey($id);
        $cachedData = cache($cacheKey);
        return $cachedData !== null ? $cachedData : false;
    }

    protected function _exec_FindCache(array $data)
    {
        $id = $data['id'] ?? null;
        cache()->save($this->get_CacheKey($id), $data['data'], $this->cache_time);
        return ($data);
    }

    /**
     * Implementa la lógica para actualizar la caché después de insertar o actualizar
     * Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind
     * y guardar los datos en la caché usando cache().
     * @param array $data
     * @return void
     */

    protected function _exec_UpdateCache(array $data)
    {
        $id = $data['id'] ?? null;
        if ($id !== null) {
            $updatedData = $this->find($id);
            if ($updatedData) {
                cache()->save($this->get_CacheKey($id), $updatedData, $this->cache_time);
            }
        }
    }

    /**
     * Implementa la lógica para eliminar la caché después de eliminar
     * Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind
     * para invalidar la caché.
     * @param array $data
     * @return void
     */
    protected function _exec_DeleteCache(array $data)
    {
        $id = $data['id'] ?? null;
        if ($id !== null) {
            $deletedData = $this->find($id);
            if ($deletedData) {
                cache()->delete($this->get_CacheKey($id));
            }
        }
    }
}

?>