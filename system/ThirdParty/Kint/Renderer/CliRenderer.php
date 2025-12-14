<?php
declare(strict_types=1);

namespace Kint\Renderer;

use Kint\Zval\Value;
use Throwable;

class CliRenderer extends TextRenderer
{
    public static $cli_colors = true;
    public static $force_utf8 = false;
    public static $detect_width = true;
    public static $min_terminal_width = 40;
    public static $windows_stream = null;
    protected static $terminal_width = null;
    protected $windows_output = false;
    protected $colors = false;

    public function __construct()
    {
        parent::__construct();
        if (!self::$force_utf8 && KINT_WIN) {
            if (!KINT_PHP72 || !\function_exists('sapi_windows_vt100_support')) {
                $this->windows_output = true;
            } else {
                $stream = self::$windows_stream;
                if (!$stream && \defined('STDOUT')) {
                    $stream = STDOUT;
                }
                if (!$stream) {
                    $this->windows_output = true;
                } else {
                    $this->windows_output = !\sapi_windows_vt100_support($stream);
                }
            }
        }
        if (!self::$terminal_width) {
            if (!KINT_WIN && self::$detect_width) {
                try {
                    self::$terminal_width = (int)\exec('tput cols');
                } catch (Throwable $t) {
                    self::$terminal_width = self::$default_width;
                }
            }
            if (self::$terminal_width < self::$min_terminal_width) {
                self::$terminal_width = self::$default_width;
            }
        }
        $this->colors = $this->windows_output ? false : self::$cli_colors;
        $this->header_width = self::$terminal_width;
    }

    public function colorValue(string $string): string
    {
        if (!$this->colors) {
            return $string;
        }
        return "\x1b[32m" . \str_replace("\n", "\x1b[0m\n\x1b[32m", $string) . "\x1b[0m";
    }

    public function colorType(string $string): string
    {
        if (!$this->colors) {
            return $string;
        }
        return "\x1b[35;1m" . \str_replace("\n", "\x1b[0m\n\x1b[35;1m", $string) . "\x1b[0m";
    }

    public function colorTitle(string $string): string
    {
        if (!$this->colors) {
            return $string;
        }
        return "\x1b[36m" . \str_replace("\n", "\x1b[0m\n\x1b[36m", $string) . "\x1b[0m";
    }

    public function renderTitle(Value $o): string
    {
        if ($this->windows_output) {
            return $this->utf8ToWindows(parent::renderTitle($o));
        }
        return parent::renderTitle($o);
    }

    public function preRender(): string
    {
        return PHP_EOL;
    }

    public function postRender(): string
    {
        if ($this->windows_output) {
            return $this->utf8ToWindows(parent::postRender());
        }
        return parent::postRender();
    }

    public function escape(string $string, $encoding = false): string
    {
        return \str_replace("\x1b", '\\x1b', $string);
    }

    protected function utf8ToWindows(string $string): string
    {
        return \str_replace(['┌', '═', '┐', '│', '└', '─', '┘'], [' ', '=', ' ', '|', ' ', '-', ' '], $string);
    }
}