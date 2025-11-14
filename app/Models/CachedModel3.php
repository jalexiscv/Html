<?php

namespace App\Models;

use Higgs\Model;
use Config\Services;
use InvalidArgumentException;

/**
 * CachedModel - Modelo Base con Sistema de Caché Inteligente
 *
 * Este modelo extiende el Model de CodeIgniter 4 y proporciona funcionalidades
 * avanzadas de caché para optimizar consultas a la base de datos.
 *
 * CARACTERÍSTICAS:
 * - Caché automático de registros individuales
 * - Caché de búsquedas con paginación
 * - Invalidación inteligente de caché
 * - Soporte para soft deletes
 * - Estadísticas de rendimiento
 * - Búsquedas personalizadas con caché
 * - Pre-carga de datos (cache warming)
 *
 * EJEMPLO DE USO:
 *
 * class UserModel extends CachedModel {
 *     protected $table = 'users';
 *     protected $primaryKey = 'id';
 *     protected $allowedFields = ['name', 'email', 'status'];
 *
 *     public function getActiveUsers() {
 *         return $this->getCachedSearch(['status' => 'active'], 20);
 *     }
 * }
 *
 * // En el controlador:
 * $userModel = new UserModel();
 * $user = $userModel->getCached(1); // Obtiene de caché o DB
 * $users = $userModel->getCachedSearch(['status' => 'active'], 20);
 *
 * @package    App\Models
 * @author     Tu Nombre
 * @version    2.0.0
 * @since      2025-10-12
 */
class CachedModel extends Model
{
    // ============================================
    // PROPIEDADES DEL MODELO BASE
    // ============================================

    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = 'default';

    // ============================================
    // PROPIEDADES DE CACHÉ
    // ============================================

    /**
     * @var \CodeIgniter\Cache\CacheInterface Instancia del servicio de caché
     */
    protected $cache;

    /**
     * @var int Tiempo de expiración de la caché en segundos (1 hora por defecto)
     */
    protected $cacheTimeout = 3600;

    /**
     * @var string Prefijo único para las claves de caché de este modelo
     */
    protected $cachePrefix = 'model_';

    /**
     * @var string Versión del modelo (cambiar para invalidar toda la caché)
     */
    protected $version = '2.0.0';

    /**
     * @var bool Habilitar o deshabilitar caché globalmente para este modelo
     */
    protected $cacheEnabled = true;

    /**
     * @var bool Flag temporal para habilitar caché en findAll()
     */
    protected bool $useFindAllCache = false;

    // ============================================
    // ESTADÍSTICAS DE CACHÉ
    // ============================================

    /**
     * @var int Contador de aciertos de caché (cache hits)
     */
    protected int $cacheHits = 0;

    /**
     * @var int Contador de fallos de caché (cache misses)
     */
    protected int $cacheMisses = 0;

    // ============================================
    // CONSTRUCTOR
    // ============================================

    /**
     * Constructor del modelo
     *
     * Inicializa el servicio de caché y configura el prefijo único
     * basado en el nombre de la clase y la versión del modelo.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->cache = Services::cache();
        $this->cachePrefix = $this->sanitizeString(get_class($this) . '_' . $this->version . '_');

        // Cargar timeout desde configuración si existe
        $config = config('Cache');
        if (isset($config->ttl)) {
            $this->setCacheTimeout($config->ttl);
        }
    }

    // ============================================
    // MÉTODOS DE CONFIGURACIÓN
    // ============================================

    /**
     * Establece el tiempo de expiración de la caché
     *
     * @param int $seconds Tiempo de expiración en segundos
     * @return self Para encadenamiento de métodos
     *
     * @example
     * $model->setCacheTimeout(7200); // 2 horas
     */
    public function setCacheTimeout(int $seconds): self
    {
        $this->cacheTimeout = max(0, $seconds);
        return $this;
    }

    /**
     * Habilita o deshabilita el sistema de caché
     *
     * @param bool $enabled True para habilitar, false para deshabilitar
     * @return self Para encadenamiento de métodos
     *
     * @example
     * $model->setCacheEnabled(false)->find(); // Sin caché
     */
    public function setCacheEnabled(bool $enabled): self
    {
        $this->cacheEnabled = $enabled;
        return $this;
    }

    /**
     * Sanitiza cadenas para usar en claves de caché
     *
     * Reemplaza caracteres problemáticos (backslashes y puntos) por guiones bajos
     *
     * @param string $input Cadena a sanitizar
     * @return string Cadena sanitizada
     */
    private function sanitizeString(string $input): string
    {
        return str_replace(['\\', '.', '/', ':'], '_', $input);
    }

    // ============================================
    // GENERACIÓN DE CLAVES DE CACHÉ
    // ============================================

    /**
     * Genera una clave de caché única para un registro individual
     *
     * @param mixed $id ID del registro (puede ser simple o compuesto)
     * @return string Clave de caché generada
     *
     * @example
     * $key = $this->getCacheKey(123);
     * // Resultado: "App_Models_UserModel_2.0.0_record_users_123"
     */
    protected function getCacheKey(mixed $id): string
    {
        $idString = is_array($id) ? md5(serialize($id)) : (string)$id;
        return $this->cachePrefix . "record_{$this->table}_{$idString}";
    }

