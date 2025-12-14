<?php

namespace Twilio\Rest\Preview\BulkExports;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ExportPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ExportInstance
    {
        return new ExportInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.BulkExports.ExportPage]';
    }
}