<?php

namespace Twilio\Rest\Serverless\V1\Service\TwilioFunction\FunctionVersion;

use Twilio\ListResource;
use Twilio\Version;

class FunctionVersionContentList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $functionSid, string $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'functionSid' => $functionSid, 'sid' => $sid,];
    }

    public function getContext(): FunctionVersionContentContext
    {
        return new FunctionVersionContentContext($this->version, $this->solution['serviceSid'], $this->solution['functionSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.FunctionVersionContentList]';
    }
}