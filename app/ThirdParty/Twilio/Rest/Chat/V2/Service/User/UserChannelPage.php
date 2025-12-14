<?php

namespace Twilio\Rest\Chat\V2\Service\User;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class UserChannelPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): UserChannelInstance
    {
        return new UserChannelInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['userSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Chat.V2.UserChannelPage]';
    }
}