# Análisis y Solución de Problemas de Enrutamiento de Assets en Nginx

Este documento detalla el proceso de diagnóstico y la solución a un complejo problema de enrutamiento que impedía la
carga de assets (CSS, JS) en el tema Gamma, a pesar de que el código de la aplicación CodeIgniter era funcionalmente
correcto.

## 1. El Problema Inicial

Los síntomas iniciales eran confusos y contradictorios:

- **Estilos no aplicados:** La página se mostraba sin los estilos CSS, con el layout roto.
- **Errores 404 en Consola:** La consola de desarrollador del navegador mostraba errores `404 Not Found` para los
  archivos CSS y JS.
- **Respuestas de Red Anómalas:** Al inspeccionar la pestaña "Network" (Red), se observaba que las solicitudes a los
  archivos CSS a veces parecían tener un estado `200 OK` o, en otras ocasiones, un `404` pero con cabeceras de
  respuesta (`Content-Type: text/css`) que indicaban que el servidor sí había procesado la solicitud como un archivo
  CSS.

## 2. Proceso de Diagnóstico: Un Viaje de Depuración

El proceso para encontrar la causa raíz fue metódico y descartó progresivamente las posibles causas.

### Paso 2.1: Verificación del Código de la Aplicación

Inicialmente, nos centramos en el flujo de la aplicación CodeIgniter:

1. **La Vista (`styles.php`):** Se confirmó que la llamada al helper `theme_asset()` era correcta.
2. **El Helper (`Application_helper.php`):** Se verificó que la función construía la URL esperada (ej.
   `/ui/themes/gamma/css/gamma.css`).
3. **Las Rutas (`Routes.php`):** Se analizó el archivo de rutas para asegurar que la URL generada se dirigía
   correctamente al controlador `ThemeController::serveAsset`.
4. **El Controlador (`ThemeController.php`):** Se depuró la lógica del controlador para confirmar que construía la ruta
   correcta al archivo en el sistema de archivos (`app/Views/Themes/Gamma/public_html/...`).

**Conclusión Intermedia:** Todo el código de la aplicación parecía ser correcto. Sin embargo, el problema persistía.

### Paso 2.2: Descubrimiento de la Anomalía del Enrutador

Un punto de inflexión fue la creación de un método `test` en el controlador. Este método reveló que los placeholders de
CodeIgniter (`:any`, `.+`) no estaban funcionando como se esperaba en este entorno, capturando solo un segmento de la
URL en lugar de la ruta completa del asset.

La solución a nivel de código fue **ignorar los parámetros del enrutador** y reconstruir la ruta del asset manualmente
dentro del controlador usando el servicio de URI de la solicitud. Esto aseguró que el controlador siempre tuviera la
ruta correcta, independientemente del comportamiento del enrutador.

### Paso 2.3: La Prueba Definitiva (El Servidor es el Culpable)

Incluso con el código PHP corregido, el problema del `404` persistía. La prueba final y más importante fue modificar el
`ThemeController` para que ignorara por completo el sistema de archivos y simplemente enviara una respuesta CSS "
hardcodeada":

```php
header("HTTP/1.1 200 OK");
header('Content-Type: text/css');
header('X-Test-Proof: PHP-SCRIPT-EXECUTED'); // Cabecera de prueba
echo "body { border: 10px solid red !important; }";
exit();
```

El resultado fue la prueba irrefutable:

- **El navegador SÍ recibía el contenido CSS** (el borde rojo aparecía o el contenido era visible en la pestaña
  Network).
- **Pero el código de estado seguía siendo `404 Not Found`**.

Esto demostró sin lugar a dudas que **el código PHP estaba funcionando perfectamente**, pero algo en el servidor Nginx
estaba interceptando la respuesta `200 OK` de PHP y la estaba reescribiendo como un `404`.

## 3. La Causa Raíz: Configuración Conflictiva de Nginx

El análisis de la configuración de Nginx reveló la causa del conflicto:

1. **`error_page 404 /404.html;`**: Esta directiva le dice a Nginx que si se produce un error 404, debe ignorar
   cualquier respuesta y servir internamente el archivo `/404.html`. Cuando se solicitaba un asset, Nginx no lo
   encontraba en el disco, marcaba la solicitud como un 404, y aunque luego PHP generaba una respuesta `200 OK`, esta
   directiva `error_page` tenía la última palabra y forzaba el estado a 404.

