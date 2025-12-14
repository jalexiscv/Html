<?php
declare(strict_types=1);

namespace Kint\Zval;
class BlobValue extends Value
{
    public static $char_encodings = ['ASCII', 'UTF-8',];
    public static $legacy_encodings = [];
    public $type = 'string';
    public $encoding = false;
    public $hints = ['string'];

    public function getType(): ?string
    {
        if (false === $this->encoding) {
            return 'binary ' . $this->type;
        }
        if ('ASCII' === $this->encoding) {
            return $this->type;
        }
        return $this->encoding . ' ' . $this->type;
    }

    public function getValueShort(): ?string
    {
        if ($rep = $this->value) {
            return '"' . $rep->contents . '"';
        }
        return null;
    }

    public function transplant(Value $old): void
    {
        parent::transplant($old);
        if ($old instanceof self) {
            $this->encoding = $old->encoding;
        }
    }

    public static function strlen(string $string, $encoding = false): int
    {
        if (\function_exists('mb_strlen')) {
            if (false === $encoding) {
                $encoding = self::detectEncoding($string);
            }
            if ($encoding && 'ASCII' !== $encoding) {
                return \mb_strlen($string, $encoding);
            }
        }
        return \strlen($string);
    }

    public static function substr(string $string, int $start, ?int $length = null, $encoding = false): string
    {
        if (\function_exists('mb_substr')) {
            if (false === $encoding) {
                $encoding = self::detectEncoding($string);
            }
            if ($encoding && 'ASCII' !== $encoding) {
                return \mb_substr($string, $start, $length, $encoding);
            }
        }
        if ('' === $string) {
            return '';
        }
        return \substr($string, $start, $length ?? PHP_INT_MAX);
    }

    public static function detectEncoding(string $string)
    {
        if (\function_exists('mb_detect_encoding')) {
            if ($ret = \mb_detect_encoding($string, self::$char_encodings, true)) {
                return $ret;
            }
        }
        if (\preg_match('/[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]/', $string)) {
            return false;
        }
        if (\function_exists('iconv')) {
            foreach (self::$legacy_encodings as $encoding) {
                if (@\iconv($encoding, $encoding, $string) === $string) {
                    return $encoding;
                }
            }
        } elseif (!\function_exists('mb_detect_encoding')) {
            return 'ASCII';
        }
        return false;
    }
}