    /**
     * Genera una clave de caché única para una búsqueda
     *
     * Incluye condiciones, límites, offset, ordenamiento y página para
     * crear una clave única que identifique esta búsqueda específica.
     *
     * @param array $conditions Condiciones de búsqueda (WHERE)
     * @param int $limit Límite de resultados
     * @param int $offset Desplazamiento
     * @param string $orderBy Ordenamiento
     * @param int $page Número de página
     * @return string Clave de caché generada
     */
    protected function getSearchCacheKey(
        array  $conditions,
        int    $limit,
        int    $offset,
        string $orderBy,
        int    $page
    ): string
    {
        $conditionsHash = md5(serialize($conditions));
        $orderByClean = $this->sanitizeString($orderBy);

        return $this->cachePrefix .
            "search_{$this->table}_{$conditionsHash}" .
            "_l{$limit}_o{$offset}_ord{$orderByClean}_p{$page}";
    }

    // ============================================
    // OPERACIONES CRUD CON CACHÉ
    // ============================================

    /**
     * Busca uno o varios registros con caché automático
     *
     * Sobrescribe el método find() del modelo base para agregar
     * funcionalidad de caché. Si se proporciona un ID, usa caché.
     *
     * @param mixed|null $id ID o array de IDs a buscar (null para todos)
     * @return array|object|null Registro(s) encontrado(s)
     *
     * @example
     * $user = $model->find(1);              // Un usuario con caché
     * $users = $model->find([1, 2, 3]);     // Múltiples usuarios
     * $all = $model->find();                // Todos (sin caché por defecto)
     */
    public function find(mixed $id = null): array|object|null
    {
        if ($id === null) {
            return parent::find();
        }

        if (is_array($id)) {
            return $this->findMultiple($id);
        }

        return $this->getCached($id);
    }

    /**
     * Obtiene un registro de la caché o base de datos
     *
     * Primero intenta obtener el registro de la caché. Si no existe,
     * lo busca en la base de datos y lo almacena en caché.
     *
     * @param mixed $id ID del registro
     * @return array|object|null Registro encontrado o null
     *
     * @example
     * $user = $model->getCached(1);
     * if ($user) {
     *     echo $user['name'];
     * }
     */
    public function getCached(mixed $id): array|object|null
    {
        if (!$this->cacheEnabled) {
            return parent::find($id);
        }

        $cacheKey = $this->getCacheKey($id);
        $cachedData = $this->cache->get($cacheKey);

        if ($cachedData !== null) {
            $this->cacheHits++;
            return $cachedData;
        }

        $this->cacheMisses++;
        $data = parent::find($id);

        if ($data !== null) {
            $this->cache->save($cacheKey, $data, $this->cacheTimeout);
        }

        return $data;
    }

    /**
     * Busca múltiples registros por sus IDs usando caché
     *
     * @param array $ids Array de IDs a buscar
     * @return array Array de registros encontrados
     */
    protected function findMultiple(array $ids): array
    {
        $result = [];

        foreach ($ids as $id) {
            $data = $this->getCached($id);
            if ($data !== null) {
                $result[] = $data;
            }
        }

        return $result;
    }

    /**
     * Inserta un nuevo registro e invalida caché de búsquedas
     *
     * @param array|object|null $data Datos a insertar
     * @param bool $returnID Si debe retornar el ID insertado
     * @return bool|int|string ID del registro insertado o false
     *
     * @example
     * $userId = $model->insert([
     *     'name' => 'Juan',
     *     'email' => 'juan@example.com'
     * ]);
     */
    public function insert($data = null, bool $returnID = true): bool|int|string
    {
        $result = parent::insert($data, $returnID);

        if ($result) {
            $this->invalidateSearchCache();
            return $returnID ? $this->getInsertID() : true;
        }

        return false;
    }

    /**
     * Actualiza un registro e invalida su caché
     *
     * @param mixed|null $id ID del registro a actualizar
     * @param array|null $data Datos a actualizar
     * @return bool True si se actualizó correctamente
     *
     * @example
     * $model->update(1, ['name' => 'Juan Actualizado']);
     */
    public function update($id = null, $data = null): bool
    {
        $result = parent::update($id, $data);

        if ($result) {
            $this->invalidateCache($id);
            $this->invalidateSearchCache();
        }

        return $result;
    }

    /**
     * Elimina un registro e invalida su caché
     *
     * @param mixed|null $id ID del registro a eliminar
     * @param bool $purge Si debe eliminar permanentemente (ignorar soft delete)
     * @return bool True si se eliminó correctamente
     *
     * @example
     * $model->delete(1);        // Soft delete
     * $model->delete(1, true);  // Eliminación permanente
     */
    public function delete($id = null, bool $purge = false): bool
    {
        $result = parent::delete($id, $purge);

        if ($result) {
            $this->invalidateCache($id);
            $this->invalidateSearchCache();
        }

        return $result;
    }

    // ============================================
    // BÚSQUEDAS AVANZADAS CON CACHÉ
    // ============================================

