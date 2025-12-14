<?php

namespace Twilio\Rest\Studio\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

class FlowValidateList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Flows/Validate';
    }

    public function update(string $friendlyName, string $status, array $definition, array $options = []): FlowValidateInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'Status' => $status, 'Definition' => Serialize::jsonObject($definition), 'CommitMessage' => $options['commitMessage'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new FlowValidateInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V2.FlowValidateList]';
    }
}