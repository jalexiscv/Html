<?php

namespace Higgs\Database;
interface QueryInterface
{
    public function setQuery(string $sql, $binds = null, bool $setEscape = true);

    public function getQuery();

    public function setDuration(float $start, ?float $end = null);

    public function getDuration(int $decimals = 6): string;

    public function setError(int $code, string $error);

    public function hasError(): bool;

    public function getErrorCode(): int;

    public function getErrorMessage(): string;

    public function isWriteType(): bool;

    public function swapPrefix(string $orig, string $swap);
}