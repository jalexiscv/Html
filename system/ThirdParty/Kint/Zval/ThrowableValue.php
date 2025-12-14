<?php
declare(strict_types=1);

namespace Kint\Zval;

use Throwable;

class ThrowableValue extends InstanceValue
{
    public $message;
    public $hints = ['object', 'throwable'];

    public function __construct(Throwable $throw)
    {
        parent::__construct();
        $this->message = $throw->getMessage();
    }

    public function getValueShort(): ?string
    {
        if (\strlen($this->message)) {
            return '"' . $this->message . '"';
        }
        return null;
    }
}