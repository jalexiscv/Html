# Configuración del Módulo SIE

## Introducción

Este documento describe todas las opciones de configuración disponibles para el módulo SIE. La configuración se maneja a través de archivos de configuración, variables de entorno y la interfaz administrativa.

## Archivos de Configuración

### 1. Constants.php

El archivo `Config/Constants.php` contiene todas las constantes del sistema SIE.

#### Configuraciones Principales

```php
<?php
// Configuración General
define('SIE_VERSION', '2.0.0');
define('SIE_NAME', 'Sistema Integral Educativo');
define('SIE_TIMEZONE', 'America/Bogota');

// Configuración de Base de Datos
define('SIE_DB_PREFIX', 'sie_');
define('SIE_MAX_CONNECTIONS', 100);

// Configuración de Archivos
define('SIE_UPLOAD_PATH', WRITEPATH . 'uploads/sie/');
define('SIE_MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('SIE_ALLOWED_EXTENSIONS', 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx');

// Configuración de Sesión
define('SIE_SESSION_TIMEOUT', 3600); // 1 hora
define('SIE_MAX_LOGIN_ATTEMPTS', 5);
define('SIE_LOCKOUT_DURATION', 900); // 15 minutos

// Configuración de Paginación
define('SIE_ITEMS_PER_PAGE', 20);
define('SIE_MAX_ITEMS_PER_PAGE', 100);

// Configuración de Email
define('SIE_FROM_EMAIL', 'noreply@sie.com');
define('SIE_FROM_NAME', 'Sistema SIE');

// Configuración de Integración
define('SIE_MOODLE_ENABLED', true);
define('SIE_API_RATE_LIMIT', 100); // por minuto
```

#### Configuraciones de Módulos Específicos

```php
// Estudiantes
define('SIE_STUDENT_CODE_PREFIX', 'EST');
define('SIE_STUDENT_CODE_LENGTH', 8);
define('SIE_MIN_AGE_ENROLLMENT', 16);

// Cursos
define('SIE_COURSE_CODE_PREFIX', 'CUR');
define('SIE_MAX_STUDENTS_PER_COURSE', 50);
define('SIE_MIN_CREDITS', 1);
define('SIE_MAX_CREDITS', 10);

// Evaluaciones
define('SIE_MIN_GRADE', 0.0);
define('SIE_MAX_GRADE', 5.0);
define('SIE_PASSING_GRADE', 3.0);

// Pagos
define('SIE_CURRENCY', 'COP');
define('SIE_PAYMENT_TIMEOUT', 1800); // 30 minutos
define('SIE_TAX_RATE', 0.19); // 19% IVA
```

### 2. Routes.php

Configuración de rutas del módulo:

```php
<?php
$routes->group('sie', ['namespace' => 'Modules\Sie\Controllers'], function($routes) {
    // Rutas principales
    $routes->get('/', 'Sie::index');
    $routes->get('dashboard', 'Sie::dashboard');
    
    // Gestión de Estudiantes
    $routes->group('students', function($routes) {
        $routes->get('/', 'Students::index');
        $routes->get('create', 'Students::create');
        $routes->post('store', 'Students::store');
        $routes->get('edit/(:num)', 'Students::edit/$1');
        $routes->put('update/(:num)', 'Students::update/$1');
        $routes->delete('delete/(:num)', 'Students::delete/$1');
    });
    
    // API Routes
    $routes->group('api', ['namespace' => 'Modules\Sie\Controllers'], function($routes) {
        $routes->resource('students', ['controller' => 'Api::students']);
        $routes->resource('courses', ['controller' => 'Api::courses']);
        $routes->resource('enrollments', ['controller' => 'Api::enrollments']);
    });
});
```

## Variables de Entorno

### Archivo .env

