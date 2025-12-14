<?php

namespace Twilio;

use DateTime;
use DateTimeZone;
use Exception;

class Deserialize
{
    public static function dateTime(?string $s)
    {
        try {
            if ($s) {
                return new DateTime($s, new DateTimeZone('UTC'));
            }
        } catch (Exception $e) {
        }
        return $s;
    }
}