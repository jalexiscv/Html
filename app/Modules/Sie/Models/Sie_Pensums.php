<?php

namespace App\Modules\Sie\Models;

use Config\Database;
use Higgs\Model;

/**
 * Ejemplo: $mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
 * @method where(mixed $primaryKey, string $id) : \Higgs\Database\BaseBuilder
 * @method groupStart() : \Higgs\Database\BaseBuilder
 */
class Sie_Pensums extends Model
{
    protected $table = "sie_pensums";
    protected $primaryKey = "pensum";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "pensum",
        "version",
        "module",
        "cycle",
        "level",
        "moment",
        "credits",
        "weekly_hourly_intensity",
        "monthly_hourly_intensity",
        "evaluation",
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
                'pensum' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'version' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'module' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'cycle' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'level' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'credits' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'weekly_hourly_intensity' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'monthly_hourly_intensity' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'evaluation' => ['type' => 'ENUM', 'constraint' => ['Y', 'N'], 'default' => 'N',],
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

    /**
     * Retorna el número de pensums que relacionan un determinado módulo
     * @param string $module Código del módulo a consultar
     * @return int|bool Retorna el número de pensums o false si hay error
     */
    public function getCountByModule(string $module): bool|int
    {
        $result = $this
            ->where('module', $module)
            ->countAllResults();

        return $result;
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
            ->like("pensum", "%{$search}%")
            ->orLike("version", "%{$search}%")
            ->orLike("module", "%{$search}%")
            ->orLike("cycle", "%{$search}%")
            ->orLike("level", "%{$search}%")
            ->orLike("moment", "%{$search}%")
            ->orLike("credits", "%{$search}%")
            ->orLike("weekly_hourly_intensity", "%{$search}%")
            ->orLike("monthly_hourly_intensity", "%{$search}%")
            ->orLike("evaluation", "%{$search}%")
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
    public function get_SelectData($version)
    {
        $mmodules = model('App\Modules\Sie\Models\Sie_Modules');
        $result = $this->select("`{$this->primaryKey}` AS `value`,`pensum` AS `label`,`module`")->where('version', $version)->findAll();
        if (is_array($result)) {
            foreach ($result as $key => $value) {
                $module = $mmodules->get_Module($value['module']);
                $result[$key]['label'] = "{$module['name']} - {$module['reference']}";
            }
            return ($result);
        } else {
            return (false);
        }
    }

    public function get_SelectDataReturnModule($version)
    {
        $mmodules = model('App\Modules\Sie\Models\Sie_Modules');
        $result = $this
            ->select("`module` AS `value`,`pensum` AS `label`,`module`")
            ->where('version', $version)
            ->findAll();
        if (is_array($result)) {
            foreach ($result as $key => $value) {
                $module = $mmodules->get_Module($value['module']);
                $result[$key]['label'] = "{$module['name']} - {$module['reference']}";
            }
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
            ->orLike("version", "%{$search}%")
            ->orLike("module", "%{$search}%")
            ->orLike("cycle", "%{$search}%")
            ->orLike("level", "%{$search}%")
            ->orLike("moment", "%{$search}%")
            ->orLike("credits", "%{$search}%")
            ->orLike("weekly_hourly_intensity", "%{$search}%")
            ->orLike("monthly_hourly_intensity", "%{$search}%")
            ->orLike("evaluation", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->countAllResults();
        return ($result);
    }

    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param $product
     * @return array|false
     */
    public function get_Pensum($pensum): false|array
    {
        $row = $this->where($this->primaryKey, $pensum)->first();
        if (is_array($row)) {
            $value = $row;
        } else {
            $value = false;
        }
        return ($value);
    }

    /**
     * Retorna todos los modulos pertenecientes a una malla curricular en una versión específica
     * programs -> grids -> versions -> pensums
     * literal un pemsum es un modulo dentro de una version de una malla curricular
     * @param $version
     * @return array|false
     */
    public function get_PensumsByVersion($version)
    {
        $row = $this->where('version', $version)->findAll();
        if (is_array($row)) {
            $value = $row;
        } else {
            $value = false;
        }
        return ($value);
    }

    public function get_PensumByVersionAndModule($version, $module)
    {
        $row = $this->where('version', $version)->where('module', $module)->first();
        if (is_array($row)) {
            $value = $row;
        } else {
            $value = false;
        }
        return ($value);
    }

    /**
     * Calcula la suma de créditos para un programa, malla, versión y ciclo específicos
     *
     * @param string|null $program Código del programa
     * @param string|null $grid Código de la malla
     * @param string|null $version Código de la versión
     * @param string|null $cycle Ciclo académico
     * @return int Total de créditos
     */
    public function get_CalculateCredits(?string $program = null, ?string $grid = null, ?string $version = null, ?string $cycle = null): int
    {
        $builder = $this->db->table('sie_programs p');
        $builder->select('SUM(pen.credits) as total_credits')
            ->join('sie_grids g', 'g.program = p.program')
            ->join('sie_versions v', 'v.grid = g.grid')
            ->join('sie_pensums pen', 'pen.version = v.version')
            ->where('g.deleted_at IS NULL')
            ->where('v.deleted_at IS NULL')
            ->where('pen.deleted_at IS NULL');
        // Aplicar filtros según los parámetros recibidos
        if ($program !== null) {
            $builder->where('p.program', $program);
        }
        if ($grid !== null) {
            $builder->where('g.grid', $grid);
        }
        if ($version !== null) {
            $builder->where('v.version', $version);
        }
        if ($cycle !== null) {
            $builder->where('pen.cycle', $cycle);
        }
        // Si no se especifica versión, usar la más reciente
        if ($version === null) {
            $builder->where('v.created_at = (
                SELECT MAX(v2.created_at)
                FROM sie_versions v2
                WHERE v2.grid = g.grid
                AND v2.deleted_at IS NULL
            )');
        }
        $result = $builder->get()->getRow();
        return $result ? (int)$result->total_credits : 0;
    }

    /**
     * Calcula la suma de créditos para una versión especifica
     * @param $version
     * @return int
     */
    public function get_CalculateCreditsByVersion($version)
    {
        $result = $this->select('SUM(credits) as total_credits')
            ->where('version', $version)
            ->first();
        return $result ? (int)$result['total_credits'] : 0;
    }

    /**
     * Contaviliza el total de ciclos diferentes que comparten una version especifica
     * @param $version
     * @return int
     */
    public function getTotalCyclesByVersion($version)
    {
        $result = $this->select('COUNT(DISTINCT cycle) as total_cycles')
            ->where('version', $version)
            ->first();
        return $result ? (int)$result['total_cycles'] : 0;
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