    /**
     * Realiza una búsqueda con caché y paginación
     *
     * Búsqueda completa con soporte para condiciones, límites, ordenamiento
     * y paginación. Los resultados incluyen metadata de paginación.
     *
     * @param array $conditions Condiciones WHERE como array asociativo
     * @param int $limit Límite de resultados por página (0 = sin límite)
     * @param int $offset Desplazamiento para paginación
     * @param string $orderBy Ordenamiento (ej: "created_at DESC")
     * @param int $page Número de página actual
     * @return array Array con datos y metadata de paginación
     *
     * @example
     * // Búsqueda simple
     * $result = $model->getCachedSearch(['status' => 'active'], 20);
     *
     * // Con paginación
     * $result = $model->getCachedSearch(
     *     ['status' => 'active', 'role' => 'admin'],
     *     20,
     *     0,
     *     'created_at DESC',
     *     1
     * );
     *
     * echo "Total: " . $result['total'];
     * foreach ($result['data'] as $row) {
     *     echo $row['name'];
     * }
     */
    public function getCachedSearch(
        array  $conditions = [],
        int    $limit = 0,
        int    $offset = 0,
        string $orderBy = '',
        int    $page = 1
    ): array
    {
        if (!$this->cacheEnabled) {
            return $this->executeSearch($conditions, $limit, $offset, $orderBy, $page);
        }

        $cacheKey = $this->getSearchCacheKey($conditions, $limit, $offset, $orderBy, $page);
        $cachedData = $this->cache->get($cacheKey);

        if ($cachedData !== null) {
            $this->cacheHits++;
            return $cachedData;
        }

        $this->cacheMisses++;
        $result = $this->executeSearch($conditions, $limit, $offset, $orderBy, $page);

        $this->cache->save($cacheKey, $result, $this->cacheTimeout);
        $this->registerSearchKey($cacheKey);

        return $result;
    }

    /**
     * Ejecuta la búsqueda en la base de datos
     *
     * Método interno que realiza la consulta real sin considerar caché.
     *
     * @param array $conditions Condiciones de búsqueda
     * @param int $limit Límite de resultados
     * @param int $offset Desplazamiento
     * @param string $orderBy Ordenamiento
     * @param int $page Número de página
     * @return array Resultados con metadata
     */
    protected function executeSearch(
        array  $conditions,
        int    $limit,
        int    $offset,
        string $orderBy,
        int    $page
    ): array
    {
        $builder = $this->builder();

        // Aplicar soft deletes si está habilitado
        if ($this->useSoftDeletes && !empty($this->deletedField)) {
            $builder->where($this->deletedField . ' IS NULL');
        }

        // Aplicar condiciones
        if (!empty($conditions)) {
            $builder->where($conditions);
        }

        // Aplicar ordenamiento con validación
        if (!empty($orderBy)) {
            $this->validateOrderBy($orderBy);
            $builder->orderBy($orderBy);
        }

        // Obtener total de resultados antes del límite
        $totalResults = $builder->countAllResults(false);

        // Aplicar límite y offset
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }

        $data = $builder->get()->getResultArray();
        $totalPages = $limit > 0 ? (int)ceil($totalResults / $limit) : 1;

