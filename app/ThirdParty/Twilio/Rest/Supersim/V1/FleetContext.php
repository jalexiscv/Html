<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FleetContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Fleets/' . rawurlencode($sid) . '';
    }

    public function fetch(): FleetInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FleetInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): FleetInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'], 'NetworkAccessProfile' => $options['networkAccessProfile'], 'CommandsUrl' => $options['commandsUrl'], 'CommandsMethod' => $options['commandsMethod'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new FleetInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Supersim.V1.FleetContext ' . implode(' ', $context) . ']';
    }
}