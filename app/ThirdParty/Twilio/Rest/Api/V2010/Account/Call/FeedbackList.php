<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\ListResource;
use Twilio\Version;

class FeedbackList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $callSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'callSid' => $callSid,];
    }

    public function getContext(): FeedbackContext
    {
        return new FeedbackContext($this->version, $this->solution['accountSid'], $this->solution['callSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.FeedbackList]';
    }
}