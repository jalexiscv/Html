<?php

namespace Twilio\Rest\IpMessaging\V2\Service;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ChannelPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ChannelInstance
    {
        return new ChannelInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.IpMessaging.V2.ChannelPage]';
    }
}