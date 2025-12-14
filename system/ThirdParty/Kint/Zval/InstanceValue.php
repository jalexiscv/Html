<?php
declare(strict_types=1);

namespace Kint\Zval;
class InstanceValue extends Value
{
    public $type = 'object';
    public $classname;
    public $spl_object_hash;
    public $spl_object_id = null;
    public $filename;
    public $startline;
    public $hints = ['object'];

    public function getType(): ?string
    {
        return $this->classname;
    }

    public function transplant(Value $old): void
    {
        parent::transplant($old);
        if ($old instanceof self) {
            $this->classname = $old->classname;
            $this->spl_object_hash = $old->spl_object_hash;
            $this->spl_object_id = $old->spl_object_id;
            $this->filename = $old->filename;
            $this->startline = $old->startline;
        }
    }

    public static function sortByHierarchy(string $a, string $b): int
    {
        if (\is_subclass_of($a, $b)) {
            return -1;
        }
        if (\is_subclass_of($b, $a)) {
            return 1;
        }
        return 0;
    }
}