        return [
            'data' => $data,
            'total' => $totalResults,
            'limit' => $limit,
            'offset' => $offset,
            'page' => $page,
            'totalPages' => $totalPages,
            'hasNextPage' => $page < $totalPages,
            'hasPrevPage' => $page > 1,
            'sql' => $this->db->getLastQuery()->getQuery()
        ];
    }

    /**
     * Obtiene el primer registro que coincida con las condiciones
     *
     * Equivalente a WHERE + LIMIT 1 con caché.
     *
     * @param array $conditions Condiciones de búsqueda
     * @return array|object|null Primer registro encontrado o null
     *
     * @example
     * $user = $model->getCachedFirst(['email' => 'juan@example.com']);
     * if ($user) {
     *     echo "Usuario encontrado: " . $user['name'];
     * }
     */
    public function getCachedFirst(array $conditions): array|object|null
    {
        if (!$this->cacheEnabled) {
            return $this->where($conditions)->first();
        }

        $cacheKey = $this->getSearchCacheKey($conditions, 1, 0, '', 1);
        $cachedData = $this->cache->get($cacheKey);

        if ($cachedData !== null) {
            $this->cacheHits++;
            return $cachedData;
        }

        $this->cacheMisses++;
        $data = $this->where($conditions)->first();

        if ($data !== null) {
            $this->cache->save($cacheKey, $data, $this->cacheTimeout);
        }

        return $data;
    }

    /**
     * Ejecuta una consulta personalizada con caché
     *
     * Permite construir consultas complejas usando un callback
     * y cachear el resultado.
     *
     * @param callable $queryBuilder Función que recibe el builder
     * @param string $cacheKeySuffix Sufijo único para la clave de caché
     * @param bool $single Si debe retornar un solo resultado
     * @return mixed Resultado de la consulta
     *
     * @example
     * $users = $model->getCachedCustomQuery(
     *     function($builder) {
     *         $builder->select('users.*, roles.name as role_name')
     *                 ->join('roles', 'roles.id = users.role_id')
     *                 ->where('users.status', 'active')
     *                 ->orderBy('users.created_at', 'DESC');
     *     },
     *     'active_users_with_roles'
     * );
     */
    public function getCachedCustomQuery(
        callable $queryBuilder,
        string   $cacheKeySuffix = '',
        bool     $single = false
    ): mixed
    {
        if (!$this->cacheEnabled) {
            $builder = $this->builder();
            $queryBuilder($builder);
            return $single ? $builder->get()->getRowArray() :
                $builder->get()->getResultArray();
        }

        $cacheKey = $this->cachePrefix .
            "custom_{$this->table}_" .
            md5($cacheKeySuffix . ($single ? '_single' : '_multi'));

        $cachedData = $this->cache->get($cacheKey);

        if ($cachedData !== null) {
            $this->cacheHits++;
            return $cachedData;
        }

        $this->cacheMisses++;
        $builder = $this->builder();
        $queryBuilder($builder);

        $data = $single ? $builder->get()->getRowArray() :
            $builder->get()->getResultArray();

        if ($data !== null) {
            $this->cache->save($cacheKey, $data, $this->cacheTimeout);
        }

        return $data;
    }

    /**
     * Sobrescribe findAll() para agregar caché opcional
     *
     * IMPORTANTE: Solo usa caché si se llama explícitamente con useCacheForFindAll(true)
     * Por defecto NO usa caché para mantener compatibilidad con CI4
     *
     * @param int $limit Límite de resultados
     * @param int $offset Offset para paginación
     * @return array Resultados encontrados
     *
     * @example
     * // Sin caché (comportamiento por defecto)
     * $users = $model->where('status', 'active')->findAll();
     *
     * // Con caché (explícito)
     * $users = $model->useCacheForFindAll(true)
     *                ->where('status', 'active')
     *                ->findAll();
     */
    public function findAll(int $limit = 0, int $offset = 0): array
    {
        if (!$this->useFindAllCache) {
            return parent::findAll($limit, $offset);
        }

        // Generar clave basada en el builder actual
        $builderState = $this->captureBuilderState();
        $cacheKey = $this->cachePrefix .
            "findAll_{$this->table}_" .
            $builderState . "_{$limit}_{$offset}";

        $cachedData = $this->cache->get($cacheKey);

        if ($cachedData !== null) {
            $this->cacheHits++;
            $this->useFindAllCache = false; // Reset flag
            return $cachedData;
        }

        $this->cacheMisses++;
        $data = parent::findAll($limit, $offset);

        if (!empty($data)) {
            $this->cache->save($cacheKey, $data, $this->cacheTimeout);
        }

        $this->useFindAllCache = false; // Reset flag
        return $data;
    }

    /**
     * Captura el estado actual del query builder
     * Incluye WHERE, JOIN, ORDER BY, etc.
     *
     * NOTA: Debido a que las propiedades del builder son protegidas,
     * usamos getCompiledSelect() para generar una representación única
     * de la consulta que sirve como clave de caché.
     *
     * @return string Hash del estado del builder
     */
    protected function captureBuilderState(): string
    {
        $builder = $this->builder();

        try {
            // Obtener la query compilada sin ejecutarla (false = no reset)
            $compiledQuery = $builder->getCompiledSelect(false);
            return md5($compiledQuery);
        } catch (\Exception $e) {
            // Si falla, usar una combinación de tabla y timestamp
            return md5($this->table . microtime(true));
        }
    }

    /**
     * Habilita caché para la próxima llamada a findAll()
     *
     * @param bool $use True para usar caché en el próximo findAll()
     * @return self Para encadenamiento
     *
     * @example
     * $users = $model->useCacheForFindAll(true)
     *                ->join('roles', 'roles.id = users.role_id')
     *                ->where('status', 'active')
     *                ->findAll();
     */
    public function useCacheForFindAll(bool $use = true): self
    {
        $this->useFindAllCache = $use;
        return $this;
    }

    /**
     * Método auxiliar para queries con JOIN que necesitan caché
     * Wrapper simplificado de getCachedCustomQuery
     *
     * @param string $select Campos a seleccionar
     * @param array $joins Array de joins [['table', 'condition', 'type']]
     * @param array $conditions Condiciones WHERE
     * @param string $orderBy Ordenamiento
     * @param int $limit Límite de resultados
     * @return array Resultados
     *
     * @example
     * $users = $model->getCachedWithJoins(
     *     'users.*, roles.name as role_name, departments.name as dept_name',
     *     [
     *         ['roles', 'roles.id = users.role_id', 'left'],
     *         ['departments', 'departments.id = users.department_id', 'left']
     *     ],
     *     ['users.status' => 'active'],
     *     'users.created_at DESC',
     *     50
     * );
     */
    public function getCachedWithJoins(
        string $select,
        array  $joins,
        array  $conditions = [],
        string $orderBy = '',
        int    $limit = 0
    ): array
    {
        $cacheKeySuffix = md5($select . serialize($joins) . serialize($conditions) . $orderBy . $limit);

        return $this->getCachedCustomQuery(
            function ($builder) use ($select, $joins, $conditions, $orderBy, $limit) {
                $builder->select($select);

                foreach ($joins as $join) {
                    $table = $join[0] ?? '';
                    $condition = $join[1] ?? '';
                    $type = $join[2] ?? 'left';

                    if ($table && $condition) {
                        $builder->join($table, $condition, $type);
                    }
                }

                if (!empty($conditions)) {
                    $builder->where($conditions);
                }

                if (!empty($orderBy)) {
                    $builder->orderBy($orderBy);
                }

                if ($limit > 0) {
                    $builder->limit($limit);
                }
            },
            $cacheKeySuffix
        );
    }

    /**
     * Invalida caché de consultas personalizadas
     *
     * @param string $cacheKeySuffix Sufijo usado en getCachedCustomQuery
     * @return void
     */
    public function invalidateCustomQueryCache(string $cacheKeySuffix): void
    {
        $cacheKey = $this->cachePrefix . "custom_{$this->table}_" . md5($cacheKeySuffix . '_multi');
        $this->cache->delete($cacheKey);

        $cacheKeySingle = $this->cachePrefix . "custom_{$this->table}_" . md5($cacheKeySuffix . '_single');
        $this->cache->delete($cacheKeySingle);
    }

    /**
     * Obtiene el conteo total de resultados con caché
     *
     * @param array $conditions Condiciones de filtrado
     * @return int Número total de registros
     *
     * @example
     * $totalUsers = $model->getCountAllResults(['status' => 'active']);
     */
    public function getCountAllResults(array $conditions = []): int
    {
        if (!$this->cacheEnabled) {
            return empty($conditions) ?
                $this->countAllResults() :
                $this->where($conditions)->countAllResults();
        }

        $cacheKey = $this->getSearchCacheKey($conditions, 0, 0, 'count', 1);
        $cachedCount = $this->cache->get($cacheKey);

        if ($cachedCount !== null && is_numeric($cachedCount)) {
            $this->cacheHits++;
            return (int)$cachedCount;
        }

        $this->cacheMisses++;
        $count = empty($conditions) ?
            $this->countAllResults() :
            $this->where($conditions)->countAllResults();

        $this->cache->save($cacheKey, $count, $this->cacheTimeout);

        return $count;
    }

    // ============================================
    // INVALIDACIÓN DE CACHÉ
    // ============================================

    /**
     * Invalida la caché de un registro específico
     *
     * @param mixed $id ID del registro
     * @return void
     */
    protected function invalidateCache(mixed $id): void
    {
        $cacheKey = $this->getCacheKey($id);
        $this->cache->delete($cacheKey);
    }

    /**
     * Invalida toda la caché de búsquedas del modelo
     *
     * Utiliza un índice de claves si está disponible para invalidación eficiente.
     *
     * @return void
     */
    public function invalidateSearchCache(): void
    {
        // Opción 1: Usar deleteMatching si el driver lo soporta (Redis, Memcached)
        if (method_exists($this->cache, 'deleteMatching')) {
            $pattern = $this->cachePrefix . "search_{$this->table}_*";
            $this->cache->deleteMatching($pattern);
            return;
        }

        // Opción 2: Usar índice de claves
        $indexKey = $this->cachePrefix . "search_index_{$this->table}";
        $searchKeys = $this->cache->get($indexKey);

        if (is_array($searchKeys)) {
            foreach ($searchKeys as $key) {
                $this->cache->delete($key);
            }
        }

        $this->cache->delete($indexKey);
    }

    /**
     * Registra una clave de búsqueda en el índice
     *
     * Permite invalidación eficiente de búsquedas sin iterar toda la caché.
     *
     * @param string $cacheKey Clave a registrar
     * @return void
     */
    protected function registerSearchKey(string $cacheKey): void
    {
        $indexKey = $this->cachePrefix . "search_index_{$this->table}";
        $searchKeys = $this->cache->get($indexKey) ?? [];

        if (!in_array($cacheKey, $searchKeys, true)) {
            $searchKeys[] = $cacheKey;
            $this->cache->save($indexKey, $searchKeys, $this->cacheTimeout);
        }
    }

    /**
     * Refresca la caché de un registro específico
     *
     * Invalida la caché actual y vuelve a cargar desde la base de datos.
     *
     * @param mixed $id ID del registro
     * @return array|object|null Registro actualizado
     *
     * @example
     * $user = $model->refreshCache(1);
     */
    public function refreshCache(mixed $id): array|object|null
    {
        $this->invalidateCache($id);
        return $this->getCached($id);
    }

    /**
     * Limpia toda la caché (usar con precaución)
     *
     * **ADVERTENCIA**: Limpia TODA la caché del sistema, no solo de este modelo.
     * Usar solo en desarrollo o cuando sea absolutamente necesario.
     *
     * @return void
     */
    public function clearAllCache(): void
    {
        $this->cache->clean();
    }

    // ============================================
    // UTILIDADES Y VALIDACIÓN
    // ============================================

    /**
     * Valida la cadena de ordenamiento para prevenir SQL injection
     *
     * Verifica que los campos especificados en ORDER BY estén en allowedFields.
     *
     * @param string $orderBy Cadena de ordenamiento a validar
     * @throws InvalidArgumentException Si el ordenamiento no es válido
     *
     * @example
     * $this->validateOrderBy('created_at DESC, name ASC');
     */
    public function validateOrderBy(string $orderBy): void
    {
        if (empty($this->allowedFields)) {
            throw new InvalidArgumentException(
                'Debe definir $allowedFields en su modelo para usar ORDER BY'
            );
        }

        $orderFields = explode(',', $orderBy);

        foreach ($orderFields as $field) {
            $field = trim($field);

            // Permitir formato: campo ASC|DESC o tabla.campo ASC|DESC
            if (preg_match('/^(\w+\.)?(\w+)\s+(ASC|DESC)$/i', $field, $matches)) {
                $fieldName = $matches[2];

                if (!in_array($fieldName, $this->allowedFields, true)) {
                    throw new InvalidArgumentException(
                        "Campo de ordenamiento no permitido: '{$fieldName}'"
                    );
                }
            } else {
                throw new InvalidArgumentException(
                    "Formato de ordenamiento inválido: '{$field}'. " .
                    "Use: 'campo ASC' o 'campo DESC'"
                );
            }
        }
    }

    /**
     * Verifica si el usuario actual es el autor de un registro
     *
     * Útil para validar permisos de edición/eliminación.
     *
     * @param mixed $id ID del registro
     * @param mixed $author ID del autor a verificar
     * @return bool True si el autor coincide
     *
     * @example
     * if ($model->getAuthority($postId, session('user_id'))) {
     *     // Permitir edición
     * }
     */
    public function getAuthority(mixed $id, mixed $author): bool
    {
        $record = $this->getCachedFirst([$this->primaryKey => $id]);

        return isset($record['author']) && $record['author'] == $author;
    }

    // ============================================
    // PRE-CARGA Y OPTIMIZACIÓN
    // ============================================

    /**
     * Pre-carga registros en la caché (cache warming)
     *
     * Útil para cargar datos frecuentemente accedidos al iniciar la aplicación
     * o después de limpiar la caché.
     *
     * @param array $ids IDs de registros individuales a pre-cargar
     * @param array $commonSearches Búsquedas comunes a pre-cargar
     * @return void
     *
     * @example
     * $model->warmCache(
     *     [1, 2, 3, 4, 5], // IDs de usuarios más accedidos
     *     [
     *         ['conditions' => ['status' => 'active'], 'limit' => 20],
     *         ['conditions' => ['role' => 'admin'], 'limit' => 10]
     *     ]
     * );
     */
    public function warmCache(array $ids = [], array $commonSearches = []): void
    {
        // Pre-cargar registros individuales
        foreach ($ids as $id) {
            $this->getCached($id);
        }

        // Pre-cargar búsquedas comunes
        foreach ($commonSearches as $search) {
            $this->getCachedSearch(
                $search['conditions'] ?? [],
                $search['limit'] ?? 0,
                $search['offset'] ?? 0,
                $search['orderBy'] ?? '',
                $search['page'] ?? 1
            );
        }
    }

    // ============================================
    // ESTADÍSTICAS Y MONITOREO
    // ============================================

    /**
     * Obtiene estadísticas de rendimiento de la caché
     *
     * @return array<string, int|float|string> Array con hits, misses y ratio
     *
     * @example
     * $stats = $model->getCacheStats();
     * echo "Cache Hit Ratio: {$stats['ratio']}%";
     * echo "Hits: {$stats['hits']}, Misses: {$stats['misses']}";
     */
    public function getCacheStats(): array
    {
        $total = $this->cacheHits + $this->cacheMisses;

        if ($total > 0) {
            $percentage = ($this->cacheHits / $total) * 100;
            $ratio = round($percentage, 2, PHP_ROUND_HALF_UP);
            $efficiency = $this->cacheHits > $this->cacheMisses ? 'Excellent' : 'Poor';
        } else {
            $ratio = 0.0;
            $efficiency = 'N/A';
        }

        return [
            'hits' => $this->cacheHits,
            'misses' => $this->cacheMisses,
            'total' => $total,
            'ratio' => $ratio,
            'efficiency' => $efficiency
        ];
    }

    /**
     * Reinicia los contadores de estadísticas
     *
     * @return void
     */
    public function resetCacheStats(): void
    {
        $this->cacheHits = 0;
        $this->cacheMisses = 0;
    }

    // ============================================
    // MÉTODOS DE CACHÉ DIRECTOS
    // ============================================

    /**
     * Guarda un valor directamente en la caché
     *
     * @param string $key Clave de la caché
     * @param mixed $data Datos a guardar
     * @param int|null $ttl Tiempo de vida (opcional, usa el del modelo por defecto)
     * @return bool True si se guardó correctamente
     *
     * @example
     * $model->saveCache('user_preferences_1', $preferences, 7200);
     */
    public function saveCache(string $key, mixed $data, ?int $ttl = null): bool
    {
        if ($data === null) {
            return false;
        }

        $timeout = $ttl ?? $this->cacheTimeout;
        return $this->cache->save($key, $data, $timeout);
    }

    /**
     * Lee un valor directamente de la caché
     *
     * @param string $key Clave de la caché
     * @return mixed Datos almacenados o null si no existen
     *
     * @example
     * $preferences = $model->readCache('user_preferences_1');
     */
    public function readCache(string $key): mixed
    {
        return $this->cache->get($key);
    }

    /**
     * Elimina una clave específica de la caché
     *
     * @param string $key Clave a eliminar
     * @return bool True si se eliminó correctamente
     */
    public function deleteCache(string $key): bool
    {
        return $this->cache->delete($key);
    }

    // ============================================
    // MÉTODOS DEPRECADOS (RETROCOMPATIBILIDAD)
    // ============================================

    /**
     * @deprecated 2.0.0 Use getCachedSearch() instead
     */
    public function get_CachedSearch(
        array  $conditions = [],
        int    $limit = 0,
        int    $offset = 0,
        string $orderBy = '',
        int    $page = 1
    ): array
    {
        return $this->getCachedSearch($conditions, $limit, $offset, $orderBy, $page);
    }

    /**
     * @deprecated 2.0.0 Use getCacheKey() instead
     */
    protected function get_CacheKey(mixed $id): string
    {
        return $this->getCacheKey($id);
    }

    /**
     * @deprecated 2.0.0 Use invalidateCache() instead
     */
    protected function invalidate_Cache(mixed $id): void
    {
        $this->invalidateCache($id);
    }

    /**
     * @deprecated 2.0.0 Use refreshCache() instead
     */
    public function refresh_Cache(mixed $id): array|object|null
    {
        return $this->refreshCache($id);
    }

    /**
     * @deprecated 2.0.0 Use getCachedFirst() instead
     */
    public function get_CachedFirst(array $conditions): array|object|null
    {
        return $this->getCachedFirst($conditions);
    }

    /**
     * @deprecated 2.0.0 Use getCountAllResults() instead
     */
    public function get_CountAllResults(array $conditions = []): int
    {
        return $this->getCountAllResults($conditions);
    }

    /**
     * @deprecated 2.0.0 Use invalidateSearchCache() instead
     */
    public function invalidate_SearchCache(): void
    {
        $this->invalidateSearchCache();
    }

    /**
     * @deprecated 2.0.0 Use clearAllCache() instead
     */
    public function clear_AllCache(): void
    {
        $this->clearAllCache();
    }

    /**
     * @deprecated 2.0.0 Use readCache() instead
     */
    public function get_Cached($key): mixed
    {
        return $this->readCache($key);
    }
}

