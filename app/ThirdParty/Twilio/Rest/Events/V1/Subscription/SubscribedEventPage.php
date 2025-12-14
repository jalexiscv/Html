<?php

namespace Twilio\Rest\Events\V1\Subscription;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SubscribedEventPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SubscribedEventInstance
    {
        return new SubscribedEventInstance($this->version, $payload, $this->solution['subscriptionSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Events.V1.SubscribedEventPage]';
    }
}