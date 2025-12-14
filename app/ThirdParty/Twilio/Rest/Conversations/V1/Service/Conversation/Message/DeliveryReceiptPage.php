<?php

namespace Twilio\Rest\Conversations\V1\Service\Conversation\Message;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class DeliveryReceiptPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): DeliveryReceiptInstance
    {
        return new DeliveryReceiptInstance($this->version, $payload, $this->solution['chatServiceSid'], $this->solution['conversationSid'], $this->solution['messageSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.DeliveryReceiptPage]';
    }
}