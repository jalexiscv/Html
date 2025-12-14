<?php

namespace App\Models;

use Higgs\Model;
use Higgs\Pager\Pager;
use Config\Services;
use InvalidArgumentException;

// Usar el Model de CodeIgniter

// Para la paginación

class CachedModel extends Model
{
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "default";
    protected $version = '1.0.2 Cached';

    /**
     * @var \Higgs\Cache\CacheInterface Instancia del servicio de caché
     */
    protected $cache;

    /**
     * @var int Tiempo de expiración de la caché en segundos (1 hora por defecto)
     */
    protected $cacheTimeout = 3600;

    /**
     * @var string Prefijo para las claves de caché
     */
    protected $cachePrefix = 'model_';

    /**
     * Constructor
     *
     * Inicializa el modelo y configura el servicio de caché.
     * Genera un prefijo de caché único basado en el nombre de la clase del modelo.
     * Esto evita colisiones de claves de caché cuando se utilizan múltiples modelos con caché.
     */
    public function __construct()
    {
        parent::__construct();
        $this->cache = Services::cache();
        $this->cachePrefix = $this->replaceCharacters(get_class($this) . '_' . $this->version . '_');
        $this->setCacheTimeout(config('Cache')->ttl);
        $this->useSoftDeletes = true; // Establece el uso de SoftDeletes en el constructor
    }

    /**
     * Reemplaza los caracteres '\\' o '.' en una cadena de texto y los convierte en '_'.
     * @param string $input La cadena de texto de entrada.
     * @return string La cadena de texto con los caracteres reemplazados.
     */
    private function replaceCharacters(string $input): string
    {
        return str_replace(['\\', '.'], '_', $input);
    }

    /**
     * Establece el tiempo de expiración de la caché.
     * @param int $seconds Tiempo de expiración en segundos
     */
    public function setCacheTimeout(int $seconds): void
    {
        $this->cacheTimeout = $seconds;
    }

    /**
     * Actualiza un registro en la base de datos e invalida la caché correspondiente.
     *
     * Invalida la caché del registro individual y la caché de búsqueda general.
     *
     * @param mixed $id El ID del registro a actualizar
     * @param array $data Los datos a actualizar
     * @return bool True si la actualización fue exitosa, false en caso contrario
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
     * Invalida la caché de un registro específico.
     *
     * Elimina la entrada de caché correspondiente al ID del registro.
     *
     * @param mixed $id El ID del registro cuya caché se debe invalidar
     */
    protected function invalidateCache(mixed $id): void
    {
        $cacheKey = $this->getCacheKey($id);
        $this->cache->delete($cacheKey);
    }

    /**
     * Genera una clave de caché única para un registro.
     * La clave se genera utilizando el prefijo de caché, el nombre de la tabla y el ID del registro.
     * @param mixed $id El ID del registro
     * @return string La clave de caché generada
     */
    protected function getCacheKey(mixed $id): string
    {
        $id = is_array($id) ? md5(serialize($id)) : $id; // Usar md5 para claves más cortas si $id es un array
        return $this->cachePrefix . "record_{$this->table}_$id";
    }

    /**
     * Elimina un registro de la base de datos e invalida la caché correspondiente.
     *
     * Invalida la caché del registro individual y la caché de búsqueda general.
     *
     * @param mixed $id El ID del registro a eliminar
     * @param bool $purge Si se debe purgar el registro (soft delete)
     * @return bool True si la eliminación fue exitosa, false en caso contrario
     */
    public function delete($id = null, bool $purge = false): bool
    {
        // Eliminar primero de la base de datos
        $result = parent::delete($id, $purge);
        if ($result) {
            $this->invalidateCache($id);
            $this->invalidateSearchCache();
        }
        return $result;
    }

