<?php

namespace Higgs\Test\Mock;

use Tests\Support\Log\Handlers\TestHandler;

class MockLogger
{
    public $threshold = 9;
    public $dateFormat = 'Y-m-d';
    public $handlers = [TestHandler::class => ['handles' => ['critical', 'alert', 'emergency', 'debug', 'error', 'info', 'notice', 'warning',], 'path' => '',],];
}