<?php
declare(strict_types=1);

namespace Kint\Zval;

use DateTime;

class DateTimeValue extends InstanceValue
{
    public $dt;
    public $hints = ['object', 'datetime'];

    public function __construct(DateTime $dt)
    {
        parent::__construct();
        $this->dt = clone $dt;
    }

    public function getValueShort(): string
    {
        $stamp = $this->dt->format('Y-m-d H:i:s');
        if ((int)($micro = $this->dt->format('u'))) {
            $stamp .= '.' . $micro;
        }
        $stamp .= $this->dt->format('P T');
        return $stamp;
    }
}