// ============================================
// EJEMPLOS DE USO
// ============================================

/**
 * EJEMPLO 1: Modelo Básico de Usuarios
 *
 * <?php
 * namespace App\Models;
 *
 * class UserModel extends CachedModel
 * {
 *     protected $table = 'users';
 *     protected $primaryKey = 'id';
 *     protected $allowedFields = ['name', 'email', 'password', 'status', 'role_id'];
 *
 *     public function __construct()
 *     {
 *         parent::__construct();
 *         $this->setCacheTimeout(7200); // 2 horas para usuarios
 *     }
 *
 *     // Método personalizado con caché
 *     public function getActiveUsers(int $limit = 20): array
 *     {
 *         return $this->getCachedSearch(
 *             ['status' => 'active'],
 *             $limit,
 *             0,
 *             'created_at DESC'
 *         );
 *     }
 *
 *     // Búsqueda por email con caché
 *     public function findByEmail(string $email): ?array
 *     {
 *         return $this->getCachedFirst(['email' => $email]);
 *     }
 *
 *     // Usuarios por rol con caché
 *     public function getUsersByRole(int $roleId, int $page = 1): array
 *     {
 *         $limit = 20;
 *         $offset = ($page - 1) * $limit;
 *
 *         return $this->getCachedSearch(
 *             ['role_id' => $roleId, 'status' => 'active'],
 *             $limit,
 *             $offset,
 *             'name ASC',
 *             $page
 *         );
 *     }
 * }
 * ?>
 */