    /**
     * Invalida la caché de búsquedas para este modelo.
     * Elimina todas las entradas de caché que coinciden con el prefijo de búsqueda del modelo.
     */
    public function invalidateSearchCache(): void
    {
        $cacheInfo = cache()->getCacheInfo();
        $prefix = $this->cachePrefix . "search_{$this->table}_";
        if (is_array($cacheInfo)) {
            foreach ($cacheInfo as $key => $info) {
                if (str_starts_with($key, $prefix)) {
                    cache()->delete($key);
                }
            }
        }
        // TODO: Considerar usar "tags" si el controlador de caché lo soporta
    }

    /**
     * Inserta un nuevo registro en la base de datos y actualiza la caché.
     *
     * Invalida la caché de búsqueda general para reflejar el nuevo registro.
     *
     * @param array|object $data Los datos a insertar
     * @param bool $returnID Si se debe devolver el ID del nuevo registro
     * @return int|string|bool El ID del nuevo registro, true, o false en caso de error
     */
    public function insert($data = null, bool $returnID = true): bool|int|string
    {
        $result = parent::insert($data, $returnID);
        if ($result) {
            $newId = $this->db->insertID();
            $this->invalidateSearchCache();
            return $returnID ? $newId : true;
        }
        return false;
    }

    /**
     * Limpia toda la caché del modelo.
     * **Advertencia:** Esta función limpia toda la caché. Si varios modelos
     * utilizan el mismo caché, se recomienda usar `invalidateSearchCache()`
     * y `invalidateCache()` para una limpieza más granular.
     */
    public function clearAllCache(): void
    {
        $this->cache->clean();
    }

    /**
     * Realiza una búsqueda en la base de datos y almacena los resultados en caché.
     * Si los resultados se encuentran en la caché, se devuelven directamente.
     * Si no, se realiza la consulta a la base de datos, se almacenan los resultados en la caché y se devuelven.
     * Incluye información de paginación en los resultados.
     *
     * **Uso con condiciones `LIKE`:**
     * Para realizar búsquedas con `LIKE`, puedes pasar las condiciones en el formato:
     * ```php
     * $conditions = ['campo LIKE' => '%valor%'];
     * ```
     * Esto generará una consulta que buscará coincidencias parciales en el campo especificado.
     *
     * **Ejemplo de uso:**
     * ```php
     * $conditions = [
     *     'name LIKE' => '%example%',
     *     'status' => 'active'
     * ];
     * $results = $model->getCachedSearch($conditions, 10, 0, 'created_at DESC', 1);
     * ```
     * En este ejemplo:
     * - `'name LIKE' => '%example%'` aplica un filtro `LIKE` en el campo `name`.
     * - `'status' => 'active'` aplica un filtro exacto en el campo `status`.
     * - Los resultados se ordenan por `created_at` en orden descendente.
     * - Se limita a 10 resultados por página.
     *
     * @param array $conditions Condiciones de búsqueda
     * @param int $limit Límite de resultados por página
     * @param int $offset Desplazamiento de resultados
     * @param string $orderBy Ordenamiento
     * @param int $page Número de página (para paginación)
     * @return array Resultados de la búsqueda, incluyendo información de paginación
     */
    public function getCachedSearch(array $conditions = [], int $limit = 0, int $offset = 0, string $orderBy = '', int $page = 1): array
    {
        $cacheKey = $this->getSearchCacheKey($conditions, $limit, $offset, $orderBy, $page);
        $cachedData = $this->cache->get($cacheKey);

        if ($cachedData === null) {
            $builder = $this->builder(); // Usa el builder para mayor flexibilidad
            $builder->select('*');
            //$builder->where('deleted_at IS NULL');

            if (!empty($conditions)) {
                $builder->where($conditions);
            }

            if (!empty($orderBy)) {
                $this->validateOrderBy($orderBy); // Validar el ordenamiento
                $builder->orderBy($orderBy);
            }

            $totalResults = $this->where($conditions)->countAllResults(false); // Obtener el total de resultados antes de aplicar el límite

            if ($limit > 0) {
                $builder->limit($limit, $offset);
            }

            $data = $builder->get()->getResultArray();
            $totalPages = $limit > 0 ? ceil($totalResults / $limit) : 1; // Previene la división por cero

            $result = [
                'data' => $data,
                'total' => $totalResults,
                'limit' => $limit,
                'offset' => $offset,
                'page' => $page,
                'totalPages' => $totalPages,
                'sql' => (string)$this->getLastQuery(), // Convertir a string para evitar problemas de serialización
            ];

            $this->cache->save($cacheKey, $result, $this->cacheTimeout);
            return $result;
        }

        return $cachedData;
    }


