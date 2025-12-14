<?php

namespace Twilio\Rest\Serverless\V1\Service\Build;

use Twilio\ListResource;
use Twilio\Version;

class BuildStatusList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
    }

    public function getContext(): BuildStatusContext
    {
        return new BuildStatusContext($this->version, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.BuildStatusList]';
    }
}