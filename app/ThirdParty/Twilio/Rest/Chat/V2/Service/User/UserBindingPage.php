<?php

namespace Twilio\Rest\Chat\V2\Service\User;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class UserBindingPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): UserBindingInstance
    {
        return new UserBindingInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['userSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Chat.V2.UserBindingPage]';
    }
}