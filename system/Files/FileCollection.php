<?php

namespace Higgs\Files;

use Higgs\Files\Exceptions\FileException;
use Higgs\Files\Exceptions\FileNotFoundException;
use Countable;
use Generator;
use InvalidArgumentException;
use IteratorAggregate;

class FileCollection implements Countable, IteratorAggregate
{
    protected $files = [];

    public function __construct(array $files = [])
    {
        helper(['filesystem']);
        $this->add($files)->define();
    }

    protected function define(): void
    {
    }

    public function add($paths, bool $recursive = true)
    {
        $paths = (array)$paths;
        foreach ($paths as $path) {
            if (!is_string($path)) {
                throw new InvalidArgumentException('FileCollection paths must be strings.');
            }
            try {
                self::resolveDirectory($path);
            } catch (FileException $e) {
                $this->addFile($path);
                continue;
            }
            $this->addDirectory($path, $recursive);
        }
        return $this;
    }

    final protected static function resolveDirectory(string $directory): string
    {
        if (!is_dir($directory = set_realpath($directory))) {
            $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
            throw FileException::forExpectedDirectory($caller['function']);
        }
        return $directory;
    }

    public function addFile(string $file)
    {
        $this->files[] = self::resolveFile($file);
        return $this;
    }

    final protected static function resolveFile(string $file): string
    {
        if (!is_file($file = set_realpath($file))) {
            $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
            throw FileException::forExpectedFile($caller['function']);
        }
        return $file;
    }

    public function addDirectory(string $directory, bool $recursive = false)
    {
        $directory = self::resolveDirectory($directory);
        foreach (directory_map($directory, 2, true) as $key => $path) {
            if (is_string($path)) {
                $this->addFile($directory . $path);
            } elseif ($recursive && is_array($path)) {
                $this->addDirectory($directory . $key, true);
            }
        }
        return $this;
    }

    public function set(array $files)
    {
        $this->files = [];
        return $this->addFiles($files);
    }

    public function addFiles(array $files)
    {
        foreach ($files as $file) {
            $this->addFile($file);
        }
        return $this;
    }

    public function removeFile(string $file)
    {
        return $this->removeFiles([$file]);
    }

    public function removeFiles(array $files)
    {
        $this->files = array_diff($this->files, $files);
        return $this;
    }

    public function addDirectories(array $directories, bool $recursive = false)
    {
        foreach ($directories as $directory) {
            $this->addDirectory($directory, $recursive);
        }
        return $this;
    }

    public function removePattern(string $pattern, ?string $scope = null)
    {
        if ($pattern === '') {
            return $this;
        }
        $files = $scope === null ? $this->files : self::filterFiles($this->files, $scope);
        return $this->removeFiles(self::matchFiles($files, $pattern));
    }

    final protected static function filterFiles(array $files, string $directory): array
    {
        $directory = self::resolveDirectory($directory);
        return array_filter($files, static fn(string $value): bool => strpos($value, $directory) === 0);
    }

    final protected static function matchFiles(array $files, string $pattern): array
    {
        if (@preg_match($pattern, '') === false) {
            $pattern = str_replace(['#', '.', '*', '?'], ['\#', '\.', '.*', '.'], $pattern);
            $pattern = "#{$pattern}#";
        }
        return array_filter($files, static fn($value) => (bool)preg_match($pattern, basename($value)));
    }

    public function retainPattern(string $pattern, ?string $scope = null)
    {
        if ($pattern === '') {
            return $this;
        }
        $files = $scope === null ? $this->files : self::filterFiles($this->files, $scope);
        return $this->removeFiles(array_diff($files, self::matchFiles($files, $pattern)));
    }

    public function count(): int
    {
        return count($this->files);
    }

    public function getIterator(): Generator
    {
        foreach ($this->get() as $file) {
            yield new File($file, true);
        }
    }

    public function get(): array
    {
        $this->files = array_unique($this->files);
        sort($this->files, SORT_STRING);
        return $this->files;
    }
}