```env
#--------------------------------------------------------------------
# SIE MODULE CONFIGURATION
#--------------------------------------------------------------------

# General
SIE_ENVIRONMENT = development
SIE_DEBUG = true
SIE_TIMEZONE = America/Bogota
SIE_LANGUAGE = es

# Base de Datos
SIE_DB_HOSTNAME = localhost
SIE_DB_DATABASE = sie_database
SIE_DB_USERNAME = sie_user
SIE_DB_PASSWORD = password_seguro
SIE_DB_DRIVER = MySQLi
SIE_DB_PREFIX = sie_

# Seguridad
SIE_ENCRYPTION_KEY = tu-clave-de-encriptacion-de-32-caracteres
SIE_CSRF_PROTECTION = true
SIE_CSRF_TOKEN_NAME = csrf_sie_token
SIE_SESSION_DRIVER = files
SIE_SESSION_SAVE_PATH = ./writable/sessions

# Archivos y Uploads
SIE_UPLOAD_PATH = ./writable/uploads/sie/
SIE_MAX_FILE_SIZE = 10485760
SIE_ALLOWED_TYPES = jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx
SIE_IMAGE_QUALITY = 90

# Email
SIE_MAIL_PROTOCOL = smtp
SIE_MAIL_HOST = smtp.gmail.com
SIE_MAIL_PORT = 587
SIE_MAIL_USERNAME = tu-email@gmail.com
SIE_MAIL_PASSWORD = tu-password-app
SIE_MAIL_ENCRYPTION = tls
SIE_MAIL_FROM = noreply@sie.com
SIE_MAIL_FROM_NAME = Sistema SIE

# Integración Moodle
SIE_MOODLE_ENABLED = true
SIE_MOODLE_URL = https://tu-moodle.com
SIE_MOODLE_TOKEN = tu-token-moodle
SIE_MOODLE_SERVICE = moodle_mobile_app
SIE_MOODLE_SYNC_AUTO = true

# API Configuration
SIE_API_ENABLED = true
SIE_API_RATE_LIMIT = 100
SIE_API_RATE_WINDOW = 60
SIE_API_AUTH_METHOD = token

# Cache
SIE_CACHE_HANDLER = file
SIE_CACHE_PATH = ./writable/cache/sie/
SIE_CACHE_TTL = 3600

# Logging
SIE_LOG_LEVEL = info
SIE_LOG_PATH = ./writable/logs/sie/
SIE_LOG_MAX_SIZE = 10485760
SIE_LOG_MAX_FILES = 10

# Backup
SIE_BACKUP_ENABLED = true
SIE_BACKUP_PATH = ./writable/backups/sie/
SIE_BACKUP_SCHEDULE = daily
SIE_BACKUP_RETENTION = 30

# Performance
SIE_ENABLE_QUERY_CACHE = true
SIE_ENABLE_OUTPUT_CACHE = true
SIE_CACHE_VIEWS = true
SIE_MINIFY_HTML = false

# Integración con Sistemas de Pago
SIE_PAYMENT_GATEWAY = stripe
SIE_PAYMENT_TEST_MODE = true
SIE_STRIPE_PUBLIC_KEY = pk_test_...
SIE_STRIPE_SECRET_KEY = sk_test_...
SIE_PAYPAL_CLIENT_ID = tu-client-id
SIE_PAYPAL_CLIENT_SECRET = tu-client-secret
```

## Configuración por Módulos

### 1. Gestión de Estudiantes

```php
// En Config/Students.php
<?php
namespace Modules\Sie\Config;

class Students
{
    public $defaultStatus = 'active';
    public $codePrefix = 'EST';
    public $codeLength = 8;
    public $minAge = 16;
    public $maxAge = 100;
    public $requiredFields = ['name', 'email', 'document'];
    public $optionalFields = ['phone', 'address', 'birthdate'];
    
    public $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'email' => 'required|valid_email|is_unique[students.email]',
        'document' => 'required|is_unique[students.document]',
        'phone' => 'permit_empty|regex_match[/^[+]?[0-9\s\-\(\)]+$/]'
    ];
}
```

### 2. Gestión de Cursos