    /**
     * Genera una clave de caché única para una búsqueda.
     * La clave se genera utilizando el prefijo de caché, el nombre de la tabla, las condiciones de búsqueda, el límite, el
     * desplazamiento, el ordenamiento y el número de página.
     * @param array $conditions Condiciones de búsqueda
     * @param int $limit Límite de resultados
     * @param int $offset Desplazamiento de resultados
     * @param string $orderBy Ordenamiento
     * @param int $page Número de página (para paginación)
     * @return string La clave de caché generada
     */
    protected function getSearchCacheKey(array $conditions, int $limit, int $offset, string $orderBy, int $page): string
    {
        $conditionsKey = md5(serialize($conditions));
        return $this->cachePrefix . "search_{$this->table}_{$conditionsKey}_limit{$limit}_offset{$offset}_order{$orderBy}_page$page";
    }

    /**
     * Refresca la caché de un registro específico.
     * Invalida la caché del registro y luego lo obtiene de la base de datos, almacenándolo en la caché.
     * @param mixed $id El ID del registro a refrescar
     * @return array|object|null El registro actualizado
     */
    public function refreshCache(mixed $id): object|array|null
    {
        $this->invalidateCache($id);
        return $this->getCached($id);
    }

    /**
     * Obtiene un registro de la base de datos y lo almacena en caché.
     * Si el registro se encuentra en la caché, se devuelve directamente.
     * Si no, se busca en la base de datos, se almacena en la caché y se devuelve.
     * @param mixed $id El ID del registro a obtener
     * @return array|object|null El registro obtenido o null si no se encuentra
     */
    public function getCached(mixed $id): object|array|null
    {
        $cacheKey = $this->getCacheKey($id);
        $cachedData = $this->cache->get($cacheKey);

        if ($cachedData === null) {
            $data = parent::find($id);
            if ($data !== null) {
                $this->cache->save($cacheKey, $data, $this->cacheTimeout);
            }
            return $data;
        }

        return $cachedData;
    }

    /**
     * Guarda un valor en la caché.
     * @param string $key La clave de la caché.
     * @param mixed $data Los datos a guardar en la caché.
     * @return void
     */
    public function saveCache(string $key, mixed $data): void
    {
        if ($data !== null) {
            $this->cache->save($key, $data, $this->cacheTimeout);
        }
    }

    /**
     * Lee un valor de la caché.
     * @param string $key La clave de la caché.
     * @return mixed Los datos almacenados en la caché o null si no se encuentran.
     */
    public function readCache(string $key): mixed
    {
        return $this->cache->get($key);
    }

    /**
     * Busca uno o varios registros, utilizando la caché cuando es posible.
     * Si se proporciona un ID, se intenta obtener el registro de la caché.
     * Si no se proporciona un ID, se utiliza el método `find()` del modelo padre.
     * @param mixed $id El ID o array de IDs a buscar
     * @return array|object|null Los registros encontrados
     */
    public function find(mixed $id = null): object|array|null
    {
        if ($id === null) {
            return parent::find();
        }

        if (is_array($id)) {
            return $this->findArray($id);
        }

        return $this->getCached($id);
    }

