<?php

namespace Twilio\Rest\Conversations\V1\Service\Configuration;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class NotificationPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): NotificationInstance
    {
        return new NotificationInstance($this->version, $payload, $this->solution['chatServiceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.NotificationPage]';
    }
}