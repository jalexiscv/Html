<?php

namespace Higgs\Publisher;

use Higgs\Autoloader\FileLocator;
use Higgs\Files\FileCollection;
use Higgs\HTTP\URI;
use Higgs\Publisher\Exceptions\PublisherException;
use RuntimeException;
use Throwable;

class Publisher extends FileCollection
{
    private static array $discovered = [];
    protected $source = ROOTPATH;
    protected $destination = FCPATH;
    private ?string $scratch = null;
    private array $errors = [];
    private array $published = [];
    private array $restrictions;
    private ContentReplacer $replacer;

    public function __construct(?string $source = null, ?string $destination = null)
    {
        helper(['filesystem']);
        $this->source = self::resolveDirectory($source ?? $this->source);
        $this->destination = self::resolveDirectory($destination ?? $this->destination);
        $this->replacer = new ContentReplacer();
        $this->restrictions = config('Publisher')->restrictions;
        foreach (array_keys($this->restrictions) as $directory) {
            if (strpos($this->destination, $directory) === 0) {
                return;
            }
        }
        throw PublisherException::forDestinationNotAllowed($this->destination);
    }

    final public static function discover(string $directory = 'Publishers'): array
    {
        if (isset(self::$discovered[$directory])) {
            return self::$discovered[$directory];
        }
        self::$discovered[$directory] = [];
        $locator = service('locator');
        if ([] === $files = $locator->listFiles($directory)) {
            return [];
        }
        foreach (array_unique($files) as $file) {
            $className = $locator->getClassname($file);
            if ($className !== '' && class_exists($className) && is_a($className, self::class, true)) {
                self::$discovered[$directory][] = new $className();
            }
        }
        sort(self::$discovered[$directory]);
        return self::$discovered[$directory];
    }

    public function __destruct()
    {
        if (isset($this->scratch)) {
            self::wipeDirectory($this->scratch);
            $this->scratch = null;
        }
    }

    private static function wipeDirectory(string $directory): void
    {
        if (is_dir($directory)) {
            $attempts = 10;
            while ((bool)$attempts && !delete_files($directory, true, false, true)) {
                $attempts--;
                usleep(100000);
            }
            @rmdir($directory);
        }
    }

    public function publish(): bool
    {
        if ($this->source === ROOTPATH && $this->destination === FCPATH) {
            throw new RuntimeException('Child classes of Publisher should provide their own publish method or a source and destination.');
        }
        return $this->addPath('/')->merge(true);
    }

    final public function merge(bool $replace = true): bool
    {
        $this->errors = $this->published = [];
        $sourced = self::filterFiles($this->get(), $this->source);
        $this->files = array_diff($this->files, $sourced);
        $this->copy($replace);
        foreach ($sourced as $file) {
            $to = $this->destination . substr($file, strlen($this->source));
            try {
                $this->safeCopyFile($file, $to, $replace);
                $this->published[] = $to;
            } catch (Throwable $e) {
                $this->errors[$file] = $e;
            }
        }
        return $this->errors === [];
    }

    final public function copy(bool $replace = true): bool
    {
        $this->errors = $this->published = [];
        foreach ($this->get() as $file) {
            $to = $this->destination . basename($file);
            try {
                $this->safeCopyFile($file, $to, $replace);
                $this->published[] = $to;
            } catch (Throwable $e) {
                $this->errors[$file] = $e;
            }
        }
        return $this->errors === [];
    }

    private function safeCopyFile(string $from, string $to, bool $replace): void
    {
        $this->verifyAllowed($from, $to);
        if (file_exists($to)) {
            if (!$replace || same_file($from, $to)) {
                return;
            }
            if (is_dir($to)) {
                throw PublisherException::forCollision($from, $to);
            }
            unlink($to);
        }
        if (!is_dir($directory = pathinfo($to, PATHINFO_DIRNAME))) {
            mkdir($directory, 0775, true);
        }
        copy($from, $to);
    }

    private function verifyAllowed(string $from, string $to)
    {
        foreach ($this->restrictions as $directory => $pattern) {
            if (strpos($to, $directory) === 0 && self::matchFiles([$to], $pattern) === []) {
                throw PublisherException::forFileNotAllowed($from, $directory, $pattern);
            }
        }
    }

    final public function addPath(string $path, bool $recursive = true)
    {
        $this->add($this->source . $path, $recursive);
        return $this;
    }

    final public function getSource(): string
    {
        return $this->source;
    }

    final public function getDestination(): string
    {
        return $this->destination;
    }

    final public function getErrors(): array
    {
        return $this->errors;
    }

    final public function getPublished(): array
    {
        return $this->published;
    }

    final public function addPaths(array $paths, bool $recursive = true)
    {
        foreach ($paths as $path) {
            $this->addPath($path, $recursive);
        }
        return $this;
    }

    final public function addUris(array $uris)
    {
        foreach ($uris as $uri) {
            $this->addUri($uri);
        }
        return $this;
    }

    final public function addUri(string $uri)
    {
        $file = $this->getScratch() . basename((new URI($uri))->getPath());
        write_file($file, service('curlrequest')->get($uri)->getBody());
        return $this->addFile($file);
    }

    final public function getScratch(): string
    {
        if ($this->scratch === null) {
            $this->scratch = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . bin2hex(random_bytes(6)) . DIRECTORY_SEPARATOR;
            mkdir($this->scratch, 0700);
            $this->scratch = realpath($this->scratch) ? realpath($this->scratch) . DIRECTORY_SEPARATOR : $this->scratch;
        }
        return $this->scratch;
    }

    final public function wipe()
    {
        self::wipeDirectory($this->destination);
        return $this;
    }

    public function replace(string $file, array $replaces): bool
    {
        $this->verifyAllowed($file, $file);
        $content = file_get_contents($file);
        $newContent = $this->replacer->replace($content, $replaces);
        $return = file_put_contents($file, $newContent);
        return $return !== false;
    }

    public function addLineAfter(string $file, string $line, string $after): bool
    {
        $this->verifyAllowed($file, $file);
        $content = file_get_contents($file);
        $result = $this->replacer->addAfter($content, $line, $after);
        if ($result !== null) {
            $return = file_put_contents($file, $result);
            return $return !== false;
        }
        return false;
    }

    public function addLineBefore(string $file, string $line, string $before): bool
    {
        $this->verifyAllowed($file, $file);
        $content = file_get_contents($file);
        $result = $this->replacer->addBefore($content, $line, $before);
        if ($result !== null) {
            $return = file_put_contents($file, $result);
            return $return !== false;
        }
        return false;
    }
}