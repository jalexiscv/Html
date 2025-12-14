<?php

namespace Facebook\GraphNodes;

use DateTime;

class GraphNode extends Collection
{
    protected static $graphObjectMap = [];

    public function __construct(array $data = [])
    {
        parent::__construct($this->castItems($data));
    }

    public function castItems(array $data)
    {
        $items = [];
        foreach ($data as $k => $v) {
            if ($this->shouldCastAsDateTime($k) && (is_numeric($v) || $this->isIso8601DateString($v))) {
                $items[$k] = $this->castToDateTime($v);
            } elseif ($k === 'birthday') {
                $items[$k] = $this->castToBirthday($v);
            } else {
                $items[$k] = $v;
            }
        }
        return $items;
    }

    public function uncastItems()
    {
        $items = $this->asArray();
        return array_map(function ($v) {
            if ($v instanceof DateTime) {
                return $v->format(DateTime::ISO8601);
            }
            return $v;
        }, $items);
    }

    public function asJson($options = 0)
    {
        return json_encode($this->uncastItems(), $options);
    }

    public function isIso8601DateString($string)
    {
        $crazyInsaneRegexThatSomehowDetectsIso8601 = '/^([\+-]?\d{4}(?!\d{2}\b))' . '((-?)((0[1-9]|1[0-2])(\3([12]\d|0[1-9]|3[01]))?' . '|W([0-4]\d|5[0-2])(-?[1-7])?|(00[1-9]|0[1-9]\d' . '|[12]\d{2}|3([0-5]\d|6[1-6])))([T\s]((([01]\d|2[0-3])' . '((:?)[0-5]\d)?|24\:?00)([\.,]\d+(?!:))?)?(\17[0-5]\d' . '([\.,]\d+)?)?([zZ]|([\+-])([01]\d|2[0-3]):?([0-5]\d)?)?)?)?$/';
        return preg_match($crazyInsaneRegexThatSomehowDetectsIso8601, $string) === 1;
    }

    public function shouldCastAsDateTime($key)
    {
        return in_array($key, ['created_time', 'updated_time', 'start_time', 'end_time', 'backdated_time', 'issued_at', 'expires_at', 'publish_time', 'joined'], true);
    }

    public function castToDateTime($value)
    {
        if (is_int($value)) {
            $dt = new DateTime();
            $dt->setTimestamp($value);
        } else {
            $dt = new DateTime($value);
        }
        return $dt;
    }

    public function castToBirthday($value)
    {
        return new Birthday($value);
    }

    public static function getObjectMap()
    {
        return static::$graphObjectMap;
    }
}