<?php
declare(strict_types=1);

namespace Kint\Zval\Representation;
class SourceRepresentation extends Representation
{
    public $hints = ['source'];
    public $source = [];
    public $filename;
    public $line = 0;
    public $showfilename = false;

    public function __construct(string $filename, int $line, int $padding = 7)
    {
        parent::__construct('Source');
        $this->filename = $filename;
        $this->line = $line;
        $start_line = \max($line - $padding, 1);
        $length = $line + $padding + 1 - $start_line;
        $this->source = self::getSource($filename, $start_line, $length);
        if (null !== $this->source) {
            $this->contents = \implode("\n", $this->source);
        }
    }

    public static function getSource(string $filename, int $start_line = 1, ?int $length = null): ?array
    {
        if (!$filename || !\file_exists($filename) || !\is_readable($filename)) {
            return null;
        }
        $source = \preg_split("/\r\n|\n|\r/", \file_get_contents($filename));
        $source = \array_combine(\range(1, \count($source)), $source);
        $source = \array_slice($source, $start_line - 1, $length, true);
        return $source;
    }
}