```php
// En Config/Courses.php
<?php
namespace Modules\Sie\Config;

class Courses
{
    public $defaultStatus = 'active';
    public $codePrefix = 'CUR';
    public $maxStudentsPerCourse = 50;
    public $minCredits = 1;
    public $maxCredits = 10;
    public $defaultDuration = 16; // semanas
    
    public $gradeScale = [
        'min' => 0.0,
        'max' => 5.0,
        'passing' => 3.0,
        'decimals' => 1
    ];
}
```

### 3. Sistema de Pagos

```php
// En Config/Payments.php
<?php
namespace Modules\Sie\Config;

class Payments
{
    public $currency = 'COP';
    public $taxRate = 0.19; // 19%
    public $paymentTimeout = 1800; // 30 minutos
    
    public $gateways = [
        'stripe' => [
            'enabled' => true,
            'test_mode' => true,
            'public_key' => env('SIE_STRIPE_PUBLIC_KEY'),
            'secret_key' => env('SIE_STRIPE_SECRET_KEY')
        ],
        'paypal' => [
            'enabled' => false,
            'test_mode' => true,
            'client_id' => env('SIE_PAYPAL_CLIENT_ID'),
            'client_secret' => env('SIE_PAYPAL_CLIENT_SECRET')
        ]
    ];
}
```

## Configuración de Base de Datos

### Conexiones Múltiples

```php
// En Config/Database.php
<?php
namespace Config;

class Database extends \Higgs\Database\Config
{
    public $default = [
        'DSN'      => '',
        'hostname' => env('SIE_DB_HOSTNAME', 'localhost'),
        'username' => env('SIE_DB_USERNAME', ''),
        'password' => env('SIE_DB_PASSWORD', ''),
        'database' => env('SIE_DB_DATABASE', ''),
        'DBDriver' => env('SIE_DB_DRIVER', 'MySQLi'),
        'DBPrefix' => env('SIE_DB_PREFIX', ''),
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8mb4',
        'DBCollat' => 'utf8mb4_unicode_ci',
    ];
    
    // Conexión para reportes (solo lectura)
    public $reports = [
        'DSN'      => '',
        'hostname' => env('SIE_REPORTS_DB_HOSTNAME', 'localhost'),
        'username' => env('SIE_REPORTS_DB_USERNAME', ''),
        'password' => env('SIE_REPORTS_DB_PASSWORD', ''),
        'database' => env('SIE_REPORTS_DB_DATABASE', ''),
        'DBDriver' => 'MySQLi',
        'DBPrefix' => env('SIE_DB_PREFIX', ''),
    ];
}
```

## Configuración de Seguridad

### Configuración CSRF

```php
// En Config/Security.php
<?php
namespace Config;

class Security extends \Higgs\Config\Security
{
    public $csrfTokenName  = env('SIE_CSRF_TOKEN_NAME', 'csrf_sie_token');
    public $csrfHeaderName = 'X-CSRF-TOKEN';
    public $csrfCookieName = 'csrf_sie_cookie';
    public $csrfExpire     = 7200;
    public $csrfRegenerate = true;
    public $csrfRedirect   = true;
}
```

### Configuración de Encriptación

```php
// En Config/Encryption.php
<?php
namespace Config;

class Encryption extends \Higgs\Config\Encryption
{
    public $key    = env('SIE_ENCRYPTION_KEY');
    public $driver = 'OpenSSL';
    public $cipher = 'AES-256-CTR';
    public $rawData = false;
}
```

## Configuración de Cache

```php
// En Config/Cache.php
<?php
namespace Config;

class Cache extends \Higgs\Config\Cache
{
    public $handler = env('SIE_CACHE_HANDLER', 'file');
    
    public $file = [
        'storePath' => env('SIE_CACHE_PATH', WRITEPATH . 'cache/sie/'),
    ];
    
    public $redis = [
        'host'     => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD', null),
        'port'     => env('REDIS_PORT', 6379),
        'timeout'  => 0,
        'database' => env('REDIS_DATABASE', 0),
    ];
}
```

## Configuración de Logging

