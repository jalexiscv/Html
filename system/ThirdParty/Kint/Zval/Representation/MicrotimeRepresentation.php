<?php
declare(strict_types=1);

namespace Kint\Zval\Representation;

use DateTime;

class MicrotimeRepresentation extends Representation
{
    public $seconds;
    public $microseconds;
    public $group;
    public $lap;
    public $total;
    public $avg;
    public $i = 0;
    public $mem = 0;
    public $mem_real = 0;
    public $mem_peak = 0;
    public $mem_peak_real = 0;
    public $hints = ['microtime'];

    public function __construct(int $seconds, int $microseconds, int $group, ?float $lap = null, ?float $total = null, int $i = 0)
    {
        parent::__construct('Microtime');
        $this->seconds = $seconds;
        $this->microseconds = $microseconds;
        $this->group = $group;
        $this->lap = $lap;
        $this->total = $total;
        $this->i = $i;
        if ($i) {
            $this->avg = $total / $i;
        }
        $this->mem = \memory_get_usage();
        $this->mem_real = \memory_get_usage(true);
        $this->mem_peak = \memory_get_peak_usage();
        $this->mem_peak_real = \memory_get_peak_usage(true);
    }

    public function getDateTime(): ?DateTime
    {
        return DateTime::createFromFormat('U u', $this->seconds . ' ' . \str_pad((string)$this->microseconds, 6, '0', STR_PAD_LEFT)) ?: null;
    }
}