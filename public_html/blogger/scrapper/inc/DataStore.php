<?php

/**
 * DataStore.php
 * Almacenamiento sencillo basado en archivo JSON para mapear ID MD5 -> URL canónica.
 * No usa dependencias externas. Emplea bloqueo de archivo para concurrencia básica.
 */
class DataStore
{
    /** @var string Ruta al archivo JSON */
    private $file;

    /**
     * @param string $baseDir Directorio base donde guardar el archivo (p.ej. __DIR__ del scrapper)
     */
    public function __construct($baseDir)
    {
        $dir = rtrim(str_replace('\\', '/', (string)$baseDir), '/');
        if ($dir === '') $dir = __DIR__;
        $this->file = $dir . '/.datastore.json';
        // Asegurar existencia del archivo
        if (!is_file($this->file)) {
            @file_put_contents($this->file, json_encode(new stdClass()));
        }
    }

    /**
     * Guarda el mapeo $id -> $url (sobrescribe si existe).
     * @param string $id MD5 de 32 caracteres
     * @param string $url URL canónica
     * @return bool Éxito
     */
    public function setUrl($id, $url)
    {
        if (!is_string($id) || !preg_match('/^[a-f0-9]{32}$/i', $id)) return false;
        if (!is_string($url) || !filter_var($url, FILTER_VALIDATE_URL)) return false;
        $data = $this->readAll();
        $data[$id] = $url;
        return $this->writeAll($data);
    }

    /** @return array<string,string> */
    private function readAll()
    {
        $fp = @fopen($this->file, 'c+');
        if (!$fp) return [];
        // Bloqueo compartido para lectura
        @flock($fp, LOCK_SH);
        $size = filesize($this->file);
        $json = $size > 0 ? fread($fp, $size) : '';
        @flock($fp, LOCK_UN);
        fclose($fp);
        $arr = json_decode($json, true);
        return is_array($arr) ? $arr : [];
    }

    // ---------------------- utilidades privadas ---------------------------

    /**
     * @param array<string,string> $data
     * @return bool
     */
    private function writeAll(array $data)
    {
        $tmp = $this->file . '.tmp';
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $fp = @fopen($tmp, 'w');
        if (!$fp) return false;
        @flock($fp, LOCK_EX);
        $ok = fwrite($fp, $json) !== false;
        fflush($fp);
        @flock($fp, LOCK_UN);
        fclose($fp);
        if ($ok) {
            // Reemplazo atómico best-effort en Windows: unlink y rename
            @unlink($this->file);
            $ok = @rename($tmp, $this->file);
        } else {
            @unlink($tmp);
        }
        return $ok;
    }

    /**
     * Obtiene la URL asociada a un $id; devuelve null si no existe.
     * @param string $id
     * @return string|null
     */
    public function getUrl($id)
    {
        if (!is_string($id) || !preg_match('/^[a-f0-9]{32}$/i', $id)) return null;
        $data = $this->readAll();
        return isset($data[$id]) ? $data[$id] : null;
    }
}
