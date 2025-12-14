<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

use Twilio\ListResource;
use Twilio\Version;

class RecordingList extends ListResource
{
    public function __construct(Version $version, string $trunkSid)
    {
        parent::__construct($version);
        $this->solution = ['trunkSid' => $trunkSid,];
    }

    public function getContext(): RecordingContext
    {
        return new RecordingContext($this->version, $this->solution['trunkSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Trunking.V1.RecordingList]';
    }
}