/**
 * EJEMPLO 2: Uso en Controlador
 *
 * <?php
 * namespace App\Controllers;
 *
 * use App\Models\UserModel;
 *
 * class UserController extends BaseController
 * {
 *     protected $userModel;
 *
 *     public function __construct()
 *     {
 *         $this->userModel = new UserModel();
 *     }
 *
 *     // Listar usuarios con paginación y caché
 *     public function index()
 *     {
 *         $page = $this->request->getGet('page') ?? 1;
 *
 *         $result = $this->userModel->getCachedSearch(
 *             ['status' => 'active'],
 *             20, // 20 usuarios por página
 *             ($page - 1) * 20,
 *             'created_at DESC',
 *             $page
 *         );
 *
 *         return view('users/index', [
 *             'users' => $result['data'],
 *             'pagination' => [
 *                 'currentPage' => $result['page'],
 *                 'totalPages' => $result['totalPages'],
 *                 'total' => $result['total']
 *             ]
 *         ]);
 *     }
 *
 *     // Ver perfil de usuario (con caché)
 *     public function show($id)
 *     {
 *         $user = $this->userModel->getCached($id);
 *
 *         if (!$user) {
 *             return redirect()->back()->with('error', 'Usuario no encontrado');
 *         }
 *
 *         return view('users/show', ['user' => $user]);
 *     }
 *
 *     // Actualizar usuario (invalida caché automáticamente)
 *     public function update($id)
 *     {
 *         $data = $this->request->getPost();
 *
 *         if ($this->userModel->update($id, $data)) {
 *             // La caché se invalida automáticamente
 *             return redirect()->to("/users/$id")->with('success', 'Usuario actualizado');
 *         }
 *
 *         return redirect()->back()->with('error', 'Error al actualizar');
 *     }
 *
 *     // Búsqueda con filtros múltiples
 *     public function search()
 *     {
 *         $filters = [
 *             'status' => $this->request->getGet('status'),
 *             'role_id' => $this->request->getGet('role')
 *         ];
 *
 *         // Remover filtros vacíos
 *         $filters = array_filter($filters);
 *
 *         $result = $this->userModel->getCachedSearch($filters, 20);
 *
 *         return $this->response->setJSON($result);
 *     }
 *
 *     // Ver estadísticas de caché
 *     public function cacheStats()
 *     {
 *         // Hacer algunas consultas
 *         $this->userModel->getCached(1);
 *         $this->userModel->getCached(1); // Hit
 *         $this->userModel->getCached(2);
 *
 *         $stats = $this->userModel->getCacheStats();
 *
 *         return $this->response->setJSON($stats);
 *     }
 * }
 * ?>
 */

