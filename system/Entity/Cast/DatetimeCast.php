<?php

namespace Higgs\Entity\Cast;

use Higgs\I18n\Time;
use DateTime;
use Exception;

class DatetimeCast extends BaseCast
{
    public static function get($value, array $params = [])
    {
        if ($value instanceof Time) {
            return $value;
        }
        if ($value instanceof DateTime) {
            return Time::createFromInstance($value);
        }
        if (is_numeric($value)) {
            return Time::createFromTimestamp($value);
        }
        if (is_string($value)) {
            return Time::parse($value);
        }
        return $value;
    }
}