2. **`duplicate location "/"`**: El intento de añadir un bloque `location / { try_files ... }` causó un error porque el
   panel de control del servidor ya incluía un archivo de reescritura (`.../rewrite/...conf`) que contenía su propio
   bloque `location /`.

3. **`location ~ .*\.(js|css)?$`**: Estos bloques, aunque bien intencionados para cachear assets, estaban "robando" las
   solicitudes de CSS y JS, impidiendo que llegaran al `index.php` de CodeIgniter para ser procesadas por nuestro
   `ThemeController`.

## 4. La Solución Final: La Configuración Correcta de Nginx

La solución fue reestructurar la configuración del servidor para que fuera compatible con el patrón de un framework como
CodeIgniter, donde el `index.php` actúa como controlador frontal.

A continuación se presenta la configuración final y funcional para `intranet.disa-software.com.conf`:

```nginx
server
{
    listen 80;
    listen 443 ssl http2;
    server_name intranet.disa-software.com;
    index index.php index.html index.htm;
    root /www/wwwroot/development/public_html;

    # --- INCLUDES DEL PANEL ---
    include /www/server/panel/vhost/nginx/extension/intranet.disa-software.com/*.conf;
    include /www/server/panel/vhost/nginx/well-known/intranet.disa-software.com.conf;

    # --- ARCHIVO DE REESCRITURA DEL PANEL (CONFLICTIVO) ---
    # Se comenta esta línea porque ya definimos nuestro propio bloque location /
    # include /www/server/panel/vhost/rewrite/intranet.disa-software.com.conf;

    # --- CONFIGURACIÓN SSL ---
    ssl_certificate    /www/server/panel/vhost/cert/intranet.disa-software.com/fullchain.pem;
    ssl_certificate_key    /www/server/panel/vhost/cert/intranet.disa-software.com/privkey.pem;
    ssl_protocols TLSv1.1 TLSv1.2 TLSv1.3;
    ssl_ciphers EECDH+CHACHA20:EECDH+CHACHA20-draft:EECDH+AES128:RSA+AES128:EECDH+AES256:RSA+AES256:EECDH+3DES:RSA+3DES:!MD5;
    ssl_prefer_server_ciphers on;
    ssl_session_tickets on;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;
    add_header Strict-Transport-Security "max-age=31536000";
    error_page 497  https://$host$request_uri;

    # --- PÁGINAS DE ERROR ---
    # Se comenta la línea 404 conflictiva para permitir que CodeIgniter maneje sus propios errores.
    # error_page 404 /404.html; 
    error_page 502 /502.html;

    # --- REGLA PRINCIPAL DE CODEIGNITER 4 ---
    # Esta es la directiva más importante para frameworks.
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # --- PROCESAMIENTO DE PHP ---
    location ~ \.php$ {
        include enable-php-82.conf;
    }

    # --- REGLAS DE SEGURIDAD ---
    location ~ ^/(\.user.ini|\.htaccess|\.git|\.env|\.svn|\.project|LICENSE|README.md)
    {
        return 404;
    }
    
    if ( $uri ~ "^/\.well-known/.*\.(php|jsp|py|js|css|lua|ts|go|zip|tar\.gz|rar|7z|sql|bak)$" ) {
        return 403;
    }

    # --- LOGS ---
    access_log  /www/wwwlogs/intranet.disa-software.com.log;
    error_log  /www/wwwlogs/intranet.disa-software.com.error.log;
}
```

### Puntos Clave de la Configuración Correcta:

- **`# include .../rewrite/...`**: Se comenta para evitar el error `duplicate location`.
- **`# error_page 404 ...`**: Se comenta para evitar que Nginx sobreescriba las respuestas válidas de PHP.
- **`location / { try_files ... }`**: Es la directiva canónica que le dice a Nginx que si no encuentra un archivo, debe
  pasar la solicitud a `index.php` para que el framework la maneje. Esto es esencial.
- **Se eliminaron los bloques `location ~ .*\.(js|css)?$`**: Estos bloques impedían que las solicitudes de assets
  llegaran al controlador de PHP, que es donde se encuentra la lógica para servirlos desde un directorio protegido.

Con esta configuración, el servidor Nginx y la aplicación CodeIgniter trabajan en armonía, resolviendo el problema de
forma definitiva.
