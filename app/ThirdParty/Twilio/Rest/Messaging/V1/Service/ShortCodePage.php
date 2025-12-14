<?php

namespace Twilio\Rest\Messaging\V1\Service;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ShortCodePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ShortCodeInstance
    {
        return new ShortCodeInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Messaging.V1.ShortCodePage]';
    }
}