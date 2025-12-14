<?php

namespace Higgs\View;

use Config\Services;
use NumberFormatter;

class Filters
{
    public static function capitalize(string $value): string
    {
        return ucfirst(strtolower($value));
    }

    public static function date_modify($value, string $adjustment)
    {
        $value = static::date($value, 'Y-m-d H:i:s');
        return strtotime($adjustment, strtotime($value));
    }

    public static function date($value, string $format): string
    {
        if (is_string($value) && !is_numeric($value)) {
            $value = strtotime($value);
        }
        return date($format, $value);
    }

    public static function default($value, string $default): string
    {
        return empty($value) ? $default : $value;
    }

    public static function esc($value, string $context = 'html'): string
    {
        return esc($value, $context);
    }

    public static function excerpt(string $value, string $phrase, int $radius = 100): string
    {
        helper('text');
        return excerpt($value, $phrase, $radius);
    }

    public static function highlight(string $value, string $phrase): string
    {
        helper('text');
        return highlight_phrase($value, $phrase);
    }

    public static function highlight_code($value): string
    {
        helper('text');
        return highlight_code($value);
    }

    public static function limit_chars($value, int $limit = 500): string
    {
        helper('text');
        return character_limiter($value, $limit);
    }

    public static function limit_words($value, int $limit = 100): string
    {
        helper('text');
        return word_limiter($value, $limit);
    }

    public static function local_number($value, string $type = 'decimal', int $precision = 4, ?string $locale = null): string
    {
        helper('number');
        $types = ['decimal' => NumberFormatter::DECIMAL, 'currency' => NumberFormatter::CURRENCY, 'percent' => NumberFormatter::PERCENT, 'scientific' => NumberFormatter::SCIENTIFIC, 'spellout' => NumberFormatter::SPELLOUT, 'ordinal' => NumberFormatter::ORDINAL, 'duration' => NumberFormatter::DURATION,];
        return format_number($value, $precision, $locale, ['type' => $types[$type]]);
    }

    public static function local_currency($value, string $currency, ?string $locale = null, $fraction = null): string
    {
        helper('number');
        $options = ['type' => NumberFormatter::CURRENCY, 'currency' => $currency, 'fraction' => $fraction,];
        return format_number($value, 2, $locale, $options);
    }

    public static function nl2br(string $value): string
    {
        $typography = Services::typography();
        return $typography->nl2brExceptPre($value);
    }

    public static function prose(string $value): string
    {
        $typography = Services::typography();
        return $typography->autoTypography($value);
    }

    public static function round(string $value, $precision = 2, string $type = 'common')
    {
        if (!is_numeric($precision)) {
            $type = $precision;
            $precision = 2;
        } else {
            $precision = (int)$precision;
        }
        switch ($type) {
            case 'common':
                return round((float)$value, $precision);
            case 'ceil':
                return ceil((float)$value);
            case 'floor':
                return floor((float)$value);
        }
        return $value;
    }

    public static function title(string $value): string
    {
        return ucwords(strtolower($value));
    }
}