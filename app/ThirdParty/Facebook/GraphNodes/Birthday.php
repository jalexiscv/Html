<?php

namespace Facebook\GraphNodes;

use DateTime;

class Birthday extends DateTime
{
    private $hasDate = false;
    private $hasYear = false;

    public function __construct($date)
    {
        $parts = explode('/', $date);
        $this->hasYear = count($parts) === 3 || count($parts) === 1;
        $this->hasDate = count($parts) === 3 || count($parts) === 2;
        parent::__construct($date);
    }

    public function hasDate()
    {
        return $this->hasDate;
    }

    public function hasYear()
    {
        return $this->hasYear;
    }
}