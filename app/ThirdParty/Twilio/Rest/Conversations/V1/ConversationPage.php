<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ConversationPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ConversationInstance
    {
        return new ConversationInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.ConversationPage]';
    }
}