    /**
     * Busca múltiples registros por sus IDs, utilizando la caché.
     * Intenta obtener cada registro de la caché. Si no se encuentra en la caché, se omite.
     * @param array $ids Array de IDs a buscar
     * @return array Los registros encontrados
     */
    protected function findArray(array $ids): array
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
     * Realiza una búsqueda con uno o varios "where" en la base de datos y almacena el primer resultado en caché.
     * Si el resultado se encuentra en la caché, se devuelve directamente.
     * Si no, se realiza la consulta a la base de datos, se almacena el resultado en la caché y se devuelve.
     * Ejemplo: $model->getCachedFirst(['id' => 123]);
     * @param array $conditions Condiciones para el "where"
     * @return array|object|null El primer resultado de la búsqueda, o null si no se encuentra
     */
    public function getCachedFirst(array $conditions): array|object|null
    {
        // Genera una clave de caché única basada en las condiciones de búsqueda
        $cacheKey = $this->getSearchCacheKey($conditions, 1, 0, '', 1); // Solo buscamos un resultado (first), sin paginación
        $cachedData = $this->readCache($cacheKey);

        // Si no hay datos en caché, realiza la consulta a la base de datos
        if ($cachedData === null) {
            // Ejecuta la consulta con las condiciones proporcionadas
            $query = $this->where($conditions);
            $data = $query->first();

            // Si se encuentra un resultado, guardarlo en la caché
            if ($data !== null) {
                $this->saveCache($cacheKey, $data);
            }

            return $data;
        }

        // Si el resultado está en caché, devuélvelo directamente
        return $cachedData;
    }

    /**
     * Este método obtiene el conteo total de resultados basado en el término de búsqueda proporcionado.
     * Utiliza el almacenamiento en caché para mejorar el rendimiento. La clave de caché se genera usando el término de búsqueda.
     * Si la caché para la clave existe, devuelve el resultado almacenado en caché.
     * Si la caché no existe, ejecuta la consulta a la base de datos, guarda el resultado en la caché y luego devuelve el resultado.
     * @param array $conditions El término de búsqueda para filtrar los resultados. Por defecto es una cadena vacía.
     * @return int El conteo total de resultados basado en el término de búsqueda proporcionado.
     */
    public function getCountAllResults(array $conditions = []): int
    {
        $key = $this->getSearchCacheKey($conditions, 0, 0, '', 1); // Usar getSearchCacheKey para condiciones
        $cache = $this->readCache($key);

        if ($cache === null || !is_numeric($cache)) {
            if (empty($conditions)) {
                $cache = $this->countAllResults();
            } else {
                // Usar where() directamente para las condiciones, similar a getCachedSearch
                $cache = $this->where($conditions)->countAllResults(false); // Pasar false para evitar resetear el query builder
            }
            $this->saveCache($key, $cache);
        }

        return (int) $cache;
    }

