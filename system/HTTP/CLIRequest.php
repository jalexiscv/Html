<?php

namespace Higgs\HTTP;

use Config\App;
use Locale;
use RuntimeException;

class CLIRequest extends Request
{
    protected $segments = [];
    protected $options = [];
    protected $args = [];
    protected $method = 'cli';

    public function __construct(App $config)
    {
        if (!is_cli()) {
            throw new RuntimeException(static::class . ' needs to run from the command line.');
        }
        parent::__construct($config);
        ignore_user_abort(true);
        $this->parseCommand();
    }

    protected function parseCommand()
    {
        $args = $this->getServer('argv');
        array_shift($args);
        $optionValue = false;
        foreach ($args as $i => $arg) {
            if (mb_strpos($arg, '-') !== 0) {
                if ($optionValue) {
                    $optionValue = false;
                } else {
                    $this->segments[] = $arg;
                    $this->args[] = $arg;
                }
                continue;
            }
            $arg = ltrim($arg, '-');
            $value = null;
            if (isset($args[$i + 1]) && mb_strpos($args[$i + 1], '-') !== 0) {
                $value = $args[$i + 1];
                $optionValue = true;
            }
            $this->options[$arg] = $value;
            $this->args[$arg] = $value;
        }
    }

    public function getPath(): string
    {
        $path = implode('/', $this->segments);
        return empty($path) ? '' : $path;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function getSegments(): array
    {
        return $this->segments;
    }

    public function getOption(string $key)
    {
        return $this->options[$key] ?? null;
    }

    public function getOptionString(bool $useLongOpts = false): string
    {
        if (empty($this->options)) {
            return '';
        }
        $out = '';
        foreach ($this->options as $name => $value) {
            if ($useLongOpts && mb_strlen($name) > 1) {
                $out .= "--{$name} ";
            } else {
                $out .= "-{$name} ";
            }
            if ($value === null) {
                continue;
            }
            if (mb_strpos($value, ' ') !== false) {
                $out .= '"' . $value . '" ';
            } else {
                $out .= "{$value} ";
            }
        }
        return trim($out);
    }

    public function isCLI(): bool
    {
        return true;
    }

    public function getGet($index = null, $filter = null, $flags = null)
    {
        return $this->returnNullOrEmptyArray($index);
    }

    private function returnNullOrEmptyArray($index)
    {
        return ($index === null || is_array($index)) ? [] : null;
    }

    public function getPost($index = null, $filter = null, $flags = null)
    {
        return $this->returnNullOrEmptyArray($index);
    }

    public function getPostGet($index = null, $filter = null, $flags = null)
    {
        return $this->returnNullOrEmptyArray($index);
    }

    public function getGetPost($index = null, $filter = null, $flags = null)
    {
        return $this->returnNullOrEmptyArray($index);
    }

    public function getCookie($index = null, $filter = null, $flags = null)
    {
        return $this->returnNullOrEmptyArray($index);
    }

    public function getLocale(): string
    {
        return Locale::getDefault();
    }

    public function is(string $type): bool
    {
        return false;
    }
}