<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class KeyPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): KeyInstance
    {
        return new KeyInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.KeyPage]';
    }
}