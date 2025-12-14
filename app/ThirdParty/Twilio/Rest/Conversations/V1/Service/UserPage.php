<?php

namespace Twilio\Rest\Conversations\V1\Service;

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
        return new UserInstance($this->version, $payload, $this->solution['chatServiceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.UserPage]';
    }
}