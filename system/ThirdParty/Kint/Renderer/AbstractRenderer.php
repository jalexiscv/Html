<?php
declare(strict_types=1);

namespace Kint\Renderer;

use Kint\Zval\InstanceValue;
use Kint\Zval\Value;

abstract class AbstractRenderer implements RendererInterface
{
    public const SORT_NONE = 0;
    public const SORT_VISIBILITY = 1;
    public const SORT_FULL = 2;
    protected $call_info = [];
    protected $statics = [];
    protected $show_trace = true;

    public function setCallInfo(array $info): void
    {
        if (!isset($info['modifiers']) || !\is_array($info['modifiers'])) {
            $info['modifiers'] = [];
        }
        if (!isset($info['trace']) || !\is_array($info['trace'])) {
            $info['trace'] = [];
        }
        $this->call_info = ['params' => $info['params'] ?? null, 'modifiers' => $info['modifiers'], 'callee' => $info['callee'] ?? null, 'caller' => $info['caller'] ?? null, 'trace' => $info['trace'],];
    }

    public function getCallInfo(): array
    {
        return $this->call_info;
    }

    public function setStatics(array $statics): void
    {
        $this->statics = $statics;
        $this->setShowTrace(!empty($statics['display_called_from']));
    }

    public function getStatics(): array
    {
        return $this->statics;
    }

    public function setShowTrace(bool $show_trace): void
    {
        $this->show_trace = $show_trace;
    }

    public function getShowTrace(): bool
    {
        return $this->show_trace;
    }

    public function filterParserPlugins(array $plugins): array
    {
        return $plugins;
    }

    public function preRender(): string
    {
        return '';
    }

    public function postRender(): string
    {
        return '';
    }

    public function matchPlugins(array $plugins, array $hints): array
    {
        $out = [];
        foreach ($hints as $key) {
            if (isset($plugins[$key])) {
                $out[$key] = $plugins[$key];
            }
        }
        return $out;
    }

    public static function sortPropertiesFull(Value $a, Value $b): int
    {
        $sort = Value::sortByAccess($a, $b);
        if ($sort) {
            return $sort;
        }
        $sort = Value::sortByName($a, $b);
        if ($sort) {
            return $sort;
        }
        return InstanceValue::sortByHierarchy($a->owner_class, $b->owner_class);
    }

    public static function sortProperties(array $contents, int $sort): array
    {
        switch ($sort) {
            case self::SORT_VISIBILITY:
                $containers = [Value::ACCESS_PUBLIC => [], Value::ACCESS_PROTECTED => [], Value::ACCESS_PRIVATE => [], Value::ACCESS_NONE => [],];
                foreach ($contents as $item) {
                    $containers[$item->access][] = $item;
                }
                return \call_user_func_array('array_merge', $containers);
            case self::SORT_FULL:
                \usort($contents, [self::class, 'sortPropertiesFull']);
            default:
                return $contents;
        }
    }
}