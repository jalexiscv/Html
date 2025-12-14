# Guía de Instalación - Módulo SIE

## Requisitos del Sistema

### Requisitos Mínimos

- **PHP**: 8.0 o superior
- **Framework**: Higgs7 (última versión estable)
- **Base de Datos**: MySQL 5.7+ o PostgreSQL 12+
- **Memoria**: 512 MB RAM mínimo (2GB recomendado)
- **Espacio en Disco**: 500 MB disponible
- **Servidor Web**: Apache 2.4+ o Nginx 1.18+

### Extensiones PHP Requeridas

```bash
# Extensiones obligatorias
php-mbstring
php-xml
php-json
php-curl
php-gd
php-zip
php-intl
php-pdo
php-pdo-mysql (para MySQL)
php-pdo-pgsql (para PostgreSQL)

# Extensiones recomendadas
php-redis
php-opcache
php-imagick
```

### Software Adicional

- **Composer**: Para gestión de dependencias
- **Node.js**: 16+ (para assets front-end)
- **Git**: Para control de versiones

## Instalación

### Paso 1: Preparar el Entorno

#### 1.1 Verificar Requisitos
```bash
# Verificar versión de PHP
php -v

# Verificar extensiones instaladas
php -m

# Verificar Composer
composer --version
```

#### 1.2 Configurar Servidor Web

**Apache (.htaccess)**
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

**Nginx**
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}
```

### Paso 2: Instalar Higgs7

#### 2.1 Crear Proyecto Base
```bash
# Crear nuevo proyecto Higgs7
composer create-project higgs/framework mi-proyecto

# Navegar al directorio
cd mi-proyecto
```

#### 2.2 Configurar Permisos
```bash
# Linux/Mac
chmod -R 755 writable/
chmod -R 755 public/

# Windows (PowerShell como Administrador)
icacls writable /grant Everyone:F /T
icacls public /grant Everyone:F /T
```

### Paso 3: Instalar el Módulo SIE

#### 3.1 Clonar el Módulo
```bash
# Opción 1: Clonar directamente en app/Modules/
git clone [URL_REPOSITORIO] app/Modules/Sie

# Opción 2: Descargar y extraer
# Descargar el archivo ZIP y extraer en app/Modules/Sie/
```

#### 3.2 Instalar Dependencias
```bash
# Navegar al directorio del módulo
cd app/Modules/Sie

# Instalar dependencias si las hay
composer install
```

### Paso 4: Configurar Base de Datos

#### 4.1 Crear Base de Datos
```sql
-- MySQL
CREATE DATABASE sie_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'sie_user'@'localhost' IDENTIFIED BY 'password_seguro';
GRANT ALL PRIVILEGES ON sie_database.* TO 'sie_user'@'localhost';
FLUSH PRIVILEGES;

-- PostgreSQL
CREATE DATABASE sie_database;
CREATE USER sie_user WITH PASSWORD 'password_seguro';
GRANT ALL PRIVILEGES ON DATABASE sie_database TO sie_user;
```

#### 4.2 Configurar Conexión
Editar `app/Config/Database.php`:

```php
<?php
namespace Config;

use Higgs\Database\Config;

class Database extends Config
{
    public $default = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'sie_user',
        'password' => 'password_seguro',
        'database' => 'sie_database',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8mb4',
        'DBCollat' => 'utf8mb4_unicode_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];
}
```

### Paso 5: Configurar el Módulo

#### 5.1 Habilitar Módulos
En `app/Config/Modules.php`:

```php
<?php
namespace Config;

use Higgs\Modules\Modules as BaseModules;

class Modules extends BaseModules
{
    public $enabled = true;
    public $discoverInComposer = true;
    
    public $aliases = [
        'Sie' => 'Modules\Sie',
    ];
}
```

#### 5.2 Configurar Autoload
En `app/Config/Autoload.php`:

```php
public $psr4 = [
    APP_NAMESPACE => APPPATH,
    'Config'      => APPPATH . 'Config',
    'Modules'     => APPPATH . 'Modules',
    'Modules\Sie' => APPPATH . 'Modules/Sie',
];
```

#### 5.3 Configurar Rutas
En `app/Config/Routes.php`, agregar:

```php
// Cargar rutas del módulo SIE
if (file_exists(APPPATH . 'Modules/Sie/Config/Routes.php')) {
    require_once APPPATH . 'Modules/Sie/Config/Routes.php';
}
```

### Paso 6: Ejecutar Migraciones

```bash
# Ejecutar migraciones del sistema
php spark migrate

# Ejecutar migraciones del módulo SIE (si existen)
php spark migrate -n Modules\\Sie
```

### Paso 7: Configurar Variables de Entorno

Crear/editar `.env`:

```env
# Entorno
CI_ENVIRONMENT = development

