<?php

namespace Twilio\Rest\Supersim\V1\NetworkAccessProfile;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class NetworkAccessProfileNetworkInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $networkAccessProfileSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'networkAccessProfileSid' => Values::array_get($payload, 'network_access_profile_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'isoCountry' => Values::array_get($payload, 'iso_country'), 'identifiers' => Values::array_get($payload, 'identifiers'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['networkAccessProfileSid' => $networkAccessProfileSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): NetworkAccessProfileNetworkContext
    {
        if (!$this->context) {
            $this->context = new NetworkAccessProfileNetworkContext($this->version, $this->solution['networkAccessProfileSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function fetch(): NetworkAccessProfileNetworkInstance
    {
        return $this->proxy()->fetch();
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Supersim.V1.NetworkAccessProfileNetworkInstance ' . implode(' ', $context) . ']';
    }
}