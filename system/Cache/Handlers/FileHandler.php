<?php

namespace Higgs\Cache\Handlers;

use Higgs\Cache\Exceptions\CacheException;
use Higgs\I18n\Time;
use Config\Cache;
use Throwable;

class FileHandler extends BaseHandler
{
    public const MAX_KEY_LENGTH = 255;
    protected $path;
    protected $mode;

    public function __construct(Cache $config)
    {
        if (!property_exists($config, 'file')) {
            $config->file = ['storePath' => $config->storePath ?? WRITEPATH . 'cache', 'mode' => 0640,];
        }
        $this->path = !empty($config->file['storePath']) ? $config->file['storePath'] : WRITEPATH . 'cache';
        $this->path = rtrim($this->path, '/') . '/';
        if (!is_really_writable($this->path)) {
            throw CacheException::forUnableToWrite($this->path);
        }
        $this->mode = $config->file['mode'] ?? 0640;
        $this->prefix = $config->prefix;
    }

    public function initialize()
    {
    }

    public function get(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        $data = $this->getItem($key);
        return is_array($data) ? $data['data'] : null;
    }

    protected function getItem(string $filename)
    {
        if (!is_file($this->path . $filename)) {
            return false;
        }
        $data = @unserialize(file_get_contents($this->path . $filename));
        if (!is_array($data) || !isset($data['ttl'])) {
            return false;
        }
        if ($data['ttl'] > 0 && Time::now()->getTimestamp() > $data['time'] + $data['ttl']) {
            if (is_file($this->path . $filename)) {
                @unlink($this->path . $filename);
            }
            return false;
        }
        return $data;
    }

    public function delete(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        return is_file($this->path . $key) && unlink($this->path . $key);
    }

    public function deleteMatching(string $pattern)
    {
        $deleted = 0;
        foreach (glob($this->path . $pattern, GLOB_NOSORT) as $filename) {
            if (is_file($filename) && @unlink($filename)) {
                $deleted++;
            }
        }
        return $deleted;
    }

    public function increment(string $key, int $offset = 1)
    {
        $key = static::validateKey($key, $this->prefix);
        $data = $this->getItem($key);
        if ($data === false) {
            $data = ['data' => 0, 'ttl' => 18000,];
        } elseif (!is_int($data['data'])) {
            return false;
        }
        $newValue = $data['data'] + $offset;
        return $this->save($key, $newValue, $data['ttl']) ? $newValue : false;
    }

    public function save(string $key, $value, int $ttl = 18000)
    {
        $key = static::validateKey($key, $this->prefix);
        $contents = ['time' => Time::now()->getTimestamp(), 'ttl' => $ttl, 'data' => $value,];
        if ($this->writeFile($this->path . $key, serialize($contents))) {
            try {
                chmod($this->path . $key, $this->mode);
            } catch (Throwable $e) {
                log_message('debug', 'Failed to set mode on cache file: ' . $e);
            }
            return true;
        }
        return false;
    }

    protected function writeFile($path, $data, $mode = 'wb')
    {
        if (($fp = @fopen($path, $mode)) === false) {
            return false;
        }
        flock($fp, LOCK_EX);
        for ($result = $written = 0, $length = strlen($data); $written < $length; $written += $result) {
            if (($result = fwrite($fp, substr($data, $written))) === false) {
                break;
            }
        }
        flock($fp, LOCK_UN);
        fclose($fp);
        return is_int($result);
    }

    public function decrement(string $key, int $offset = 1)
    {
        $key = static::validateKey($key, $this->prefix);
        $data = $this->getItem($key);
        if ($data === false) {
            $data = ['data' => 0, 'ttl' => 18000,];
        } elseif (!is_int($data['data'])) {
            return false;
        }
        $newValue = $data['data'] - $offset;
        return $this->save($key, $newValue, $data['ttl']) ? $newValue : false;
    }

    public function clean()
    {
        return $this->deleteFiles($this->path, false, true);
    }

    protected function deleteFiles(string $path, bool $delDir = false, bool $htdocs = false, int $_level = 0): bool
    {
        $path = rtrim($path, '/\\');
        if (!$currentDir = @opendir($path)) {
            return false;
        }
        while (false !== ($filename = @readdir($currentDir))) {
            if ($filename !== '.' && $filename !== '..') {
                if (is_dir($path . DIRECTORY_SEPARATOR . $filename) && $filename[0] !== '.') {
                    $this->deleteFiles($path . DIRECTORY_SEPARATOR . $filename, $delDir, $htdocs, $_level + 1);
                } elseif ($htdocs !== true || !preg_match('/^(\.htaccess|index\.(html|htm|php)|web\.config)$/i', $filename)) {
                    @unlink($path . DIRECTORY_SEPARATOR . $filename);
                }
            }
        }
        closedir($currentDir);
        return ($delDir === true && $_level > 0) ? @rmdir($path) : true;
    }

    public function getCacheInfo()
    {
        return $this->getDirFileInfo($this->path);
    }

    protected function getDirFileInfo(string $sourceDir, bool $topLevelOnly = true, bool $_recursion = false)
    {
        static $_filedata = [];
        $relativePath = $sourceDir;
        if ($fp = @opendir($sourceDir)) {
            if ($_recursion === false) {
                $_filedata = [];
                $sourceDir = rtrim(realpath($sourceDir) ?: $sourceDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            }
            while (false !== ($file = readdir($fp))) {
                if (is_dir($sourceDir . $file) && $file[0] !== '.' && $topLevelOnly === false) {
                    $this->getDirFileInfo($sourceDir . $file . DIRECTORY_SEPARATOR, $topLevelOnly, true);
                } elseif ($file[0] !== '.') {
                    $_filedata[$file] = $this->getFileInfo($sourceDir . $file);
                    $_filedata[$file]['relative_path'] = $relativePath;
                }
            }
            closedir($fp);
            return $_filedata;
        }
        return false;
    }

    protected function getFileInfo(string $file, $returnedValues = ['name', 'server_path', 'size', 'date'])
    {
        if (!is_file($file)) {
            return false;
        }
        if (is_string($returnedValues)) {
            $returnedValues = explode(',', $returnedValues);
        }
        $fileInfo = [];
        foreach ($returnedValues as $key) {
            switch ($key) {
                case 'name':
                    $fileInfo['name'] = basename($file);
                    break;
                case 'server_path':
                    $fileInfo['server_path'] = $file;
                    break;
                case 'size':
                    $fileInfo['size'] = filesize($file);
                    break;
                case 'date':
                    $fileInfo['date'] = filemtime($file);
                    break;
                case 'readable':
                    $fileInfo['readable'] = is_readable($file);
                    break;
                case 'writable':
                    $fileInfo['writable'] = is_writable($file);
                    break;
                case 'executable':
                    $fileInfo['executable'] = is_executable($file);
                    break;
                case 'fileperms':
                    $fileInfo['fileperms'] = fileperms($file);
                    break;
            }
        }
        return $fileInfo;
    }

    public function getMetaData(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        if (false === $data = $this->getItem($key)) {
            return false;
        }
        return ['expire' => $data['ttl'] > 0 ? $data['time'] + $data['ttl'] : null, 'mtime' => filemtime($this->path . $key), 'data' => $data['data'],];
    }

    public function isSupported(): bool
    {
        return is_writable($this->path);
    }
}