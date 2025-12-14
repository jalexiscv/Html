<?php

namespace Twilio\Rest\Autopilot\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;

class RestoreAssistantList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Assistants/Restore';
    }

    public function update(string $assistant): RestoreAssistantInstance
    {
        $data = Values::of(['Assistant' => $assistant,]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new RestoreAssistantInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.RestoreAssistantList]';
    }
}