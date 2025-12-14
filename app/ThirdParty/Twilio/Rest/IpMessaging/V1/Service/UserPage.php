<?php

namespace Twilio\Rest\IpMessaging\V1\Service;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class UserPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): UserInstance
    {
        return new UserInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.IpMessaging.V1.UserPage]';
    }
}