```php
// En Config/Logger.php
<?php
namespace Config;

class Logger extends \Higgs\Config\Logger
{
    public $threshold = env('SIE_LOG_LEVEL', 'info');
    
    public $handlers = [
        'FileHandler' => [
            'class'     => 'Higgs\Log\Handlers\FileHandler',
            'level'     => 'debug',
            'path'      => env('SIE_LOG_PATH', WRITEPATH . 'logs/sie/'),
            'filename'  => 'sie-{date}.log',
            'maxSize'   => env('SIE_LOG_MAX_SIZE', 10485760),
            'maxFiles'  => env('SIE_LOG_MAX_FILES', 10),
        ]
    ];
}
```

## Configuración Personalizada por Institución

### Sistema de Configuración Dinámica

```php
// Ejemplo de configuración por institución
class InstitutionConfig
{
    public static function get($institution_id, $key, $default = null)
    {
        $config = cache("institution_{$institution_id}_config");
        
        if (!$config) {
            $model = new \Modules\Sie\Models\Sie_Settings();
            $settings = $model->where('institution_id', $institution_id)->findAll();
            
            $config = [];
            foreach ($settings as $setting) {
                $config[$setting['key']] = $setting['value'];
            }
            
            cache()->save("institution_{$institution_id}_config", $config, 3600);
        }
        
        return $config[$key] ?? $default;
    }
}
```

## Configuración de Desarrollo vs Producción

### Desarrollo

```env
SIE_ENVIRONMENT = development
SIE_DEBUG = true
SIE_LOG_LEVEL = debug
SIE_CACHE_TTL = 60
SIE_MINIFY_HTML = false
SIE_PAYMENT_TEST_MODE = true
```

### Producción

```env
SIE_ENVIRONMENT = production
SIE_DEBUG = false
SIE_LOG_LEVEL = error
SIE_CACHE_TTL = 3600
SIE_MINIFY_HTML = true
SIE_PAYMENT_TEST_MODE = false
```

## Configuración de Performance

### Optimizaciones Recomendadas

```env
# Cache
SIE_ENABLE_QUERY_CACHE = true
SIE_ENABLE_OUTPUT_CACHE = true
SIE_CACHE_VIEWS = true

# Compresión
SIE_ENABLE_GZIP = true
SIE_MINIFY_CSS = true
SIE_MINIFY_JS = true

# Base de Datos
SIE_DB_PERSISTENT = true
SIE_DB_CACHE_ON = true
SIE_DB_CACHE_DIR = ./writable/cache/db/
```

## Configuración de Backup

```php
// En Config/Backup.php
<?php
namespace Modules\Sie\Config;

class Backup
{
    public $enabled = env('SIE_BACKUP_ENABLED', true);
    public $path = env('SIE_BACKUP_PATH', WRITEPATH . 'backups/sie/');
    public $schedule = env('SIE_BACKUP_SCHEDULE', 'daily');
    public $retention = env('SIE_BACKUP_RETENTION', 30); // días
    
    public $databases = ['default'];
    public $directories = [
        APPPATH . 'Modules/Sie/',
        WRITEPATH . 'uploads/sie/'
    ];
}
```

## Validación de Configuración

### Script de Verificación

```php
// Comando para verificar configuración
php spark sie:config:check
```

Este comando verifica:
- Variables de entorno requeridas
- Permisos de archivos y directorios
- Conexión a base de datos
- Configuración de cache
- Configuración de email
- Integración con servicios externos

## Configuración Avanzada

### Multi-tenancy

Para instituciones múltiples:

```php
// En Config/Multitenancy.php
<?php
namespace Modules\Sie\Config;

class Multitenancy
{
    public $enabled = true;
    public $identifierType = 'subdomain'; // subdomain, domain, path
    public $defaultTenant = 'main';
    
    public $tenants = [
        'universidad1' => [
            'database' => 'sie_universidad1',
            'config' => [
                'name' => 'Universidad Ejemplo 1',
                'logo' => 'logo1.png'
            ]
        ]
    ];
}
```

Esta configuración completa permite personalizar todos los aspectos del módulo SIE según las necesidades específicas de cada institución educativa.
