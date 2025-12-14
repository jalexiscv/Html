<?php

namespace Higgs\Autoloader;

use Higgs\Exceptions\ConfigException;
use Composer\Autoload\ClassLoader;
use Composer\InstalledVersions;
use Config\Autoload;
use Config\Modules;
use InvalidArgumentException;
use RuntimeException;

class Autoloader
{
    protected $prefixes = [];
    protected $classmap = [];
    protected $files = [];
    protected $helpers = ['url'];

    public function initialize(Autoload $config, Modules $modules)
    {
        $this->prefixes = [];
        $this->classmap = [];
        $this->files = [];
        if ($config->psr4 === [] && $config->classmap === []) {
            throw new InvalidArgumentException('Config array must contain either the \'psr4\' key or the \'classmap\' key.');
        }
        if ($config->psr4 !== []) {
            $this->addNamespace($config->psr4);
        }
        if ($config->classmap !== []) {
            $this->classmap = $config->classmap;
        }
        if ($config->files !== []) {
            $this->files = $config->files;
        }
        if (isset($config->helpers)) {
            $this->helpers = [...$this->helpers, ...$config->helpers];
        }
        if (is_file(COMPOSER_PATH)) {
            $this->loadComposerInfo($modules);
        }
        return $this;
    }

    public function addNamespace($namespace, ?string $path = null)
    {
        if (is_array($namespace)) {
            foreach ($namespace as $prefix => $namespacedPath) {
                $prefix = trim($prefix, '\\');
                if (is_array($namespacedPath)) {
                    foreach ($namespacedPath as $dir) {
                        $this->prefixes[$prefix][] = rtrim($dir, '\\/') . DIRECTORY_SEPARATOR;
                    }
                    continue;
                }
                $this->prefixes[$prefix][] = rtrim($namespacedPath, '\\/') . DIRECTORY_SEPARATOR;
            }
        } else {
            $this->prefixes[trim($namespace, '\\')][] = rtrim($path, '\\/') . DIRECTORY_SEPARATOR;
        }
        return $this;
    }

    private function loadComposerInfo(Modules $modules): void
    {
        $composer = include COMPOSER_PATH;
        $this->loadComposerClassmap($composer);
        if ($modules->discoverInComposer) {
            $this->loadComposerNamespaces($composer, $modules->composerPackages ?? []);
        }
        unset($composer);
    }

    private function loadComposerClassmap(ClassLoader $composer): void
    {
        $classes = $composer->getClassMap();
        $this->classmap = array_merge($this->classmap, $classes);
    }

    private function loadComposerNamespaces(ClassLoader $composer, array $composerPackages): void
    {
        $namespacePaths = $composer->getPrefixesPsr4();
        if (isset($namespacePaths['Higgs\\'])) {
            unset($namespacePaths['Higgs\\']);
        }
        $packageList = InstalledVersions::getAllRawData()[0]['versions'];
        $only = $composerPackages['only'] ?? [];
        $exclude = $composerPackages['exclude'] ?? [];
        if ($only !== [] && $exclude !== []) {
            throw new ConfigException('Cannot use "only" and "exclude" at the same time in "Config\Modules::$composerPackages".');
        }
        $installPaths = [];
        if ($only !== []) {
            foreach ($packageList as $packageName => $data) {
                if (in_array($packageName, $only, true) && isset($data['install_path'])) {
                    $installPaths[] = $data['install_path'];
                }
            }
        } else {
            foreach ($packageList as $packageName => $data) {
                if (!in_array($packageName, $exclude, true) && isset($data['install_path'])) {
                    $installPaths[] = $data['install_path'];
                }
            }
        }
        $newPaths = [];
        foreach ($namespacePaths as $namespace => $srcPaths) {
            $add = false;
            foreach ($srcPaths as $path) {
                foreach ($installPaths as $installPath) {
                    if ($installPath === substr($path, 0, strlen($installPath))) {
                        $add = true;
                        break 2;
                    }
                }
            }
            if ($add) {
                $newPaths[rtrim($namespace, '\\ ')] = $srcPaths;
            }
        }
        $this->addNamespace($newPaths);
    }

    public function register()
    {
        spl_autoload_register([$this, 'loadClass'], true, true);
        spl_autoload_register([$this, 'loadClassmap'], true, true);
        foreach ($this->files as $file) {
            $this->includeFile($file);
        }
    }

    protected function includeFile(string $file)
    {
        $file = $this->sanitizeFilename($file);
        if (is_file($file)) {
            include_once $file;
            return $file;
        }
        return false;
    }

    public function sanitizeFilename(string $filename): string
    {
        $result = preg_match_all('/[^0-9\p{L}\s\/\-_.:\\\\]/u', $filename, $matches);
        if ($result > 0) {
            $chars = implode('', $matches[0]);
            throw new InvalidArgumentException('The file path contains special characters "' . $chars . '" that are not allowed: "' . $filename . '"');
        }
        if ($result === false) {
            if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
                $message = preg_last_error_msg();
            } else {
                $message = 'Regex error. error code: ' . preg_last_error();
            }
            throw new RuntimeException($message . '. filename: "' . $filename . '"');
        }
        $cleanFilename = trim($filename, '.-_');
        if ($filename !== $cleanFilename) {
            throw new InvalidArgumentException('The characters ".-_" are not allowed in filename edges: "' . $filename . '"');
        }
        return $cleanFilename;
    }

    public function unregister(): void
    {
        spl_autoload_unregister([$this, 'loadClass']);
        spl_autoload_unregister([$this, 'loadClassmap']);
    }

    public function getNamespace(?string $prefix = null)
    {
        if ($prefix === null) {
            return $this->prefixes;
        }
        return $this->prefixes[trim($prefix, '\\')] ?? [];
    }

    public function removeNamespace(string $namespace)
    {
        if (isset($this->prefixes[trim($namespace, '\\')])) {
            unset($this->prefixes[trim($namespace, '\\')]);
        }
        return $this;
    }

    public function loadClassmap(string $class)
    {
        $file = $this->classmap[$class] ?? '';
        if (is_string($file) && $file !== '') {
            return $this->includeFile($file);
        }
        return false;
    }

    public function loadClass(string $class)
    {
        $class = trim($class, '\\');
        $class = str_ireplace('.php', '', $class);
        return $this->loadInNamespace($class);
    }

    protected function loadInNamespace(string $class)
    {
        if (strpos($class, '\\') === false) {
            return false;
        }
        foreach ($this->prefixes as $namespace => $directories) {
            foreach ($directories as $directory) {
                $directory = rtrim($directory, '\\/');
                if (strpos($class, $namespace) === 0) {
                    $filePath = $directory . str_replace('\\', DIRECTORY_SEPARATOR, substr($class, strlen($namespace))) . '.php';
                    $filename = $this->includeFile($filePath);
                    if ($filename) {
                        return $filename;
                    }
                }
            }
        }
        return false;
    }

    public function loadHelpers(): void
    {
        helper($this->helpers);
    }

    protected function discoverComposerNamespaces()
    {
        if (!is_file(COMPOSER_PATH)) {
            return;
        }
        $composer = include COMPOSER_PATH;
        $paths = $composer->getPrefixesPsr4();
        $classes = $composer->getClassMap();
        unset($composer);
        if (isset($paths['Higgs\\'])) {
            unset($paths['Higgs\\']);
        }
        $newPaths = [];
        foreach ($paths as $key => $value) {
            $newPaths[rtrim($key, '\\ ')] = $value;
        }
        $this->prefixes = array_merge($this->prefixes, $newPaths);
        $this->classmap = array_merge($this->classmap, $classes);
    }
}