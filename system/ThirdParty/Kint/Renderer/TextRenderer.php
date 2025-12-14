<?php
declare(strict_types=1);

namespace Kint\Renderer;

use Kint\Kint;
use Kint\Parser;
use Kint\Renderer\Text\PluginInterface;
use Kint\Utils;
use Kint\Zval\InstanceValue;
use Kint\Zval\Value;

class TextRenderer extends AbstractRenderer
{
    public static $plugins = ['array_limit' => Text\ArrayLimitPlugin::class, 'blacklist' => Text\BlacklistPlugin::class, 'depth_limit' => Text\DepthLimitPlugin::class, 'enum' => Text\EnumPlugin::class, 'microtime' => Text\MicrotimePlugin::class, 'recursion' => Text\RecursionPlugin::class, 'trace' => Text\TracePlugin::class,];
    public static $parser_plugin_whitelist = [Parser\ArrayLimitPlugin::class, Parser\ArrayObjectPlugin::class, Parser\BlacklistPlugin::class, Parser\EnumPlugin::class, Parser\MicrotimePlugin::class, Parser\StreamPlugin::class, Parser\TracePlugin::class,];
    public static $strlen_max = 0;
    public static $default_width = 80;
    public static $default_indent = 4;
    public static $decorations = true;
    public static $sort = self::SORT_NONE;
    public $header_width = 80;
    public $indent_width = 4;
    protected $plugin_objs = [];

    public function __construct()
    {
        $this->header_width = self::$default_width;
        $this->indent_width = self::$default_indent;
    }

    public function render(Value $o): string
    {
        if ($plugin = $this->getPlugin(self::$plugins, $o->hints)) {
            $output = $plugin->render($o);
            if (null !== $output && \strlen($output)) {
                return $output;
            }
        }
        $out = '';
        if (0 == $o->depth) {
            $out .= $this->colorTitle($this->renderTitle($o)) . PHP_EOL;
        }
        $out .= $this->renderHeader($o);
        $out .= $this->renderChildren($o) . PHP_EOL;
        return $out;
    }

    protected function getPlugin(array $plugins, array $hints): ?PluginInterface
    {
        if ($plugins = $this->matchPlugins($plugins, $hints)) {
            $plugin = \end($plugins);
            if (!isset($this->plugin_objs[$plugin]) && \is_subclass_of($plugin, PluginInterface::class)) {
                $this->plugin_objs[$plugin] = new $plugin($this);
            }
            return $this->plugin_objs[$plugin];
        }
        return null;
    }

    public function colorTitle(string $string): string
    {
        return $string;
    }

    public function renderTitle(Value $o): string
    {
        $name = (string)$o->getName();
        if (self::$decorations) {
            return $this->boxText($name, $this->header_width);
        }
        return Utils::truncateString($name, $this->header_width);
    }

    public function boxText(string $text, int $width): string
    {
        $out = '┌' . \str_repeat('─', $width - 2) . '┐' . PHP_EOL;
        if (\strlen($text)) {
            $text = Utils::truncateString($text, $width - 4);
            $text = \str_pad($text, $width - 4);
            $out .= '│ ' . $this->escape($text) . ' │' . PHP_EOL;
        }
        $out .= '└' . \str_repeat('─', $width - 2) . '┘';
        return $out;
    }

    public function escape(string $string, $encoding = false): string
    {
        return $string;
    }

    public function renderHeader(Value $o): string
    {
        $output = [];
        if ($o->depth) {
            if (null !== ($s = $o->getModifiers())) {
                $output[] = $s;
            }
            if (null !== $o->name) {
                $output[] = $this->escape(\var_export($o->name, true));
                if (null !== ($s = $o->getOperator())) {
                    $output[] = $this->escape($s);
                }
            }
        }
        if (null !== ($s = $o->getType())) {
            if ($o->reference) {
                $s = '&' . $s;
            }
            $s = $this->colorType($this->escape($s));
            if ($o instanceof InstanceValue && isset($o->spl_object_id)) {
                $s .= '#' . ((int)$o->spl_object_id);
            }
            $output[] = $s;
        }
        if (null !== ($s = $o->getSize())) {
            $output[] = '(' . $this->escape($s) . ')';
        }
        if (null !== ($s = $o->getValueShort())) {
            if (self::$strlen_max) {
                $s = Utils::truncateString($s, self::$strlen_max);
            }
            $output[] = $this->colorValue($this->escape($s));
        }
        return \str_repeat(' ', $o->depth * $this->indent_width) . \implode(' ', $output);
    }

    public function colorType(string $string): string
    {
        return $string;
    }

    public function colorValue(string $string): string
    {
        return $string;
    }

    public function renderChildren(Value $o): string
    {
        if ('array' === $o->type) {
            $output = ' [';
        } elseif ('object' === $o->type) {
            $output = ' (';
        } else {
            return '';
        }
        $children = '';
        if ($o->value && \is_array($o->value->contents)) {
            if ($o instanceof InstanceValue && 'properties' === $o->value->getName()) {
                foreach (self::sortProperties($o->value->contents, self::$sort) as $obj) {
                    $children .= $this->render($obj);
                }
            } else {
                foreach ($o->value->contents as $child) {
                    $children .= $this->render($child);
                }
            }
        }
        if ($children) {
            $output .= PHP_EOL . $children;
            $output .= \str_repeat(' ', $o->depth * $this->indent_width);
        }
        if ('array' === $o->type) {
            $output .= ']';
        } else {
            $output .= ')';
        }
        return $output;
    }

    public function renderNothing(): string
    {
        if (self::$decorations) {
            return $this->colorTitle($this->boxText('No argument', $this->header_width)) . PHP_EOL;
        }
        return $this->colorTitle('No argument') . PHP_EOL;
    }

    public function postRender(): string
    {
        if (self::$decorations) {
            $output = \str_repeat('═', $this->header_width);
        } else {
            $output = '';
        }
        if (!$this->show_trace) {
            return $this->colorTitle($output);
        }
        if ($output) {
            $output .= PHP_EOL;
        }
        return $this->colorTitle($output . $this->calledFrom() . PHP_EOL);
    }

    protected function calledFrom(): string
    {
        $output = '';
        if (isset($this->call_info['callee']['file'])) {
            $output .= 'Called from ' . $this->ideLink($this->call_info['callee']['file'], $this->call_info['callee']['line']);
        }
        if (isset($this->call_info['callee']['function']) && (!empty($this->call_info['callee']['class']) || !\in_array($this->call_info['callee']['function'], ['include', 'include_once', 'require', 'require_once'], true))) {
            $output .= ' [';
            $output .= $this->call_info['callee']['class'] ?? '';
            $output .= $this->call_info['callee']['type'] ?? '';
            $output .= $this->call_info['callee']['function'] . '()]';
        }
        return $output;
    }

    public function ideLink(string $file, int $line): string
    {
        return $this->escape(Kint::shortenPath($file)) . ':' . $line;
    }

    public function filterParserPlugins(array $plugins): array
    {
        $return = [];
        foreach ($plugins as $index => $plugin) {
            foreach (self::$parser_plugin_whitelist as $whitelist) {
                if ($plugin instanceof $whitelist) {
                    $return[] = $plugin;
                    continue 2;
                }
            }
        }
        return $return;
    }
}