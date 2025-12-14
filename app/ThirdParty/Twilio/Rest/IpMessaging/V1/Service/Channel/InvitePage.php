<?php

namespace Twilio\Rest\IpMessaging\V1\Service\Channel;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class InvitePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): InviteInstance
    {
        return new InviteInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['channelSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.IpMessaging.V1.InvitePage]';
    }
}