<?php

namespace Higgs\Test\Mock;

use Higgs\Email\Email;
use Higgs\Events\Events;

class MockEmail extends Email
{
    public $returnValue = true;

    public function send($autoClear = true)
    {
        if ($this->returnValue) {
            $this->setArchiveValues();
            if ($autoClear) {
                $this->clear();
            }
            Events::trigger('email', $this->archive);
        }
        return $this->returnValue;
    }
}