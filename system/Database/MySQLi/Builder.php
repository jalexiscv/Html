<?php

namespace Higgs\Database\MySQLi;

use Higgs\Database\BaseBuilder;
use Higgs\Database\Exceptions\DatabaseException;
use Higgs\Database\RawSql;

class Builder extends BaseBuilder
{
    protected $escapeChar = '`';
    protected $supportedIgnoreStatements = ['update' => 'IGNORE', 'insert' => 'IGNORE', 'delete' => 'IGNORE',];

    protected function _fromTables(): string
    {
        if (!empty($this->QBJoin) && count($this->QBFrom) > 1) {
            return '(' . implode(', ', $this->QBFrom) . ')';
        }
        return implode(', ', $this->QBFrom);
    }

    protected function _updateBatch(string $table, array $keys, array $values): string
    {
        $sql = $this->QBOptions['sql'] ?? '';
        if ($sql === '') {
            $constraints = $this->QBOptions['constraints'] ?? [];
            if ($constraints === []) {
                if ($this->db->DBDebug) {
                    throw new DatabaseException('You must specify a constraint to match on for batch updates.');
                }
                return '';
            }
            $updateFields = $this->QBOptions['updateFields'] ?? $this->updateFields($keys, false, $constraints)->QBOptions['updateFields'] ?? [];
            $alias = $this->QBOptions['alias'] ?? '`_u`';
            $sql = 'UPDATE ' . $this->compileIgnore('update') . $table . "\n";
            $sql .= "INNER JOIN (\n{:_table_:}";
            $sql .= ') ' . $alias . "\n";
            $sql .= 'ON ' . implode(' AND ', array_map(static fn($key, $value) => (($value instanceof RawSql && is_string($key)) ? $table . '.' . $key . ' = ' . $value : ($value instanceof RawSql ? $value : $table . '.' . $value . ' = ' . $alias . '.' . $value)), array_keys($constraints), $constraints)) . "\n";
            $sql .= "SET\n";
            $sql .= implode(",\n", array_map(static fn($key, $value) => $table . '.' . $key . ($value instanceof RawSql ? ' = ' . $value : ' = ' . $alias . '.' . $value), array_keys($updateFields), $updateFields));
            $this->QBOptions['sql'] = $sql;
        }
        if (isset($this->QBOptions['setQueryAsData'])) {
            $data = $this->QBOptions['setQueryAsData'];
        } else {
            $data = implode(" UNION ALL\n", array_map(static fn($value) => 'SELECT ' . implode(', ', array_map(static fn($key, $index) => $index . ' ' . $key, $keys, $value)), $values)) . "\n";
        }
        return str_replace('{:_table_:}', $data, $sql);
    }
}