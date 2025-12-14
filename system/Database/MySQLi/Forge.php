<?php

namespace Higgs\Database\MySQLi;

use Higgs\Database\Forge as BaseForge;

class Forge extends BaseForge
{
    protected $createDatabaseStr = 'CREATE DATABASE %s CHARACTER SET %s COLLATE %s';
    protected $createDatabaseIfStr = 'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET %s COLLATE %s';
    protected $dropConstraintStr = 'ALTER TABLE %s DROP FOREIGN KEY %s';
    protected $createTableKeys = true;
    protected $_unsigned = ['TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT', 'INTEGER', 'BIGINT', 'REAL', 'DOUBLE', 'DOUBLE PRECISION', 'FLOAT', 'DECIMAL', 'NUMERIC',];
    protected $_quoted_table_options = ['COMMENT', 'COMPRESSION', 'CONNECTION', 'DATA DIRECTORY', 'INDEX DIRECTORY', 'ENCRYPTION', 'PASSWORD',];
    protected $null = 'NULL';

    public function dropKey(string $table, string $keyName, bool $prefixKeyName = true): bool
    {
        $sql = sprintf($this->dropIndexStr, $this->db->escapeIdentifiers($keyName), $this->db->escapeIdentifiers($this->db->DBPrefix . $table),);
        return $this->db->query($sql);
    }

    public function dropPrimaryKey(string $table, string $keyName = ''): bool
    {
        $sql = sprintf('ALTER TABLE %s DROP PRIMARY KEY', $this->db->escapeIdentifiers($this->db->DBPrefix . $table));
        return $this->db->query($sql);
    }

    protected function _createTableAttributes(array $attributes): string
    {
        $sql = '';
        foreach (array_keys($attributes) as $key) {
            if (is_string($key)) {
                $sql .= ' ' . strtoupper($key) . ' = ';
                if (in_array(strtoupper($key), $this->_quoted_table_options, true)) {
                    $sql .= $this->db->escape($attributes[$key]);
                } else {
                    $sql .= $this->db->escapeString($attributes[$key]);
                }
            }
        }
        if (!empty($this->db->charset) && !strpos($sql, 'CHARACTER SET') && !strpos($sql, 'CHARSET')) {
            $sql .= ' DEFAULT CHARACTER SET = ' . $this->db->escapeString($this->db->charset);
        }
        if (!empty($this->db->DBCollat) && !strpos($sql, 'COLLATE')) {
            $sql .= ' COLLATE = ' . $this->db->escapeString($this->db->DBCollat);
        }
        return $sql;
    }

    protected function _alterTable(string $alterType, string $table, $field)
    {
        if ($alterType === 'DROP') {
            return parent::_alterTable($alterType, $table, $field);
        }
        $sql = 'ALTER TABLE ' . $this->db->escapeIdentifiers($table);
        foreach ($field as $i => $data) {
            if ($data['_literal'] !== false) {
                $field[$i] = ($alterType === 'ADD') ? "\n\tADD " . $data['_literal'] : "\n\tMODIFY " . $data['_literal'];
            } else {
                if ($alterType === 'ADD') {
                    $field[$i]['_literal'] = "\n\tADD ";
                } else {
                    $field[$i]['_literal'] = empty($data['new_name']) ? "\n\tMODIFY " : "\n\tCHANGE ";
                }
                $field[$i] = $field[$i]['_literal'] . $this->_processColumn($field[$i]);
            }
        }
        return [$sql . implode(',', $field)];
    }

    protected function _processColumn(array $field): string
    {
        $extraClause = isset($field['after']) ? ' AFTER ' . $this->db->escapeIdentifiers($field['after']) : '';
        if (empty($extraClause) && isset($field['first']) && $field['first'] === true) {
            $extraClause = ' FIRST';
        }
        return $this->db->escapeIdentifiers($field['name']) . (empty($field['new_name']) ? '' : ' ' . $this->db->escapeIdentifiers($field['new_name'])) . ' ' . $field['type'] . $field['length'] . $field['unsigned'] . $field['null'] . $field['default'] . $field['auto_increment'] . $field['unique'] . (empty($field['comment']) ? '' : ' COMMENT ' . $field['comment']) . $extraClause;
    }

    protected function _processIndexes(string $table, bool $asQuery = false): array
    {
        $sqls = [''];
        $index = 0;
        for ($i = 0, $c = count($this->keys); $i < $c; $i++) {
            $index = $i;
            if ($asQuery === false) {
                $index = 0;
            }
            if (isset($this->keys[$i]['fields'])) {
                for ($i2 = 0, $c2 = count($this->keys[$i]['fields']); $i2 < $c2; $i2++) {
                    if (!isset($this->fields[$this->keys[$i]['fields'][$i2]])) {
                        unset($this->keys[$i]['fields'][$i2]);
                        continue;
                    }
                }
            }
            if (!is_array($this->keys[$i]['fields'])) {
                $this->keys[$i]['fields'] = [$this->keys[$i]['fields']];
            }
            $unique = in_array($i, $this->uniqueKeys, true) ? 'UNIQUE ' : '';
            $keyName = $this->db->escapeIdentifiers(($this->keys[$i]['keyName'] === '') ? implode('_', $this->keys[$i]['fields']) : $this->keys[$i]['keyName']);
            if ($asQuery === true) {
                $sqls[$index] = 'ALTER TABLE ' . $this->db->escapeIdentifiers($table) . " ADD {$unique}KEY " . $keyName . ' (' . implode(', ', $this->db->escapeIdentifiers($this->keys[$i]['fields'])) . ')';
            } else {
                $sqls[$index] .= ",\n\t{$unique}KEY " . $keyName . ' (' . implode(', ', $this->db->escapeIdentifiers($this->keys[$i]['fields'])) . ')';
            }
        }
        $this->keys = [];
        return $sqls;
    }
}