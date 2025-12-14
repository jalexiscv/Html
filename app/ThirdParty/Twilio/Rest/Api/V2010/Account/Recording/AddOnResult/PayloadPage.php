<?php

namespace Twilio\Rest\Api\V2010\Account\Recording\AddOnResult;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class PayloadPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): PayloadInstance
    {
        return new PayloadInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['referenceSid'], $this->solution['addOnResultSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.PayloadPage]';
    }
}