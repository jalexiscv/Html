<?php

namespace Twilio\Rest\Api\V2010\Account\Queue;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class MemberPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): MemberInstance
    {
        return new MemberInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['queueSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.MemberPage]';
    }
}