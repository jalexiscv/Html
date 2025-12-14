<?php

namespace Twilio\Rest\Preview\BulkExports\Export;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ExportCustomJobPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ExportCustomJobInstance
    {
        return new ExportCustomJobInstance($this->version, $payload, $this->solution['resourceType']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.BulkExports.ExportCustomJobPage]';
    }
}