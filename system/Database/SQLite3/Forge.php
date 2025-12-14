<?php

namespace Higgs\Database\SQLite3;

use Higgs\Database\BaseConnection;
use Higgs\Database\Exceptions\DatabaseException;
use Higgs\Database\Forge as BaseForge;

class Forge extends BaseForge
{
    protected $dropIndexStr = 'DROP INDEX %s';
    protected $db;
    protected $_unsigned = false;
    protected $null = 'NULL';

    public function __construct(BaseConnection $db)
    {
        parent::__construct($db);
        if (version_compare($this->db->getVersion(), '3.3', '<')) {
            $this->dropTableIfStr = false;
        }
    }

    public function createDatabase(string $dbName, bool $ifNotExists = false): bool
    {
        return true;
    }

    public function dropDatabase(string $dbName): bool
    {
        if (!is_file($dbName)) {
            if ($this->db->DBDebug) {
                throw new DatabaseException('Unable to drop the specified database.');
            }
            return false;
        }
        $this->db->close();
        if (!@unlink($dbName)) {
            if ($this->db->DBDebug) {
                throw new DatabaseException('Unable to drop the specified database.');
            }
            return false;
        }
        if (!empty($this->db->dataCache['db_names'])) {
            $key = array_search(strtolower($dbName), array_map('strtolower', $this->db->dataCache['db_names']), true);
            if ($key !== false) {
                unset($this->db->dataCache['db_names'][$key]);
            }
        }
        return true;
    }

    public function dropForeignKey(string $table, string $foreignName): bool
    {
        if ($this->db->supportsForeignKeys() !== true) {
            return true;
        }
        $sqlTable = new Table($this->db, $this);
        return $sqlTable->fromTable($this->db->DBPrefix . $table)->dropForeignKey($foreignName)->run();
    }

    public function dropPrimaryKey(string $table, string $keyName = ''): bool
    {
        $sqlTable = new Table($this->db, $this);
        return $sqlTable->fromTable($this->db->DBPrefix . $table)->dropPrimaryKey()->run();
    }

    protected function _alterTable(string $alterType, string $table, $field)
    {
        switch ($alterType) {
            case 'DROP':
                $sqlTable = new Table($this->db, $this);
                $sqlTable->fromTable($table)->dropColumn($field)->run();
                return '';
            case 'CHANGE':
                (new Table($this->db, $this))->fromTable($table)->modifyColumn($field)->run();
                return null;
            default:
                return parent::_alterTable($alterType, $table, $field);
        }
    }

    protected function _processColumn(array $field): string
    {
        if ($field['type'] === 'TEXT' && strpos($field['length'], "('") === 0) {
            $field['type'] .= ' CHECK(' . $this->db->escapeIdentifiers($field['name']) . ' IN ' . $field['length'] . ')';
        }
        return $this->db->escapeIdentifiers($field['name']) . ' ' . $field['type'] . $field['auto_increment'] . $field['null'] . $field['unique'] . $field['default'];
    }

    protected function _attributeType(array &$attributes)
    {
        switch (strtoupper($attributes['TYPE'])) {
            case 'ENUM':
            case 'SET':
                $attributes['TYPE'] = 'TEXT';
                break;
            case 'BOOLEAN':
                $attributes['TYPE'] = 'INT';
                break;
            default:
                break;
        }
    }

    protected function _attributeAutoIncrement(array &$attributes, array &$field)
    {
        if (!empty($attributes['AUTO_INCREMENT']) && $attributes['AUTO_INCREMENT'] === true && stripos($field['type'], 'int') !== false) {
            $field['type'] = 'INTEGER PRIMARY KEY';
            $field['default'] = '';
            $field['null'] = '';
            $field['unique'] = '';
            $field['auto_increment'] = ' AUTOINCREMENT';
            $this->primaryKeys = [];
        }
    }

    protected function _processPrimaryKeys(string $table, bool $asQuery = false): string
    {
        if ($asQuery === false) {
            return parent::_processPrimaryKeys($table, $asQuery);
        }
        $sqlTable = new Table($this->db, $this);
        $sqlTable->fromTable($this->db->DBPrefix . $table)->addPrimaryKey($this->primaryKeys)->run();
        return '';
    }

    protected function _processForeignKeys(string $table, bool $asQuery = false): array
    {
        if ($asQuery === false) {
            return parent::_processForeignKeys($table, $asQuery);
        }
        $errorNames = [];
        foreach ($this->foreignKeys as $name) {
            foreach ($name['field'] as $f) {
                if (!isset($this->fields[$f])) {
                    $errorNames[] = $f;
                }
            }
        }
        if ($errorNames !== []) {
            $errorNames = [implode(', ', $errorNames)];
            throw new DatabaseException(lang('Database.fieldNotExists', $errorNames));
        }
        $sqlTable = new Table($this->db, $this);
        $sqlTable->fromTable($this->db->DBPrefix . $table)->addForeignKey($this->foreignKeys)->run();
        return [];
    }

    public function addForeignKey($fieldName = '', string $tableName = '', $tableField = '', string $onUpdate = '', string $onDelete = '', string $fkName = ''): BaseForge
    {
        if ($fkName === '') {
            return parent::addForeignKey($fieldName, $tableName, $tableField, $onUpdate, $onDelete, $fkName);
        }
        throw new DatabaseException('SQLite does not support foreign key names. Higgs will refer to them in the format: prefix_table_column_referencecolumn_foreign');
    }
}