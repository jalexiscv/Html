<?php

namespace App\Libraries;

use ErrorException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use const E_WARNING;

class Minifiers
{

    protected $options
        = array(
            'source' => 'module/', // string
            'target' => 'modulemin/', // string
            'banner' => '', // string
            'extensions' => array('inc', 'php', 'phtml'), // string[]
            'exclusions' => array('md'), // string[]
        );
    protected $lastError;

    public function __construct(array $options = array())
    {
        $this->options = array_merge($this->options, $options);
    }

    public function setSource($source)
    {
        $this->options['source'] = $source;
        return $this;
    }

    public function setTarget($target)
    {
        $this->options['target'] = $target;
        return $this;
    }

    public function setBanner($banner)
    {
        $this->options['banner'] = $banner;
        return $this;
    }

    public function setExtensions(array $extensions)
    {
        $this->options['extensions'] = $extensions;
        return $this;
    }

    public function setExclusions(array $extensions)
    {
        $this->options['exclusions'] = $extensions;
        return $this;
    }

    public function run()
    {
        $return = array();
        $dirIterator = new RecursiveDirectoryIterator($this->getSource());
        $iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $key => $value) {
            if (in_array($value->getFilename(), array('..', '.DS_Store'))) { // Exclude system
                continue;
            }

            $pattern = '/^' . preg_quote($this->getSource(), '/') . '/';
            $sourcePathname = $this->fixSlashes($value->getPathname());
            $targetPathname = preg_replace($pattern, $this->getTarget(), $sourcePathname);
            if ($value->isDir()) {
                if ($value->getBasename() == '.') {
                    $dirname = dirname($targetPathname);
                    if (!is_dir($dirname)) {
                        $this->errorStart();
                        $res = mkdir($dirname, 0777, true);
                        $this->errorStop();
                        if (!$res) {
                            throw new RuntimeException("mkdir('{$dirname}') failed", 0, $this->getLastError());
                        }
                    }
                    $return[$value->getPath()] = $dirname;
                }
                continue;
            }
            if ($value->isFile() && !in_array(strtolower($value->getExtension()), $this->getExclusions())) {
                if (in_array(strtolower($value->getExtension()), $this->getExtensions())) {
                    $this->errorStart();
                    $res = file_put_contents($targetPathname, $this->minify($sourcePathname));
                    $this->errorStop();
                    if (false === $res) {
                        throw new RuntimeException("file_put_contents('{$targetPathname}', '...') failed", 0, $this->getLastError());
                    }
                } else {
                    $this->errorStart();
                    $res = copy($sourcePathname, $targetPathname);
                    $this->errorStop();
                    if (!$res) {
                        throw new RuntimeException("copy('{$sourcePathname}', '{$targetPathname}') failed", 0, $this->getLastError());
                    }
                }
                $return[$sourcePathname] = $targetPathname;
            }
        } // for
        return $return;
    }

    public function getSource()
    {
        return $this->fixSlashes($this->options['source']);
    }

    public function fixSlashes($filename)
    {
        if (DIRECTORY_SEPARATOR != '/') {
            return str_replace(DIRECTORY_SEPARATOR, '/', $filename);
        }
        return $filename;
    }

    public function getTarget()
    {
        return $this->fixSlashes($this->options['target']);
    }

    public function errorStart($errorLevel = E_WARNING)
    {
        set_error_handler(array($this, 'addError'), $errorLevel);
    }

    public function errorStop()
    {
        restore_error_handler();
    }

    public function getLastError()
    {
        return $this->lastError;
    }

    public function getExclusions()
    {
        return $this->options['exclusions'];
    }

    public function getExtensions()
    {
        return $this->options['extensions'];
    }

    public function minify($filename)
    {
        $string = php_strip_whitespace($filename);
        if ($this->getBanner()) {
            $string = preg_replace('/^<\?php/', '<?php ' . $this->getBanner(), $string);
        }
        return $string;
    }

    public function getBanner()
    {
        $version = "1." . random_int(0, 9) . "." . random_int(0, 9);
        $banner = sprintf($this->options['banner'], $version);
        return $banner;
    }

    public function addError($errno, $errstr = '', $errfile = '', $errline = 0)
    {
        $this->lastError = new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

}

?>