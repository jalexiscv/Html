<?php

namespace Twilio\Rest\Bulkexports\V1\Export;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class DayPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): DayInstance
    {
        return new DayInstance($this->version, $payload, $this->solution['resourceType']);
    }

    public function __toString(): string
    {
        return '[Twilio.Bulkexports.V1.DayPage]';
    }
}