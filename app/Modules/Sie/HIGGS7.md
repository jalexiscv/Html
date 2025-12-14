# Guía Completa de Módulos en Higgs7

## ¿Qué es un Módulo en Higgs7?

Un módulo es esencialmente un paquete autocontenido que puede incluir controladores, modelos, vistas, configuraciones, rutas, y otros recursos. Los módulos permiten encapsular funcionalidades específicas y hacerlas portátiles entre diferentes aplicaciones.

## Estructura de un Módulo

Un módulo típico en Higgs7 tiene la siguiente estructura de directorios:

```
Modules/
└── NombreModulo/
    ├── Config/
    │   ├── Routes.php
    │   └── Services.php
    ├── Controllers/
    │   └── ModuloController.php
    ├── Models/
    │   └── ModuloModel.php
    ├── Views/
    │   └── index.php
    ├── Helpers/
    ├── Libraries/
    ├── Language/
    └── Database/
        └── Migrations/
```

## Configuración de Módulos

### 1. Habilitación de Módulos

Primero debes habilitar el autodescubrimiento de módulos en `app/Config/Modules.php`:

```php
<?php
namespace Config;

use Higgs\Modules\Modules as BaseModules;

class Modules extends BaseModules
{
    public $enabled = true;
    public $discoverInComposer = true;
    
    public $aliases = [
        // Alias para módulos si es necesario
    ];
}
```

### 2. Configuración de Autoloading

En `app/Config/Autoload.php`, puedes especificar los espacios de nombres de los módulos:

```php
public $psr4 = [
    APP_NAMESPACE => APPPATH,
    'Config'      => APPPATH . 'Config',
    'Modules'     => APPPATH . 'Modules',
];
```

## Creación de un Módulo

### Paso 1: Estructura del Directorio

Crea la estructura de directorios en `app/Modules/Blog/` (ejemplo de un módulo de blog).

### Paso 2: Configuración de Rutas

En `app/Modules/Blog/Config/Routes.php`:

```php
<?php
$routes->group('blog', ['namespace' => 'Modules\Blog\Controllers'], function($routes) {
    $routes->get('/', 'BlogController::index');
    $routes->get('post/(:segment)', 'BlogController::show/$1');
    $routes->get('admin', 'BlogController::admin');
});
```

### Paso 3: Crear el Controlador

En `app/Modules/Blog/Controllers/BlogController.php`:

```php
<?php
namespace Modules\Blog\Controllers;

use App\Controllers\BaseController;
use Modules\Blog\Models\PostModel;

class BlogController extends BaseController
{
    protected $postModel;
    
    public function __construct()
    {
        $this->postModel = new PostModel();
    }
    
    public function index()
    {
        $data = [
            'posts' => $this->postModel->findAll()
        ];
        
        return view('Modules\Blog\Views\index', $data);
    }
    
    public function show($slug)
    {
        $post = $this->postModel->where('slug', $slug)->first();
        
        if (!$post) {
            throw new \Higgs\Exceptions\PageNotFoundException();
        }
        
        return view('Modules\Blog\Views\show', ['post' => $post]);
    }
}
```

### Paso 4: Crear el Modelo

En `app/Modules/Blog/Models/PostModel.php`:

```php
<?php
namespace Modules\Blog\Models;

use Higgs\Model;

class PostModel extends Model
{
    protected $table = 'blog_posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'content', 'status'];
    protected $useTimestamps = true;
    
    public function getPublishedPosts()
    {
        return $this->where('status', 'published')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
```

### Paso 5: Crear las Vistas

En `app/Modules/Blog/Views/index.php`:

```php
<div class="blog-index">
    <h1>Blog Posts</h1>
    <?php foreach($posts as $post): ?>
        <article>
            <h2><a href="<?= base_url('blog/post/' . $post['slug']) ?>"><?= esc($post['title']) ?></a></h2>
            <p><?= esc(substr($post['content'], 0, 200)) ?>...</p>
        </article>
    <?php endforeach; ?>
</div>
```

## Características Avanzadas de los Módulos

### 1. Servicios Personalizados

En `app/Modules/Blog/Config/Services.php`:

```php
<?php
namespace Modules\Blog\Config;

use Higgs\Config\BaseService;
use Modules\Blog\Libraries\BlogHelper;

class Services extends BaseService
{
    public static function blogHelper($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('blogHelper');
        }
        
        return new BlogHelper();
    }
}
```

### 2. Helpers del Módulo

En `app/Modules/Blog/Helpers/blog_helper.php`:

```php
<?php
if (!function_exists('format_blog_date')) {
    function format_blog_date($date)
    {
        return date('F j, Y', strtotime($date));
    }
}

if (!function_exists('generate_blog_excerpt')) {
    function generate_blog_excerpt($content, $length = 200)
    {
        return substr(strip_tags($content), 0, $length) . '...';
    }
}
```

### 3. Migraciones del Módulo

En `app/Modules/Blog/Database/Migrations/001_create_blog_posts.php`:

```php
<?php
namespace Modules\Blog\Database\Migrations;

use Higgs\Database\Migration;

class CreateBlogPosts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true
            ],
            'content' => [
                'type' => 'TEXT'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'published'],
                'default' => 'draft'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('blog_posts');
    }
    
    public function down()
    {
        $this->forge->dropTable('blog_posts');
    }
}
```

## Ventajas de Usar Módulos

1. **Reutilización**: Los módulos pueden ser fácilmente portados entre diferentes proyectos
2. **Organización**: Mantiene el código organizado y separado por funcionalidades
3. **Mantenimiento**: Facilita el mantenimiento al tener código relacionado agrupado
4. **Colaboración**: Permite que diferentes desarrolladores trabajen en módulos independientes
5. **Testing**: Facilita las pruebas unitarias al tener componentes aislados

## Carga y Uso de Módulos

Higgs7 automáticamente descubre y carga los módulos cuando:
- El autodescubrimiento está habilitado
- Los módulos siguen la convención de nombres y estructura
- Los espacios de nombres están correctamente configurados

Los módulos se integran seamlessly con el resto de la aplicación, permitiendo que sus controladores, modelos y otros componentes sean accedidos como si fueran parte de la aplicación principal.

## Consejos Adicionales

- **Naming Convention**: Usa PascalCase para nombres de módulos (ej: `UserManagement`)
- **Namespace**: Mantén consistencia en los namespaces siguiendo PSR-4
- **Documentation**: Documenta cada módulo con un README.md propio
- **Dependencies**: Minimiza las dependencias entre módulos para mantener la portabilidad
- **Testing**: Incluye tests unitarios específicos para cada módulo

## Conclusión

Esta arquitectura modular hace que Higgs7 sea muy flexible para proyectos grandes y complejos, manteniendo al mismo tiempo la simplicidad que caracteriza al framework. Los módulos proporcionan una manera elegante de organizar código, promover la reutilización y facilitar el mantenimiento a largo plazo.