<?php

namespace Ayeo\Barcode\Response;

use Ayeo\Barcode\Printer;

abstract class Response
{
    /**
     * @var Printer
     */
    private $printer;

    public function __construct(Printer $printer)
    {
        $this->printer = $printer;
    }

    /**
     * @param string $text
     * @param string $filename
     * @param bool $withLabel
     * @param string $disposition
     * @return void
     */
    public function output($text, $filename, $withLabel, $disposition = 'inline')
    {
        header(sprintf('Content-Type: %s', $this->getType()));
        header(sprintf('Content-Disposition: %s;filename=%s', $disposition, $filename));
        imagepng($this->printer->getResource($text, $withLabel));
    }

    abstract function getType();
}
