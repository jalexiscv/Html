<?php

namespace Twilio\Rest\IpMessaging\V2\Service\Channel;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class MessagePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): MessageInstance
    {
        return new MessageInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['channelSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.IpMessaging.V2.MessagePage]';
    }
}