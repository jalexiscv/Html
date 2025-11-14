<?php

/**
 * EnvLoader
 * Cargador minimalista de variables desde un archivo .env ubicado, por defecto,
 * en la raíz del proyecto. No usa librerías de terceros.
 *
 * Características:
 * - Soporta comentarios con # y líneas en blanco.
 * - Acepta formato KEY=VALUE con o sin comillas simples/dobles.
 * - Permite prefijo opcional "export KEY=VALUE".
 * - Expande referencias ${OTRA_VAR} si existen.
 * - Castea tipos básicos: true/false -> bool, null -> null, números -> int/float.
 * - Provee función global env($key, $default = null).
 */
class EnvLoader
{
    /** @var array<string,mixed> */
    private static $vars = [];
    /** @var array<string,mixed> Valores por defecto programáticos si no hay .env */
    private static $defaults = [];

    /**
     * Carga el archivo .env y lo almacena en memoria.
     * Si $envPath es null, intenta localizarlo en public_html/scrapper/.env
     * (todo el proyecto vive dentro del directorio Scrapper).
     *
     * @param string|null $envPath Ruta absoluta al .env
     * @return void
     */
    public static function load($envPath = null)
    {
        if ($envPath === null) {
            // Por defecto: archivo .env dentro de public_html/scrapper/
            // __DIR__ => .../public_html/scrapper/inc
            // dirname(__DIR__) => .../public_html/scrapper
            $envPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
        }
        if (!is_readable($envPath)) {
            // No interrumpe la app si no existe; simplemente no carga variables
            return;
        }

        $content = file($envPath, FILE_IGNORE_NEW_LINES);
        if ($content === false) return;

        $raw = [];
        foreach ($content as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') continue;

            // Eliminar comentarios inline no escapados: foo=bar # comentario
            $line = preg_replace('/(?<!\\)#.*$/', '', $line);
            $line = trim($line);
            if ($line === '') continue;

            // Soporte prefijo export
            if (stripos($line, 'export ') === 0) {
                $line = trim(substr($line, 7));
            }

            // Separar KEY y VALUE por el primer '='
            $pos = strpos($line, '=');
            if ($pos === false) continue;
            $key = trim(substr($line, 0, $pos));
            $val = trim(substr($line, $pos + 1));

            // Quitar comillas si aplica
            if ((strlen($val) >= 2) && (
                    ($val[0] === '"' && substr($val, -1) === '"') ||
                    ($val[0] === "'" && substr($val, -1) === "'")
                )) {
                $quote = $val[0];
                $val = substr($val, 1, -1);
                if ($quote === '"') {
                    // Des-escapar secuencias comunes
                    $val = str_replace(['\\n', '\\r', '\\t', '\\"', '\\\\'], ["\n", "\r", "\t", '"', '\\'], $val);
                } else {
                    // Comillas simples: solo des-escapar \' y \\
                    $val = str_replace(["\\'", "\\\\"], ["'", "\\"], $val);
                }
            }

            $raw[$key] = $val;
        }

        // Expansión ${VAR}
        $expanded = [];
        $resolve = function ($k) use (&$raw, &$expanded, &$resolve) {
            if (array_key_exists($k, $expanded)) return $expanded[$k];
            if (!array_key_exists($k, $raw)) return null;
            $val = $raw[$k];
            $val = preg_replace_callback('/\$\{([A-Z0-9_]+)\}/i', function ($m) use (&$raw, &$expanded, &$resolve) {
                $rk = $m[1];
                $rv = array_key_exists($rk, $raw) ? $resolve($rk) : (getenv($rk) !== false ? getenv($rk) : '');
                return $rv === null ? '' : (string)$rv;
            }, (string)$val);
            $expanded[$k] = $val;
            return $val;
        };

        foreach ($raw as $k => $_) {
            $resolve($k);
        }

        // Casteo básico
        foreach ($expanded as $k => $v) {
            self::$vars[$k] = self::cast($v);
        }

        // Exponer también en $_ENV y putenv para compatibilidad
        foreach (self::$vars as $k => $v) {
            $_ENV[$k] = $v;
            // Guardar como string en putenv
            @putenv($k . '=' . (is_bool($v) ? ($v ? 'true' : 'false') : (string)$v));
        }
    }

    /**
     * Conversión de string a tipos básicos.
     * - "true"/"false" (case-insensitive) -> bool
     * - "null" -> null
     * - números enteros o float -> int/float
     * - otro -> string
     * @param mixed $v
     * @return mixed
     */
    public static function cast($v)
    {
        if (!is_string($v)) return $v;
        $t = strtolower(trim($v));
        if ($t === 'true') return true;
        if ($t === 'false') return false;
        if ($t === 'null') return null;
        if (preg_match('/^-?\d+$/', $v)) return (int)$v;
        if (preg_match('/^-?\d*\.\d+$/', $v)) return (float)$v;
        return $v;
    }

    /**
     * Define valores por defecto programáticos para variables de entorno.
     * Útil cuando no queremos depender de un archivo .env.
     * Las claves existentes en defaults se sobreescriben.
     *
     * @param array<string,mixed> $pairs
     * @return void
     */
    public static function setDefaults(array $pairs)
    {
        foreach ($pairs as $k => $v) {
            if (!is_string($k)) continue;
            self::$defaults[$k] = $v;
        }
    }

    /**
     * Obtiene una variable cargada, devolviendo $default si no existe.
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (array_key_exists($key, self::$vars)) return self::$vars[$key];
        // Fallback a getenv/$_ENV si se setearon externamente
        $ge = getenv($key);
        if ($ge !== false) return self::cast($ge);
        if (array_key_exists($key, $_ENV)) return self::cast($_ENV[$key]);
        // Fallback a valores por defecto programáticos
        if (array_key_exists($key, self::$defaults)) return self::cast(self::$defaults[$key]);
        return $default;
    }
}

if (!function_exists('env')) {
    /**
     * Helper global para obtener variables de entorno cargadas por EnvLoader.
     * @param string $key Clave de la variable
     * @param mixed $default Valor por defecto si no existe
     * @return mixed
     */
    function env($key, $default = null)
    {
        return EnvLoader::get($key, $default);
    }
}