/**
 * EJEMPLO 3: Búsquedas Complejas con Joins
 *
 * <?php
 * namespace App\Models;
 *
 * class PostModel extends CachedModel
 * {
 *     protected $table = 'posts';
 *     protected $primaryKey = 'id';
 *     protected $allowedFields = ['title', 'content', 'user_id', 'category_id', 'status'];
 *
 *     // Posts con información del autor
 *     public function getPostsWithAuthor(int $limit = 10): array
 *     {
 *         return $this->getCachedCustomQuery(
 *             function($builder) use ($limit) {
 *                 $builder->select('posts.*, users.name as author_name, users.email as author_email')
 *                         ->join('users', 'users.id = posts.user_id', 'left')
 *                         ->where('posts.status', 'published')
 *                         ->orderBy('posts.created_at', 'DESC')
 *                         ->limit($limit);
 *             },
 *             'posts_with_author_' . $limit
 *         );
 *     }
 *
 *     // Posts con categoría y autor
 *     public function getPostsComplete(array $filters = []): array
 *     {
 *         return $this->getCachedCustomQuery(
 *             function($builder) use ($filters) {
 *                 $builder->select('
 *                         posts.*,
 *                         users.name as author_name,
 *                         categories.name as category_name
 *                     ')
 *                     ->join('users', 'users.id = posts.user_id', 'left')
 *                     ->join('categories', 'categories.id = posts.category_id', 'left')
 *                     ->where('posts.status', 'published');
 *
 *                 if (!empty($filters['category_id'])) {
 *                     $builder->where('posts.category_id', $filters['category_id']);
 *                 }
 *
 *                 if (!empty($filters['user_id'])) {
 *                     $builder->where('posts.user_id', $filters['user_id']);
 *                 }
 *
 *                 $builder->orderBy('posts.created_at', 'DESC')
 *                         ->limit(20);
 *             },
 *             'posts_complete_' . md5(serialize($filters))
 *         );
 *     }
 * }
 * ?>
 */

