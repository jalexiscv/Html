<?php

namespace Twilio\Rest\Supersim\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Supersim\V1\NetworkAccessProfile\NetworkAccessProfileNetworkList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class NetworkAccessProfileInstance extends InstanceResource
{
    protected $_networks;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): NetworkAccessProfileContext
    {
        if (!$this->context) {
            $this->context = new NetworkAccessProfileContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): NetworkAccessProfileInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): NetworkAccessProfileInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getNetworks(): NetworkAccessProfileNetworkList
    {
        return $this->proxy()->networks;
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
        return '[Twilio.Supersim.V1.NetworkAccessProfileInstance ' . implode(' ', $context) . ']';
    }
}