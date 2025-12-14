<?php

namespace Twilio\Rest\Chat\V2\Service\Channel;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class WebhookPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): WebhookInstance
    {
        return new WebhookInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['channelSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Chat.V2.WebhookPage]';
    }
}