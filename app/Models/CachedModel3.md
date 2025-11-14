# 📘 CachedModel v2.0 - Documentación Completa

## 📑 Tabla de Contenidos

1. [Introducción](#introducción)
2. [Instalación](#instalación)
3. [Configuración Básica](#configuración-básica)
4. [Características Principales](#características-principales)
5. [Uso Básico](#uso-básico)
6. [Operaciones CRUD con Caché](#operaciones-crud-con-caché)
7. [Búsquedas Avanzadas](#búsquedas-avanzadas)
8. [Trabajando con JOINs](#trabajando-con-joins)
9. [Consultas Personalizadas](#consultas-personalizadas)
10. [Invalidación de Caché](#invalidación-de-caché)
11. [Estadísticas y Monitoreo](#estadísticas-y-monitoreo)
12. [Cache Warming](#cache-warming)
13. [Mejores Prácticas](#mejores-prácticas)
14. [Solución de Problemas](#solución-de-problemas)
15. [API Completa](#api-completa)

---

## 🎯 Introducción

**CachedModel** es un modelo extendido de Higgs 4 que proporciona un sistema de caché inteligente y automático para
optimizar consultas a la base de datos. Reduce drásticamente la carga en la base de datos y mejora el rendimiento de tu
aplicación.

### ✨ Características Destacadas

- ✅ **Caché automático** en operaciones CRUD (Create, Read, Update, Delete)
- ✅ **Soporte completo para JOINs** y consultas complejas
- ✅ **Invalidación inteligente** de caché al modificar datos
- ✅ **Búsquedas con paginación** incluida
- ✅ **Estadísticas de rendimiento** (cache hits/misses)
- ✅ **Cache warming** para pre-cargar datos frecuentes
- ✅ **Compatible con Soft Deletes**
- ✅ **Retrocompatible** con métodos antiguos
- ✅ **PHP 8.3+** con tipado estricto

### 📊 Beneficios

| Métrica             | Sin Caché | Con CachedModel |
|---------------------|-----------|-----------------|
| Consultas a DB      | 1000/min  | 100/min         |
| Tiempo de respuesta | 200ms     | 5ms             |
| Carga del servidor  | Alta      | Baja            |
| Escalabilidad       | Limitada  | Excelente       |

---

## 🔧 Instalación

### Paso 1: Copiar la Clase

Coloca el archivo `CachedModel.php` en tu proyecto:

```
app/
└── Models/
    └── CachedModel.php
```

### Paso 2: Configurar el Caché

Edita `app/Config/Cache.php`:

```php
<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Cache extends BaseConfig
{
    public $handler = 'redis'; // o 'file', 'memcached', etc.
    public $ttl = 3600; // 1 hora por defecto
    
    public $file = [
        'storePath' => WRITEPATH . 'cache/',
        'mode'      => 0640,
    ];
    
    public $redis = [
        'host'     => '127.0.0.1',
        'password' => null,
        'port'     => 6379,
        'timeout'  => 0,
        'database' => 0,
    ];
}
```

### Paso 3: Verificar Instalación

```php
<?php

namespace App\Controllers;

use App\Models\CachedModel;

class TestController extends BaseController
{
    public function testCache()
    {
        $model = new CachedModel();
        echo "CachedModel instalado correctamente!";
    }
}
```

---

## ⚙️ Configuración Básica

### Crear tu Primer Modelo Cacheado

```php
<?php

namespace App\Models;

class UserModel extends CachedModel
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'email',
        'password',
        'status',
        'role_id',
        'avatar'
    ];

    // Configuración de timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validaciones
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'name'  => 'required|min_length[3]|max_length[100]',
    ];

    protected $validationMessages = [
        'email' => [
            'required' => 'El email es obligatorio',
            'valid_email' => 'Debe ser un email válido',
            'is_unique' => 'Este email ya está registrado',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function __construct()
    {
        parent::__construct();
        
        // Configurar tiempo de caché: 2 horas para usuarios
        $this->setCacheTimeout(7200);
    }
}
```

### Configuración Avanzada

```php
<?php

namespace App\Models;

class ProductModel extends CachedModel
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price', 'stock', 'category_id', 'status'];
    
    public function __construct()
    {
        parent::__construct();
        
        // Personalizar según necesidades
        $this->setCacheTimeout(3600);      // 1 hora
        $this->setCacheEnabled(true);      // Habilitar caché
    }
    
    // Deshabilitar caché temporalmente para operaciones específicas
    public function getRealtimeStock($productId)
    {
        return $this->setCacheEnabled(false)
                    ->find($productId);
    }
}
```

---

## 🚀 Características Principales

### 1. Caché Automático en CRUD

Todas las operaciones CRUD invalidan caché automáticamente:

```php
$model = new UserModel();

// CREATE - Invalida caché de búsquedas
$userId = $model->insert([
    'name' => 'Juan Pérez',
    'email' => 'juan@example.com'
]);

// READ - Usa caché automáticamente
$user = $model->find($userId);

// UPDATE - Invalida caché del registro y búsquedas
$model->update($userId, ['name' => 'Juan Carlos']);

// DELETE - Invalida caché del registro y búsquedas
$model->delete($userId);
```

### 2. Versioning de Caché

Cambiar la versión invalida toda la caché del modelo:

```php
class UserModel extends CachedModel
{
    protected $version = '2.1.0'; // Cambiar para invalidar caché
}
```

### 3. Prefijos Únicos

Cada modelo tiene su propio espacio de caché:

```
App_Models_UserModel_2.0.0_record_users_1
App_Models_ProductModel_2.0.0_record_products_5
```

---

## 📖 Uso Básico

### Obtener un Registro por ID

```php
$model = new UserModel();

// Primera llamada: consulta la DB
$user = $model->getCached(1);
// SQL: SELECT * FROM users WHERE id = 1

// Segunda llamada: obtiene de caché (0ms)
$user = $model->getCached(1);
// No hay consulta SQL

echo $user['name']; // "Juan Pérez"
```

### Obtener Múltiples Registros

```php
// Obtener varios usuarios por ID (con caché individual)
$users = $model->find([1, 2, 3, 4, 5]);

foreach ($users as $user) {
    echo $user['name'] . "\n";
}
```

### Buscar Primer Registro

```php
// Buscar por condición con caché
$user = $model->getCachedFirst(['email' => 'juan@example.com']);

if ($user) {
    echo "Usuario encontrado: " . $user['name'];
} else {
    echo "Usuario no encontrado";
}
```

### Contar Registros

```php
// Total de usuarios
$total = $model->getCountAllResults();
echo "Total usuarios: $total";

// Total de usuarios activos
$activeCount = $model->getCountAllResults(['status' => 'active']);
echo "Usuarios activos: $activeCount";
```

---

## 🔄 Operaciones CRUD con Caché

### CREATE - Insertar Registros

```php
$model = new UserModel();

// Insertar un usuario
$data = [
    'name' => 'María López',
    'email' => 'maria@example.com',
    'password' => password_hash('secreto123', PASSWORD_DEFAULT),
    'status' => 'active',
    'role_id' => 2
];

$userId = $model->insert($data);

if ($userId) {
    echo "Usuario creado con ID: $userId";
    // Caché de búsquedas se invalida automáticamente
}

// Insertar múltiples usuarios
$users = [
    ['name' => 'Pedro', 'email' => 'pedro@example.com'],
    ['name' => 'Ana', 'email' => 'ana@example.com'],
    ['name' => 'Luis', 'email' => 'luis@example.com'],
];

$model->insertBatch($users);
```

### READ - Leer Registros

```php
// Por ID con caché
$user = $model->getCached(1);

// Primera búsqueda por email
$user = $model->getCachedFirst(['email' => 'juan@example.com']);

// Múltiples IDs
$users = $model->find([1, 2, 3]);

// Todos los registros (sin caché por defecto)
$allUsers = $model->findAll();
```

### UPDATE - Actualizar Registros

```php
// Actualizar un usuario
$updated = $model->update(1, [
    'name' => 'Juan Carlos Pérez',
    'status' => 'verified'
]);

if ($updated) {
    echo "Usuario actualizado";
    // Caché del usuario ID 1 se invalida automáticamente
    // Caché de búsquedas se invalida automáticamente
}

// Actualizar múltiples usuarios
$model->whereIn('status', ['pending', 'inactive'])
      ->set(['status' => 'active'])
      ->update();
// Nota: Esto no invalida caché automáticamente, usar:
$model->invalidateSearchCache();
```

### DELETE - Eliminar Registros

```php
// Soft Delete (por defecto)
$deleted = $model->delete(1);

if ($deleted) {
    echo "Usuario eliminado (soft delete)";
    // Caché invalidada automáticamente
}

// Hard Delete (permanente)
$model->delete(1, true);

// Eliminar múltiples
$model->delete([1, 2, 3]);

// Purgar registros eliminados permanentemente
$model->onlyDeleted()->purgeDeleted();
```

---

## 🔍 Búsquedas Avanzadas

### Búsqueda Simple con Paginación

```php
$model = new UserModel();

// Búsqueda con condiciones y paginación
$result = $model->getCachedSearch(
    ['status' => 'active'],  // Condiciones WHERE
    20,                      // Límite (registros por página)
    0,                       // Offset (inicio)
    'created_at DESC',       // Ordenamiento
    1                        // Página actual
);

// Acceder a los datos
echo "Total usuarios: " . $result['total'] . "\n";
echo "Página actual: " . $result['page'] . "\n";
echo "Total páginas: " . $result['totalPages'] . "\n";
echo "¿Hay siguiente?: " . ($result['hasNextPage'] ? 'Sí' : 'No') . "\n";
echo "SQL ejecutado: " . $result['sql'] . "\n";

foreach ($result['data'] as $user) {
    echo "- {$user['name']} ({$user['email']})\n";
}
```

### Búsqueda con Múltiples Condiciones

```php
// Usuarios activos con rol específico
$result = $model->getCachedSearch(
    [
        'status' => 'active',
        'role_id' => 2,
        'created_at >=' => '2024-01-01'
    ],
    50,
    0,
    'name ASC, created_at DESC'
);
```

### Paginación Completa

```php
public function listUsers()
{
    $model = new UserModel();
    $perPage = 20;
    $page = $this->request->getGet('page') ?? 1;
    $offset = ($page - 1) * $perPage;
    
    $result = $model->getCachedSearch(
        ['status' => 'active'],
        $perPage,
        $offset,
        'created_at DESC',
        $page
    );
    
    return view('users/list', [
        'users' => $result['data'],
        'pagination' => [
            'currentPage' => $result['page'],
            'totalPages' => $result['totalPages'],
            'total' => $result['total'],
            'hasNext' => $result['hasNextPage'],
            'hasPrev' => $result['hasPrevPage']
        ]
    ]);
}
```

### Búsqueda con Ordenamiento Complejo

```php
// Múltiples campos de ordenamiento
$result = $model->getCachedSearch(
    ['status' => 'active'],
    100,
    0,
    'role_id ASC, created_at DESC, name ASC'
);
```

---

## 🔗 Trabajando con JOINs

CachedModel ofrece **3 métodos** para trabajar con JOINs y relaciones.

### Método 1: getCachedCustomQuery() - Máxima Flexibilidad

**Ideal para:** Consultas complejas, múltiples JOINs, subconsultas

```php
class UserModel extends CachedModel
{
    /**
     * Obtener usuarios con su rol y departamento
     */
    public function getUsersWithRelations()
    {
        return $this->getCachedCustomQuery(
            function($builder) {
                $builder->select('
                        users.*,
                        roles.name as role_name,
                        roles.permissions as role_permissions,
                        departments.name as department_name,
                        departments.location as department_location
                    ')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->join('departments', 'departments.id = users.department_id', 'left')
                    ->where('users.status', 'active')
                    ->orderBy('users.created_at', 'DESC');
            },
            'users_with_full_relations' // Clave única para identificar esta query
        );
    }
    
    /**
     * Obtener un usuario específico con todas sus relaciones
     */
    public function getUserComplete($userId)
    {
        return $this->getCachedCustomQuery(
            function($builder) use ($userId) {
                $builder->select('
                        users.*,
                        roles.name as role_name,
                        COUNT(posts.id) as total_posts
                    ')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->join('posts', 'posts.user_id = users.id', 'left')
                    ->where('users.id', $userId)
                    ->groupBy('users.id');
            },
            'user_complete_' . $userId,
            true // true = retornar solo un registro
        );
    }
    
    /**
     * Usuarios con posts recientes
     */
    public function getUsersWithRecentPosts($limit = 10)
    {
        return $this->getCachedCustomQuery(
            function($builder) use ($limit) {
                $builder->select('
                        users.id,
                        users.name,
                        users.email,
                        COUNT(DISTINCT posts.id) as post_count,
                        MAX(posts.created_at) as last_post_date
                    ')
                    ->join('posts', 'posts.user_id = users.id AND posts.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)', 'left')
                    ->where('users.status', 'active')
                    ->groupBy('users.id')
                    ->having('post_count >', 0)
                    ->orderBy('post_count', 'DESC')
                    ->limit($limit);
            },
            'users_recent_posts_' . $limit
        );
    }
}
```

### Método 2: getCachedWithJoins() - Sintaxis Simplificada

**Ideal para:** JOINs simples sin lógica compleja

```php
class OrderModel extends CachedModel
{
    /**
     * Obtener órdenes con cliente y productos
     */
    public function getOrdersWithDetails($status = 'pending')
    {
        return $this->getCachedWithJoins(
            // SELECT
            'orders.*, users.name as customer_name, users.email, products.name as product_name, products.price',
            
            // JOINs: [tabla, condición, tipo]
            [
                ['users', 'users.id = orders.user_id', 'inner'],
                ['products', 'products.id = orders.product_id', 'left']
            ],
            
            // WHERE
            ['orders.status' => $status],
            
            // ORDER BY
            'orders.created_at DESC',
            
            // LIMIT
            100
        );
    }
    
    /**
     * Reporte de ventas con múltiples relaciones
     */
    public function getSalesReport($startDate, $endDate)
    {
        return $this->getCachedWithJoins(
            'orders.id, orders.total, orders.created_at, 
             users.name as customer, products.name as product, 
             categories.name as category',
            [
                ['users', 'users.id = orders.user_id', 'inner'],
                ['products', 'products.id = orders.product_id', 'inner'],
                ['categories', 'categories.id = products.category_id', 'left']
            ],
            [
                'orders.status' => 'completed',
                'orders.created_at >=' => $startDate,
                'orders.created_at <=' => $endDate
            ],
            'orders.created_at DESC'
        );
    }
}
```

### Método 3: useCacheForFindAll() - Compatible con CI4

**Ideal para:** Sintaxis familiar de Higgs 4

```php
class PostModel extends CachedModel
{
    /**
     * Posts con autor y categoría
     */
    public function getPostsWithAuthor()
    {
        return $this->useCacheForFindAll(true) // Activar caché
                    ->select('posts.*, users.name as author_name, categories.name as category_name')
                    ->join('users', 'users.id = posts.author_id', 'left')
                    ->join('categories', 'categories.id = posts.category_id', 'left')
                    ->where('posts.status', 'published')
                    ->orderBy('posts.created_at', 'DESC')
                    ->findAll();
    }
    
    /**
     * Posts populares con estadísticas
     */
    public function getPopularPosts($limit = 10)
    {
        return $this->useCacheForFindAll(true)
                    ->select('
                        posts.*,
                        users.name as author_name,
                        COUNT(comments.id) as comment_count,
                        COUNT(likes.id) as like_count
                    ')
                    ->join('users', 'users.id = posts.author_id')
                    ->join('comments', 'comments.post_id = posts.id', 'left')
                    ->join('likes', 'likes.post_id = posts.id', 'left')
                    ->where('posts.status', 'published')
                    ->groupBy('posts.id')
                    ->orderBy('like_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
```

### Comparación de Métodos

| Característica      | getCachedCustomQuery | getCachedWithJoins | useCacheForFindAll |
|---------------------|----------------------|--------------------|--------------------|
| **Flexibilidad**    | ⭐⭐⭐⭐⭐                | ⭐⭐⭐                | ⭐⭐⭐⭐               |
| **Simplicidad**     | ⭐⭐⭐                  | ⭐⭐⭐⭐⭐              | ⭐⭐⭐⭐               |
| **JOINs Múltiples** | ✅                    | ✅                  | ✅                  |
| **Subconsultas**    | ✅                    | ❌                  | ✅                  |
| **GROUP BY**        | ✅                    | ❌                  | ✅                  |
| **HAVING**          | ✅                    | ❌                  | ✅                  |
| **Sintaxis CI4**    | ❌                    | ❌                  | ✅                  |

### Ejemplo Completo: Sistema de Blog

```php
<?php

namespace App\Models;

class BlogPostModel extends CachedModel
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content', 'author_id', 'category_id', 'status', 'views'];
    
    /**
     * Posts publicados con toda la información
     */
    public function getPublishedPosts($page = 1, $perPage = 20)
    {
        $offset = ($page - 1) * $perPage;
        
        return $this->getCachedCustomQuery(
            function($builder) use ($perPage, $offset) {
                $builder->select('
                        posts.id,
                        posts.title,
                        posts.excerpt,
                        posts.created_at,
                        posts.views,
                        users.name as author_name,
                        users.avatar as author_avatar,
                        categories.name as category_name,
                        categories.slug as category_slug,
                        COUNT(DISTINCT comments.id) as comment_count,
                        COUNT(DISTINCT likes.id) as like_count
                    ')
                    ->join('users', 'users.id = posts.author_id', 'inner')
                    ->join('categories', 'categories.id = posts.category_id', 'left')
                    ->join('comments', 'comments.post_id = posts.id AND comments.status = "approved"', 'left')
                    ->join('likes', 'likes.post_id = posts.id', 'left')
                    ->where('posts.status', 'published')
                    ->groupBy('posts.id')
                    ->orderBy('posts.created_at', 'DESC')
                    ->limit($perPage, $offset);
            },
            'published_posts_page_' . $page
        );
    }
    
    /**
     * Post individual con toda la información
     */
    public function getPostBySlug($slug)
    {
        return $this->getCachedCustomQuery(
            function($builder) use ($slug) {
                $builder->select('
                        posts.*,
                        users.name as author_name,
                        users.email as author_email,
                        users.bio as author_bio,
                        users.avatar as author_avatar,
                        categories.name as category_name,
                        categories.slug as category_slug
                    ')
                    ->join('users', 'users.id = posts.author_id', 'inner')
                    ->join('categories', 'categories.id = posts.category_id', 'left')
                    ->where('posts.slug', $slug)
                    ->where('posts.status', 'published');
            },
            'post_slug_' . $slug,
            true // Solo un registro
        );
    }
    
    /**
     * Posts relacionados
     */
    public function getRelatedPosts($postId, $categoryId, $limit = 5)
    {
        return $this->getCachedCustomQuery(
            function($builder) use ($postId, $categoryId, $limit) {
                $builder->select('
                        posts.id,
                        posts.title,
                        posts.slug,
                        posts.excerpt,
                        posts.created_at,
                        users.name as author_name
                    ')
                    ->join('users', 'users.id = posts.author_id')
                    ->where('posts.category_id', $categoryId)
                    ->where('posts.id !=', $postId)
                    ->where('posts.status', 'published')
                    ->orderBy('posts.created_at', 'DESC')
                    ->limit($limit);
            },
            'related_posts_' . $postId . '_cat_' . $categoryId
        );
    }
    
    /**
     * Autores más activos
     */
    public function getTopAuthors($limit = 10)
    {
        return $this->getCachedCustomQuery(
            function($builder) use ($limit) {
                $builder->select('
                        users.id,
                        users.name,
                        users.avatar,
                        COUNT(posts.id) as post_count,
                        SUM(posts.views) as total_views
                    ')
                    ->join('users', 'users.id = posts.author_id', 'inner')
                    ->where('posts.status', 'published')
                    ->groupBy('users.id')
                    ->orderBy('post_count', 'DESC')
                    ->limit($limit);
            },
            'top_authors_' . $limit
        );
    }
}
```

---

## 🎨 Consultas Personalizadas

### Query Builder Avanzado

```php
class ProductModel extends CachedModel
{
    /**
     * Productos con stock bajo y proveedores
     */
    public function getLowStockProducts()
    {
        return $this->getCachedCustomQuery(
            function($builder) {
                $builder->select('
                        products.*,
                        categories.name as category,
                        suppliers.name as supplier,
                        suppliers.email as supplier_email,
                        suppliers.phone as supplier_phone
                    ')
                    ->join('categories', 'categories.id = products.category_id')
                    ->join('suppliers', 'suppliers.id = products.supplier_id')
                    ->where('products.stock <', 10)
                    ->where('products.status', 'active')
                    ->orderBy('products.stock', 'ASC');
            },
            'low_stock_products'
        );
    }
    
    /**
     * Productos más vendidos por categoría
     */
    public function getTopSellingByCategory($categoryId, $days = 30)
    {
        return $this->getCachedCustomQuery(
            function($builder) use ($categoryId, $days) {
                $builder->select('
                        products.id,
                        products.name,
                        products.price,
                        products.image,
                        SUM(order_items.quantity) as total_sold,
                        SUM(order_items.quantity * order_items.price) as total_revenue
                    ')
                    ->join('order_items', 'order_items.product_id = products.id')
                    ->join('orders', 'orders.id = order_items.order_id AND orders.created_at >= DATE_SUB(NOW(), INTERVAL ' . $days . ' DAY)')
                    ->where('products.category_id', $categoryId)
                    ->where('orders.status', 'completed')
                    ->groupBy('products.id')
                    ->having('total_sold >', 0)
                    ->orderBy('total_sold', 'DESC')
                    ->limit(20);
            },
            'top_selling_cat_' . $categoryId . '_days_' . $days
        );
    }
    
    /**
     * Búsqueda avanzada con filtros
     */
    public function advancedSearch($filters = [])
    {
        return $this->getCachedCustomQuery(
            function($builder) use ($filters) {
                $builder->select('products.*, categories.name as category_name');
                $builder->join('categories', 'categories.id = products.category_id', 'left');
                
                if (!empty($filters['search'])) {
                    $search = $filters['search'];
                    $builder->groupStart()
                            ->like('products.name', $search)
                            ->orLike('products.description', $search)
                            ->groupEnd();
                }
                
                if (!empty($filters['category_id'])) {
                    $builder->where('products.category_id', $filters['category_id']);
                }
                
                if (!empty($filters['min_price'])) {
                    $builder->where('products.price >=', $filters['min_price']);
                }
                
                if (!empty($filters['max_price'])) {
                    $builder->where('products.price <=', $filters['max_price']);
                }
                
                if (!empty($filters['in_stock'])) {
                    $builder->where('products.stock >', 0);
                }
                
                $builder->where('products.status', 'active');
                
                $orderBy = $filters['order_by'] ?? 'products.created_at';
                $orderDir = $filters['order_dir'] ?? 'DESC';
                $builder->orderBy($orderBy, $orderDir);
            },
            'advanced_search_' . md5(serialize($filters))
        );
    }
}
```

---

## 🗑️ Invalidación de Caché

### Invalidación Automática

El caché se invalida automáticamente en estas operaciones:

```php
$model = new UserModel();

// INSERT - Invalida caché de búsquedas
$model->insert(['name' => 'Juan']);

// UPDATE - Invalida caché del registro y búsquedas