    /**
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * autor del regsitro que se desea acceder, editar o eliminar.
     * @param mixed $id codigo primario del registro a consultar
     * @param mixed $author codigo del usuario del cual se pretende establecer la autoria
     * @return boolean falso o verdadero segun sea el caso
     */
    public function getAuthority(mixed $id, mixed $author): bool
    {
        $row = $this->getCachedFirst([$this->primaryKey => $id]);
        if (isset($row["author"]) && $row["author"] == $author) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Valida la cadena de ordenamiento para prevenir inyección SQL.
     * @param string $orderBy La cadena de ordenamiento a validar.
     * @throws InvalidArgumentException Si el campo de ordenamiento no es válido.
     */
    public function validateOrderBy(string $orderBy): void
    {
        $orderFields = explode(',', $orderBy);
        foreach ($orderFields as $field) {
            $field = trim($field);
            if (preg_match('/^(\w+)\s+(ASC|DESC)$/i', $field, $matches)) {
                $fieldName = $matches[1];
                if (!in_array($fieldName, $this->allowedFields)) {
                    throw new InvalidArgumentException('El campo de ordenamiento no es válido.');
                }
            } else {
                throw new InvalidArgumentException('El formato del campo de ordenamiento no es válido.');
            }
        }
    }

    public function deleteCachedWhere(array $conditions = []): void
    {
        $cacheKey = $this->getSearchCacheKey($conditions, 0, 0, '', 1);
        $this->cache->delete($cacheKey);
        parent::where($conditions)->delete();
    }

    public function deleteCachedOrWhere(array $conditions = []): void
    {
        $cacheKey = $this->getSearchCacheKey($conditions, 0, 0, '', 1);
        $this->cache->delete($cacheKey);
        parent::orWhere($conditions)->delete();
        $this->clearAllCache();
    }

    public function addCacheMessage($action, $message, $remaining): void
    {
        // Reemplaza esto con la lógica real para agregar el mensaje a la
        // barra de herramientas de depuración de Higgs.
        // Por ejemplo:
        // \Higgs\Debug\Toolbar\Collectors\Caches::addMessage($action, $message, $remaining);

        // Como no tenemos la implementación de Higgs, simplemente lo registramos
        log_message('debug', "Cache Action: $action, Message: $message, Remaining: $remaining");
    }

    /**
     * Método antiguo (proxy) que llama al nuevo método getCachedSearch
     * @param array $conditions
     * @param int $limit
     * @param int $offset
     * @param string $orderBy
     * @param int $page
     * @return array
     * @deprecated Use getCachedSearch() instead
     */
    public function get_CachedSearch(array $conditions = [], int $limit = 0, int $offset = 0, string $orderBy = '', int $page = 1): array
    {
        return $this->getCachedSearch($conditions, $limit, $offset, $orderBy, $page);
    }

    /**
     * Método antiguo (proxy) que llama al nuevo método getCacheKey
     * @param mixed $id
     * @return string
     * @deprecated Use getCacheKey() instead
     */
    protected function get_CacheKey(mixed $id): string
    {
        return $this->getCacheKey($id);
    }

    /**
     * Método antiguo (proxy) que llama al nuevo método invalidateCache
     * @param mixed $id
     * @return void
     * @deprecated Use invalidateCache() instead
     */
    protected function invalidate_Cache(mixed $id): void
    {
        $this->invalidateCache($id);
    }

    /**
     * Método antiguo (proxy) que llama al nuevo método refreshCache
     * @param mixed $id
     * @return array|object|null
     * @deprecated Use refreshCache() instead
     */
    public function refresh_Cache(mixed $id): object|array|null
    {
        return $this->refreshCache($id);
    }

    /**
     * Método antiguo (proxy) que llama al nuevo método getCachedFirst
     * @param array $conditions
     * @return array|object|null
     * @deprecated Use getCachedFirst() instead
     */
    public function get_CachedFirst(array $conditions): array|object|null
    {
        return $this->getCachedFirst($conditions);
    }

    /**
     * Método antiguo (proxy) que llama al nuevo método getCountAllResults
     * @param array $conditions
     * @return int
     * @deprecated Use getCountAllResults() instead
     */
    public function get_CountAllResults(array $conditions = []): int
    {
        return $this->getCountAllResults($conditions);
    }

    /**
     * Método antiguo (proxy) que llama al nuevo método invalidateSearchCache
     * @return void
     * @deprecated Use invalidateSearchCache() instead
     */
    public function invalidate_SearchCache(): void
    {
        $this->invalidateSearchCache();
    }

    /**
     * Método antiguo (proxy) que llama al nuevo método clearAllCache
     * @return void
     * @deprecated Use clearAllCache() instead
     */
    public function clear_AllCache(): void
    {
        $this->clearAllCache();
    }

    /**
     * Método antiguo (proxy) que llama al nuevo método readCache
     * @return mixed
     * @deprecated Use get_Cached() instead
     */
    public function get_Cached($key): mixed
    {
        return($this->readCache($key));
    }


    public function readVersion(){
        return $this->version;
    }


}

?>