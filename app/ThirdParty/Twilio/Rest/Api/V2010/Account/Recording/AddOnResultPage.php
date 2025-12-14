<?php

namespace Twilio\Rest\Api\V2010\Account\Recording;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AddOnResultPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AddOnResultInstance
    {
        return new AddOnResultInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['referenceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AddOnResultPage]';
    }
}