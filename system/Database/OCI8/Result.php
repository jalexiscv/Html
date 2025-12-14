<?php

namespace Higgs\Database\OCI8;

use Higgs\Database\BaseResult;
use Higgs\Entity\Entity;

class Result extends BaseResult
{
    public function getFieldNames(): array
    {
        return array_map(fn($fieldIndex) => oci_field_name($this->resultID, $fieldIndex), range(1, $this->getFieldCount()));
    }

    public function getFieldCount(): int
    {
        return oci_num_fields($this->resultID);
    }

    public function getFieldData(): array
    {
        return array_map(fn($fieldIndex) => (object)['name' => oci_field_name($this->resultID, $fieldIndex), 'type' => oci_field_type($this->resultID, $fieldIndex), 'max_length' => oci_field_size($this->resultID, $fieldIndex),], range(1, $this->getFieldCount()));
    }

    public function freeResult()
    {
        if (is_resource($this->resultID)) {
            oci_free_statement($this->resultID);
            $this->resultID = false;
        }
    }

    public function dataSeek(int $n = 0)
    {
        return false;
    }

    protected function fetchAssoc()
    {
        return oci_fetch_assoc($this->resultID);
    }

    protected function fetchObject(string $className = 'stdClass')
    {
        $row = oci_fetch_object($this->resultID);
        if ($className === 'stdClass' || !$row) {
            return $row;
        }
        if (is_subclass_of($className, Entity::class)) {
            return (new $className())->setAttributes((array)$row);
        }
        $instance = new $className();
        foreach (get_object_vars($row) as $key => $value) {
            $instance->{$key} = $value;
        }
        return $instance;
    }
}