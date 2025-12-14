<?php

namespace Higgs\Throttle;
interface ThrottlerInterface
{
    public function check(string $key, int $capacity, int $seconds, int $cost);

    public function getTokenTime(): int;
}