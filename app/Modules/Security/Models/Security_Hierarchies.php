<?php

namespace App\Modules\Security\Models;

use Higgs\Model;

/**
 * Class Security_Hierarchies
 *
 * Modelo para gestionar las jerarquías de seguridad (relaciones usuario-rol).
 * Proporciona métodos para crear, leer, actualizar y eliminar jerarquías,
 * con un uso extensivo de caché para optimizar el rendimiento.
 * Ej: $mhierarchies = model('App\Modules\Security\Models\Security_Hierarchies');
 * @package App\Modules\Security\Models
 * @version 1.0.0
 */
class Security_Hierarchies extends Model
{

    protected $table = "security_hierarchies";
    protected $primaryKey = "hierarchy";
    protected $returnType = "array";
    protected $useSoftDeletes = false;
    protected $allowedFields = ["hierarchy", "user", "rol", "author"];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication";
    protected $cache_time = 60;
    protected $version = "1.0.0";


    /**
     * Retorna todos los roles desempeñados por un usuario desde la caché o la base de datos.
     *
     * @param string|null $user El ID del usuario.
     * @return \Higgs\Cache\CacheInterface|array|mixed Los datos de las jerarquías del usuario.
     */
    public function getHierarchiesByUser($user = null)
    {
        $cache_key = $this->get_CacheKey("hierarchies-{$user}");
        if (!$data = cache($cache_key)) {
            $data = $this->where('user', $user)->findAll();
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return $data;
    }

    /**
     * Genera una clave de caché única y consistente para un ID dado.
     *
     * @param string|array $id Identificador para la clave de caché.
     * @return string La clave de caché en formato MD5.
     */
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
     * Asigna un rol a un usuario y limpia la caché de jerarquías para ese usuario.
     *
     * @param string $user El ID del usuario.
     * @param string $rol El ID del rol.
     * @return void
     */
    public function set_Hierarchy($user, $rol)
    {
        $this->insert(array(
            "hierarchy" => pk(),
            "user" => $user,
            "rol" => $rol,
            "author" => safe_get_user(),
        ));
        $cache_key = $this->get_CacheKey("hierarchies-{$user}");
        cache()->delete($cache_key);
    }

    /**
     * Inserta un nuevo registro y lo guarda en caché.
     *
     * @param array|null $data Los datos a insertar.
     * @param bool       $returnID Si debe devolver el ID del registro insertado.
     * @return mixed El resultado de la inserción.
     */
    public function insert($data = null, bool $returnID = true)
    {
        $result = parent::insert($data, $returnID);
        if ($result === true || $returnID && is_numeric($result)) {
            $insertID = $returnID ? $this->db->insertID() : $data[$this->primaryKey];
            $cache_key = $this->get_CacheKey($insertID);
            $data = parent::find($insertID);
            cache()->save($cache_key, $data, $this->cache_time);
        }

        return $result;
    }

    /**
     * Busca un registro por su ID, utilizando la caché para acelerar la consulta.
     *
     * @param int|string|null $id El ID del registro a buscar.
     * @return mixed El registro encontrado o null.
     */
    public function find($id = null)
    {
        $cache_key = $this->get_CacheKey($id);
        if (!$data = cache($cache_key)) {
            $data = parent::find($id);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return $data;
    }

    /**
     * Elimina un registro por su ID y limpia la entrada correspondiente en la caché.
     *
     * @param int|string|null $id El ID del registro a eliminar.
     * @param bool            $purge Si se debe realizar un borrado permanente (en caso de soft deletes).
     * @return bool El resultado de la operación de borrado.
     */
    public function delete($id = null, $purge = false)
    {
        $result = parent::delete($id, $purge);
        if ($result === true) {
            cache()->delete($this->get_CacheKey($id));
        }
        return ($result);
    }

    /**
     * Elimina una relación específica de jerarquía (usuario-rol) y limpia la caché del usuario.
     *
     * @param string|null $user El ID del usuario.
     * @param string|null $rol El ID del rol.
     * @return void
     */
    public function delete_Hierarchy($user = null, $rol = null)
    {
        $this->where('user', $user)->where('rol', $rol)->delete();
        $cache_key = $this->get_CacheKey("hierarchies-{$user}");
        cache()->delete($cache_key);
    }

    /**
     * Elimina todas las jerarquías (roles) asociadas a un usuario.
     *
     * @param string $user El ID del usuario cuyas jerarquías se eliminarán.
     * @return bool True si se eliminaron filas, false en caso contrario.
     */
    public function delete_AllByUser($user)
    {
        $row = $this->where("user", $user)->delete();
        if ($row) {
            return (true);
        } else {
            return (false);
        }
    }

    /**
     * Actualiza un registro por su ID y actualiza la entrada correspondiente en la caché.
     *
     * @param int|string|null $id El ID del registro a actualizar.
     * @param array|null      $data Los nuevos datos para el registro.
     * @return bool El resultado de la operación de actualización.
     */
    public function update($id = null, $data = null): bool
    {
        $result = parent::update($id, $data);

        if ($result === true) {
            $cache_key = $this->get_CacheKey($id);
            $data = parent::find($id);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($result);
    }

    /**
     * Verifica si una tabla existe en la base de datos, utilizando caché para el resultado.
     *
     * @param string $tableName El nombre de la tabla a verificar.
     * @return \Higgs\Cache\CacheInterface|bool|mixed True si la tabla existe, false en caso contrario.
     */
    private function tableExists($tableName)
    {
        $cache_key = '_table_exist_' . APPNODE . '_' . $this->table;
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($tableName);
            cache()->save($cache_key, $data, $this->cache_time * 1000);
        }
        return ($data);
    }

}

?>