<?php

namespace Twilio\Rest\Api\V2010\Account\Message;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FeedbackPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FeedbackInstance
    {
        return new FeedbackInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['messageSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.FeedbackPage]';
    }
}