<?php

namespace Twilio\Rest\Conversations\V1\Service\Configuration;

use Twilio\ListResource;
use Twilio\Version;

class NotificationList extends ListResource
{
    public function __construct(Version $version, string $chatServiceSid)
    {
        parent::__construct($version);
        $this->solution = ['chatServiceSid' => $chatServiceSid,];
    }

    public function getContext(): NotificationContext
    {
        return new NotificationContext($this->version, $this->solution['chatServiceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.NotificationList]';
    }
}