/**
 * EJEMPLO 4: Pre-carga de Caché (Cache Warming)
 *
 * <?php
 * namespace App\Commands;
 *
 * use CodeIgniter\CLI\BaseCommand;
 * use App\Models\UserModel;
 * use App\Models\PostModel;
 *
 * class WarmCache extends BaseCommand
 * {
 *     protected $group = 'Cache';
 *     protected $name = 'cache:warm';
 *     protected $description = 'Pre-carga datos frecuentes en caché';
 *
 *     public function run(array $params)
 *     {
 *         $this->write('Iniciando pre-carga de caché...', 'yellow');
 *
 *         // Pre-cargar usuarios más accedidos
 *         $userModel = new UserModel();
 *         $userModel->warmCache(
 *             [1, 2, 3, 4, 5], // IDs de usuarios VIP
 *             [
 *                 ['conditions' => ['status' => 'active'], 'limit' => 50],
 *                 ['conditions' => ['role_id' => 1], 'limit' => 20]
 *             ]
 *         );
 *
 *         $this->write('✓ Usuarios pre-cargados', 'green');
 *
 *         // Pre-cargar posts populares
 *         $postModel = new PostModel();
 *         $postModel->warmCache(
 *             [], // No pre-cargar posts individuales
 *             [
 *                 ['conditions' => ['status' => 'published'], 'limit' => 100],
 *                 ['conditions' => ['featured' => 1], 'limit' => 10]
 *             ]
 *         );
 *
 *         $this->write('✓ Posts pre-cargados', 'green');
 *         $this->write('Cache warming completado exitosamente!', 'green');
 *     }
 * }
 * ?>
 */

/**
 * EJEMPLO 5: Monitoreo de Rendimiento
 *
 * <?php
 * namespace App\Controllers\Admin;
 *
 * use App\Models\UserModel;
 * use CodeIgniter\Controller;
 *
 * class CacheMonitorController extends Controller
 * {
 *     public function dashboard()
 *     {
 *         $userModel = new UserModel();
 *
 *         // Simular algunas operaciones
 *         for ($i = 1; $i <= 10; $i++) {
 *             $userModel->getCached($i);
 *             $userModel->getCached($i); // Hit
 *         }
 *
 *         $stats = $userModel->getCacheStats();
 *
 *         return view('admin/cache_dashboard', [
 *             'stats' => $stats,
 *             'recommendations' => $this->getCacheRecommendations($stats)
 *         ]);
 *     }
 *
 *     private function getCacheRecommendations(array $stats): array
 *     {
 *         $recommendations = [];
 *
 *         if ($stats['ratio'] < 50) {
 *             $recommendations[] = 'Cache hit ratio bajo. Considere aumentar el TTL.';
 *         }
 *
 *         if ($stats['ratio'] > 90) {
 *             $recommendations[] = 'Excelente rendimiento de caché.';
 *         }
 *
 *         if ($stats['misses'] > $stats['hits']) {
 *             $recommendations[] = 'Considere implementar cache warming para datos frecuentes.';
 *         }
 *
 *         return $recommendations;
 *     }
 * }
 * ?>
 */

/**
 * EJEMPLO 6: Tareas Programadas para Limpieza
 *
 * <?php
 * namespace App\Commands;
 *
 * use CodeIgniter\CLI\BaseCommand;
 * use App\Models\UserModel;
 *
 * class ClearOldCache extends BaseCommand
 * {
 *     protected $group = 'Cache';
 *     protected $name = 'cache:clear-old';
 *     protected $description = 'Limpia caché antiguo y refresca datos importantes';
 *
 *     public function run(array $params)
 *     {
 *         $userModel = new UserModel();
 *
 *         // Limpiar solo la caché de búsquedas (no registros individuales)
 *         $userModel->invalidateSearchCache();
 *
 *         $this->write('Caché de búsquedas limpiado', 'green');
 *
 *         // Refrescar usuarios críticos
 *         $criticalUsers = [1, 2, 3]; // IDs de admin
 *         foreach ($criticalUsers as $userId) {
 *             $userModel->refreshCache($userId);
 *         }
 *
 *         $this->write('Usuarios críticos refrescados', 'green');
 *     }
 * }
 *
 * // En app/Config/Routes.php o mediante cron:
 * // 0 2 * * * cd /path/to/project && php spark cache:clear-old
 * ?>
 */

?>