<?php

namespace Twilio\Rest\Bulkexports\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ExportConfigurationPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ExportConfigurationInstance
    {
        return new ExportConfigurationInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Bulkexports.V1.ExportConfigurationPage]';
    }
}