# Base de datos
database.default.hostname = localhost
database.default.database = sie_database
database.default.username = sie_user
database.default.password = password_seguro
database.default.DBDriver = MySQLi
database.default.DBPrefix = 

# Configuración SIE
sie.default_language = es
sie.max_upload_size = 10M
sie.session_timeout = 3600
sie.enable_moodle_integration = true

# Integración Moodle (opcional)
moodle.url = https://tu-moodle.com
moodle.token = tu_token_moodle
moodle.service = tu_servicio_moodle

# Email (para notificaciones)
email.protocol = smtp
email.SMTPHost = smtp.gmail.com
email.SMTPUser = tu-email@gmail.com
email.SMTPPass = tu-password
email.SMTPPort = 587
email.SMTPCrypto = tls
```

### Paso 8: Configurar Permisos y Seguridad

#### 8.1 Configurar Permisos de Archivos
```bash
# Linux/Mac
find . -type f -name "*.php" -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 777 writable/

# Windows
# Asegurar que IIS_IUSRS tenga permisos de escritura en writable/
```

#### 8.2 Configurar Seguridad
En `app/Config/Security.php`:

```php
public $csrfTokenName  = 'csrf_sie_token';
public $csrfHeaderName = 'X-CSRF-TOKEN';
public $csrfCookieName = 'csrf_sie_cookie';
public $csrfExpire     = 7200;
public $csrfRegenerate = true;
```

### Paso 9: Verificar Instalación

#### 9.1 Acceder al Sistema
```
http://tu-dominio.com/sie
```

#### 9.2 Verificar Funcionalidades
- [ ] Página de inicio carga correctamente
- [ ] Base de datos conecta sin errores
- [ ] Módulos del sistema responden
- [ ] Autenticación funciona
- [ ] Permisos están configurados

#### 9.3 Ejecutar Tests (si están disponibles)
```bash
php spark test
```

## Configuración Post-Instalación

### 1. Configurar Usuario Administrador

Acceder al sistema y crear el primer usuario administrador a través de:
- Panel de administración
- Seeder de datos iniciales
- Script de configuración inicial

### 2. Configurar Datos Básicos

- **Instituciones**: Configurar datos de la institución
- **Sedes**: Crear sedes o campus
- **Programas Académicos**: Definir programas ofrecidos
- **Roles y Permisos**: Configurar sistema de permisos

### 3. Integración con Sistemas Externos

#### Moodle
```php
// En app/Config/Sie.php
public $moodle = [
    'enabled' => true,
    'url' => 'https://tu-moodle.com',
    'token' => 'tu_token',
    'service' => 'moodle_mobile_app'
];
```

#### Sistema de Pagos
```php
// Configurar gateway de pagos
public $payments = [
    'gateway' => 'stripe', // stripe, paypal, etc.
    'test_mode' => true,
    'public_key' => 'pk_test_...',
    'secret_key' => 'sk_test_...'
];
```

## Troubleshooting

### Problemas Comunes

#### Error: "Módulo no encontrado"
```bash
# Verificar autoload
composer dump-autoload

# Verificar permisos
chmod -R 755 app/Modules/Sie/
```

#### Error de Base de Datos
```bash
# Verificar conexión
php spark db:table users

# Verificar migraciones
php spark migrate:status
```

#### Error 500 - Internal Server Error
```bash
# Verificar logs
tail -f writable/logs/log-*.php

# Verificar permisos
chmod -R 777 writable/
```

#### Problemas de Rendimiento
```bash
# Habilitar OPcache en php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=4000

# Configurar cache en .env
cache.handler = redis
cache.storePath = tcp://localhost:6379
```

### Logs y Debugging

#### Habilitar Debug
En `.env`:
```env
CI_ENVIRONMENT = development
sie.debug = true
```

#### Ubicación de Logs
- Sistema: `writable/logs/`
- SIE: `writable/logs/sie/`
- Errores: `writable/logs/errors/`

## Actualización

### Proceso de Actualización
```bash
# 1. Backup de base de datos
mysqldump -u sie_user -p sie_database > backup_$(date +%Y%m%d).sql

# 2. Backup de archivos
tar -czf sie_backup_$(date +%Y%m%d).tar.gz app/Modules/Sie/

# 3. Actualizar código
git pull origin main

# 4. Ejecutar migraciones
php spark migrate

# 5. Limpiar cache
php spark cache:clear
```

## Soporte

### Recursos de Ayuda
- **Documentación**: [README.md](README.md)
- **API**: [API.md](API.md)
- **Framework**: [https://codehiggs.com/](https://codehiggs.com/)

### Contacto Técnico
- Issues: Repositorio del proyecto
- Email: [soporte técnico]
- Documentación adicional: Ver archivos .md del proyecto

¡La instalación del módulo SIE está completa! Ahora puedes comenzar a configurar tu institución educativa.
