# Guía de Despliegue - Módulo SIE

## Introducción

Esta guía describe los procedimientos para desplegar el módulo SIE en diferentes entornos, desde desarrollo hasta producción, incluyendo configuraciones de servidor, optimizaciones de rendimiento y procedimientos de mantenimiento.

## Tabla de Contenidos

- [Entornos de Despliegue](#entornos-de-despliegue)
- [Preparación del Servidor](#preparación-del-servidor)
- [Despliegue en Producción](#despliegue-en-producción)
- [Configuración de Servidor Web](#configuración-de-servidor-web)
- [Optimización de Rendimiento](#optimización-de-rendimiento)
- [Monitoreo y Logging](#monitoreo-y-logging)
- [Backup y Recuperación](#backup-y-recuperación)
- [Actualizaciones](#actualizaciones)
- [Troubleshooting](#troubleshooting)

## Entornos de Despliegue

### 1. Desarrollo (Development)

```env
CI_ENVIRONMENT = development
SIE_DEBUG = true
SIE_LOG_LEVEL = debug
SIE_CACHE_TTL = 60
SIE_MINIFY_ASSETS = false
```

### 2. Staging/Pre-producción

```env
CI_ENVIRONMENT = staging
SIE_DEBUG = false
SIE_LOG_LEVEL = info
SIE_CACHE_TTL = 1800
SIE_MINIFY_ASSETS = true
```

### 3. Producción

```env
CI_ENVIRONMENT = production
SIE_DEBUG = false
SIE_LOG_LEVEL = error
SIE_CACHE_TTL = 3600
SIE_MINIFY_ASSETS = true
SIE_FORCE_HTTPS = true
```

## Preparación del Servidor

### Requisitos del Sistema

#### Servidor Web
- **Apache 2.4+** o **Nginx 1.18+**
- **PHP 8.0+** con extensiones requeridas
- **MySQL 8.0+** o **PostgreSQL 12+**
- **Redis** (recomendado para cache)
- **SSL/TLS** certificado válido

#### Recursos Mínimos
- **CPU**: 2 cores
- **RAM**: 4GB (8GB recomendado)
- **Disco**: 20GB SSD
- **Ancho de banda**: 100 Mbps

#### Recursos Recomendados para Producción
- **CPU**: 4+ cores
- **RAM**: 16GB+
- **Disco**: 100GB+ SSD con RAID
- **Ancho de banda**: 1 Gbps

### Instalación de Dependencias

#### Ubuntu/Debian

```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar Apache
sudo apt install apache2 -y

# Instalar PHP 8.1
sudo apt install php8.1 php8.1-fpm php8.1-mysql php8.1-xml php8.1-gd \
                 php8.1-curl php8.1-mbstring php8.1-zip php8.1-intl \
                 php8.1-bcmath php8.1-opcache php8.1-redis -y

# Instalar MySQL
sudo apt install mysql-server -y

# Instalar Redis
sudo apt install redis-server -y

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Instalar Node.js (para assets)
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs -y
```

#### CentOS/RHEL

```bash
# Instalar EPEL y Remi repositories
sudo yum install epel-release -y
sudo yum install https://rpms.remirepo.net/enterprise/remi-release-8.rpm -y

# Instalar Apache
sudo yum install httpd -y

# Instalar PHP 8.1
sudo yum module enable php:remi-8.1 -y
sudo yum install php php-fpm php-mysqlnd php-xml php-gd php-curl \
                 php-mbstring php-zip php-intl php-bcmath php-opcache \
                 php-redis -y

# Instalar MySQL
sudo yum install mysql-server -y

# Instalar Redis
sudo yum install redis -y
```

### Configuración de PHP

```ini
; /etc/php/8.1/fpm/php.ini (Ubuntu) o /etc/php.ini (CentOS)

; Configuración general
memory_limit = 512M
max_execution_time = 300
max_input_time = 300
post_max_size = 100M
upload_max_filesize = 50M
max_file_uploads = 20

; Configuración de sesiones
session.cookie_secure = 1
session.cookie_httponly = 1
session.cookie_samesite = "Strict"
session.use_strict_mode = 1

; OPcache (importante para rendimiento)
opcache.enable = 1
opcache.memory_consumption = 256
opcache.interned_strings_buffer = 16
opcache.max_accelerated_files = 10000
opcache.revalidate_freq = 2
opcache.fast_shutdown = 1

; Configuración de errores (producción)
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /var/log/php/error.log

; Configuración de seguridad
expose_php = Off
allow_url_fopen = Off
allow_url_include = Off
```

## Despliegue en Producción

### 1. Preparación del Código

```bash
# En el servidor de desarrollo/CI
git clone https://github.com/tu-repo/sie-module.git
cd sie-module

# Instalar dependencias
composer install --no-dev --optimize-autoloader

# Compilar assets (si aplica)
npm install
npm run production

# Crear archivo de despliegue
tar -czf sie-deployment-$(date +%Y%m%d-%H%M%S).tar.gz \
    --exclude='.git' \
    --exclude='node_modules' \
    --exclude='tests' \
    --exclude='.env*' \
    .
```

### 2. Despliegue en Servidor

```bash
# En el servidor de producción
cd /var/www/html

# Backup del despliegue anterior
if [ -d "sie-current" ]; then
    mv sie-current sie-backup-$(date +%Y%m%d-%H%M%S)
fi

# Extraer nueva versión
mkdir sie-new
tar -xzf sie-deployment-*.tar.gz -C sie-new

# Configurar permisos
sudo chown -R www-data:www-data sie-new
sudo chmod -R 755 sie-new
sudo chmod -R 777 sie-new/writable

# Copiar configuración
cp sie-backup-*/app/Config/Database.php sie-new/app/Config/
cp sie-backup-*/.env sie-new/

# Ejecutar migraciones
cd sie-new
php spark migrate

# Limpiar cache
php spark cache:clear

# Hacer el switch
cd ..
ln -sfn sie-new sie-current
```

### 3. Script de Despliegue Automatizado

```bash
#!/bin/bash
# deploy.sh

set -e

DEPLOY_DIR="/var/www/html"
APP_NAME="sie"
BACKUP_DIR="/var/backups/sie"
LOG_FILE="/var/log/sie-deploy.log"

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a $LOG_FILE
}

log "Iniciando despliegue de SIE..."

# Crear backup
if [ -d "$DEPLOY_DIR/$APP_NAME-current" ]; then
    BACKUP_NAME="$APP_NAME-backup-$(date +%Y%m%d-%H%M%S)"
    log "Creando backup: $BACKUP_NAME"
    cp -r "$DEPLOY_DIR/$APP_NAME-current" "$BACKUP_DIR/$BACKUP_NAME"
fi

# Desplegar nueva versión
NEW_RELEASE="$APP_NAME-$(date +%Y%m%d-%H%M%S)"
log "Desplegando nueva versión: $NEW_RELEASE"

mkdir -p "$DEPLOY_DIR/$NEW_RELEASE"
tar -xzf "$1" -C "$DEPLOY_DIR/$NEW_RELEASE"

# Configurar permisos
chown -R www-data:www-data "$DEPLOY_DIR/$NEW_RELEASE"
chmod -R 755 "$DEPLOY_DIR/$NEW_RELEASE"
chmod -R 777 "$DEPLOY_DIR/$NEW_RELEASE/writable"

# Copiar configuración existente
if [ -f "$DEPLOY_DIR/$APP_NAME-current/.env" ]; then
    cp "$DEPLOY_DIR/$APP_NAME-current/.env" "$DEPLOY_DIR/$NEW_RELEASE/"
fi

# Ejecutar migraciones
cd "$DEPLOY_DIR/$NEW_RELEASE"
php spark migrate --no-interaction

# Limpiar cache
php spark cache:clear

# Hacer el switch atómico
ln -sfn "$NEW_RELEASE" "$DEPLOY_DIR/$APP_NAME-current"

# Recargar servicios
systemctl reload apache2
systemctl reload php8.1-fpm

log "Despliegue completado exitosamente"

# Limpiar releases antiguos (mantener últimos 5)
cd "$DEPLOY_DIR"
ls -t | grep "^$APP_NAME-20" | tail -n +6 | xargs rm -rf

log "Limpieza de releases antiguos completada"
```

## Configuración de Servidor Web

### Apache

```apache
# /etc/apache2/sites-available/sie.conf
<VirtualHost *:443>
    ServerName sie.tu-dominio.com
    DocumentRoot /var/www/html/sie-current/public
    
    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/sie.crt
    SSLCertificateKeyFile /etc/ssl/private/sie.key
    SSLCertificateChainFile /etc/ssl/certs/sie-chain.crt
    
    # Security Headers
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'"
    
    # Compression
    LoadModule deflate_module modules/mod_deflate.so
    <Location />
        SetOutputFilter DEFLATE
        SetEnvIfNoCase Request_URI \
            \.(?:gif|jpe?g|png)$ no-gzip dont-vary
        SetEnvIfNoCase Request_URI \
            \.(?:exe|t?gz|zip|bz2|sit|rar)$ no-gzip dont-vary
    </Location>
    
    # Caching
    <IfModule mod_expires.c>
        ExpiresActive On
        ExpiresByType text/css "access plus 1 month"
        ExpiresByType application/javascript "access plus 1 month"
        ExpiresByType image/png "access plus 1 year"
        ExpiresByType image/jpg "access plus 1 year"
        ExpiresByType image/jpeg "access plus 1 year"
        ExpiresByType image/gif "access plus 1 year"
    </IfModule>
    
    # Directory Configuration
    <Directory /var/www/html/sie-current/public>
        AllowOverride All
        Require all granted
        
        # Rewrite Rules
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php/$1 [L]
    </Directory>
    
    # Logging
    ErrorLog ${APACHE_LOG_DIR}/sie_error.log
    CustomLog ${APACHE_LOG_DIR}/sie_access.log combined
</VirtualHost>

# Redirect HTTP to HTTPS
<VirtualHost *:80>
    ServerName sie.tu-dominio.com
    Redirect permanent / https://sie.tu-dominio.com/
</VirtualHost>
```

### Nginx

```nginx
# /etc/nginx/sites-available/sie
server {
    listen 80;
    server_name sie.tu-dominio.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name sie.tu-dominio.com;
    root /var/www/html/sie-current/public;
    index index.php;
    
    # SSL Configuration
    ssl_certificate /etc/ssl/certs/sie.crt;
    ssl_certificate_key /etc/ssl/private/sie.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;
    
    # Security Headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
    add_header X-Content-Type-Options nosniff always;
    add_header X-Frame-Options DENY always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    
    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;
    
    # Static Files Caching
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
    
    # PHP Processing
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        
        # Security
        fastcgi_hide_header X-Powered-By;
        fastcgi_read_timeout 300;
    }
    
    # URL Rewriting
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    # Security - Block access to sensitive files
    location ~ /\. {
        deny all;
    }
    
    location ~ /(writable|tests|\.env) {
        deny all;
    }
    
    # Logging
    access_log /var/log/nginx/sie_access.log;
    error_log /var/log/nginx/sie_error.log;
}
```

## Optimización de Rendimiento

### Base de Datos

```sql
-- Configuración MySQL para producción
[mysqld]
# InnoDB Settings
innodb_buffer_pool_size = 4G
innodb_log_file_size = 512M
innodb_log_buffer_size = 64M
innodb_flush_log_at_trx_commit = 2
innodb_file_per_table = 1

# Query Cache
query_cache_type = 1
query_cache_size = 256M
query_cache_limit = 2M

# Connection Settings
max_connections = 200
max_connect_errors = 1000000

# Slow Query Log
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow.log
long_query_time = 2
```

### Redis Cache

```bash
# /etc/redis/redis.conf
maxmemory 2gb
maxmemory-policy allkeys-lru
save 900 1
save 300 10
save 60 10000
```

### PHP-FPM

```ini
; /etc/php/8.1/fpm/pool.d/sie.conf
[sie]
user = www-data
group = www-data
listen = /var/run/php/php8.1-fpm-sie.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0660

pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 1000

; Logging
php_admin_value[error_log] = /var/log/php/sie-fpm.log
php_admin_flag[log_errors] = on
```

## Monitoreo y Logging

### Configuración de Logs

```php
// app/Config/Logger.php
<?php
namespace Config;

class Logger extends \Higgs\Config\Logger
{
    public $handlers = [
        'FileHandler' => [
            'class'     => 'Higgs\Log\Handlers\FileHandler',
            'level'     => 'info',
            'path'      => '/var/log/sie/',
            'filename'  => 'sie-{date}.log',
            'maxSize'   => 52428800, // 50MB
            'maxFiles'  => 30,
        ],
        'ErrorFileHandler' => [
            'class'     => 'Higgs\Log\Handlers\FileHandler',
            'level'     => 'error',
            'path'      => '/var/log/sie/',
            'filename'  => 'sie-errors-{date}.log',
        ]
    ];
}
```

### Logrotate

```bash
# /etc/logrotate.d/sie
/var/log/sie/*.log {
    daily
    missingok
    rotate 30
    compress
    delaycompress
    notifempty
    create 644 www-data www-data
    postrotate
        systemctl reload apache2
    endscript
}
```

### Monitoreo con Systemd

```ini
# /etc/systemd/system/sie-monitor.service
[Unit]
Description=SIE System Monitor
After=network.target

[Service]
Type=simple
User=www-data
ExecStart=/usr/local/bin/sie-monitor.sh
Restart=always
RestartSec=30

[Install]
WantedBy=multi-user.target
```

```bash
#!/bin/bash
# /usr/local/bin/sie-monitor.sh

while true; do
    # Verificar que Apache esté corriendo
    if ! systemctl is-active --quiet apache2; then
        echo "$(date): Apache no está corriendo, reiniciando..." >> /var/log/sie/monitor.log
        systemctl restart apache2
    fi
    
    # Verificar que MySQL esté corriendo
    if ! systemctl is-active --quiet mysql; then
        echo "$(date): MySQL no está corriendo, reiniciando..." >> /var/log/sie/monitor.log
        systemctl restart mysql
    fi
    
    # Verificar espacio en disco
    DISK_USAGE=$(df / | awk 'NR==2 {print $5}' | sed 's/%//')
    if [ $DISK_USAGE -gt 90 ]; then
        echo "$(date): Espacio en disco crítico: ${DISK_USAGE}%" >> /var/log/sie/monitor.log
    fi
    
    sleep 60
done
```

## Backup y Recuperación

### Script de Backup Automatizado

```bash
#!/bin/bash
# /usr/local/bin/sie-backup.sh

BACKUP_DIR="/var/backups/sie"
DATE=$(date +%Y%m%d_%H%M%S)
RETENTION_DAYS=30

# Crear directorio de backup
mkdir -p $BACKUP_DIR

# Backup de base de datos
mysqldump -u backup_user -p$DB_PASSWORD sie_production > $BACKUP_DIR/database_$DATE.sql

# Backup de archivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/html/sie-current/writable/uploads

# Backup de configuración
cp /var/www/html/sie-current/.env $BACKUP_DIR/config_$DATE.env

# Comprimir todo
tar -czf $BACKUP_DIR/sie_complete_$DATE.tar.gz $BACKUP_DIR/*_$DATE.*

# Limpiar archivos temporales
rm $BACKUP_DIR/database_$DATE.sql $BACKUP_DIR/files_$DATE.tar.gz $BACKUP_DIR/config_$DATE.env

# Eliminar backups antiguos
find $BACKUP_DIR -name "sie_complete_*.tar.gz" -mtime +$RETENTION_DAYS -delete

# Log
echo "$(date): Backup completado - sie_complete_$DATE.tar.gz" >> /var/log/sie/backup.log
```

### Cron Job para Backups

```bash
# crontab -e
# Backup diario a las 2:00 AM
0 2 * * * /usr/local/bin/sie-backup.sh

# Backup de logs semanalmente
0 3 * * 0 tar -czf /var/backups/sie/logs_$(date +\%Y\%m\%d).tar.gz /var/log/sie/
```

## Actualizaciones

### Proceso de Actualización

```bash
#!/bin/bash
# update.sh

set -e

echo "Iniciando proceso de actualización..."

# 1. Crear backup completo
./sie-backup.sh

# 2. Poner el sitio en mantenimiento
cp maintenance.html /var/www/html/sie-current/public/index.html

# 3. Descargar nueva versión
wget https://releases.sie.com/latest.tar.gz

# 4. Desplegar
./deploy.sh latest.tar.gz

# 5. Ejecutar migraciones
cd /var/www/html/sie-current
php spark migrate

# 6. Limpiar cache
php spark cache:clear

# 7. Quitar modo mantenimiento
rm /var/www/html/sie-current/public/index.html

echo "Actualización completada"
```

### Rollback

```bash
#!/bin/bash
# rollback.sh

BACKUP_DIR="/var/backups/sie"
LATEST_BACKUP=$(ls -t $BACKUP_DIR/sie_complete_*.tar.gz | head -1)

if [ -z "$LATEST_BACKUP" ]; then
    echo "No se encontró backup para rollback"
    exit 1
fi

echo "Realizando rollback a: $LATEST_BACKUP"

# Extraer backup
cd /tmp
tar -xzf $LATEST_BACKUP

# Restaurar base de datos
mysql -u root -p sie_production < database_*.sql

# Restaurar archivos
tar -xzf files_*.tar.gz -C /

# Restaurar configuración
cp config_*.env /var/www/html/sie-current/.env

echo "Rollback completado"
```

## Troubleshooting

### Problemas Comunes

#### Error 500 - Internal Server Error

```bash
# Verificar logs
tail -f /var/log/apache2/sie_error.log
tail -f /var/log/sie/sie-errors-$(date +%Y-%m-%d).log

# Verificar permisos
sudo chown -R www-data:www-data /var/www/html/sie-current
sudo chmod -R 755 /var/www/html/sie-current
sudo chmod -R 777 /var/www/html/sie-current/writable
```

#### Problemas de Base de Datos

```bash
# Verificar conexión
mysql -u sie_user -p -e "SELECT 1"

# Verificar estado de migraciones
cd /var/www/html/sie-current
php spark migrate:status

# Reparar tablas si es necesario
mysql -u root -p -e "REPAIR TABLE sie_students, sie_courses, sie_enrollments"
```

#### Problemas de Rendimiento

```bash
# Verificar uso de recursos
htop
iotop
mysqladmin processlist

# Verificar logs de consultas lentas
tail -f /var/log/mysql/slow.log

# Limpiar cache
php spark cache:clear
redis-cli FLUSHALL
```

### Comandos Útiles

```bash
# Estado de servicios
systemctl status apache2 mysql redis php8.1-fpm

# Verificar configuración de Apache
apache2ctl configtest

# Verificar configuración de Nginx
nginx -t

# Verificar configuración de PHP
php -m  # Módulos instalados
php --ini  # Archivos de configuración

# Monitoreo en tiempo real
tail -f /var/log/sie/sie-$(date +%Y-%m-%d).log
watch -n 1 'ps aux | grep -E "(apache|mysql|php-fpm)" | grep -v grep'
```

Esta guía de despliegue proporciona todos los elementos necesarios para implementar el módulo SIE de manera segura y eficiente en un entorno de producción.
