<?php

namespace Twilio\Rest\Supersim\V1\NetworkAccessProfile;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class NetworkAccessProfileNetworkContext extends InstanceContext
{
    public function __construct(Version $version, $networkAccessProfileSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['networkAccessProfileSid' => $networkAccessProfileSid, 'sid' => $sid,];
        $this->uri = '/NetworkAccessProfiles/' . rawurlencode($networkAccessProfileSid) . '/Networks/' . rawurlencode($sid) . '';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): NetworkAccessProfileNetworkInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new NetworkAccessProfileNetworkInstance($this->version, $payload, $this->solution['networkAccessProfileSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Supersim.V1.NetworkAccessProfileNetworkContext ' . implode(' ', $context) . ']';
    }
}