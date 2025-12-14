<?php
declare(strict_types=1);

namespace Kint\Zval\Representation;
class MethodDefinitionRepresentation extends Representation
{
    public $file;
    public $line;
    public $class;
    public $inherited = false;
    public $hints = ['method_definition'];

    public function __construct(?string $file, ?int $line, ?string $class, ?string $docstring)
    {
        parent::__construct('Method definition');
        $this->file = $file;
        $this->line = $line;
        $this->class = $class;
        $this->contents = $docstring;
    }

    public function getDocstringWithoutComments()
    {
        if (!$this->contents) {
            return null;
        }
        $string = \substr($this->contents, 3, -2);
        $string = \preg_replace('/^\\s*\\*\\s*?(\\S|$)/m', '\\1', $string);
        return \trim($string);
    }
}