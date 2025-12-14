<?php

namespace Twilio\Rest\Api\V2010\Account\Usage\Record;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AllTimePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AllTimeInstance
    {
        return new AllTimeInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AllTimePage]';
    }
}