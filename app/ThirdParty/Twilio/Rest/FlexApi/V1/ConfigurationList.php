<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\ListResource;
use Twilio\Version;

class ConfigurationList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(): ConfigurationContext
    {
        return new ConfigurationContext($this->version);
    }

    public function __toString(): string
    {
        return '[Twilio.FlexApi.V1.ConfigurationList]';
    }
}