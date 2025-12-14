<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\ListResource;
use Twilio\Version;

class WebhookList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(): WebhookContext
    {
        return new WebhookContext($this->version);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.WebhookList]';
    }
}