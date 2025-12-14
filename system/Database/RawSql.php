<?php

namespace Higgs\Database;
class RawSql
{
    private string $string;

    public function __construct(string $sqlString)
    {
        $this->string = $sqlString;
    }

    public function __toString(): string
    {
        return $this->string;
    }

    public function with(string $newSqlString): self
    {
        $new = clone $this;
        $new->string = $newSqlString;
        return $new;
    }

    public function getBindingKey(): string
    {
        return 'RawSql' . spl_object_id($this);
    }
}