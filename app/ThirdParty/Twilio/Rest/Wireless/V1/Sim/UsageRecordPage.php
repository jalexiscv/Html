<?php

namespace Twilio\Rest\Wireless\V1\Sim;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class UsageRecordPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): UsageRecordInstance
    {
        return new UsageRecordInstance($this->version, $payload, $this->solution['simSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Wireless.V1.UsageRecordPage]';
    }
}