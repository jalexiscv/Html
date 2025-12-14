<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Supersim\V1\NetworkAccessProfile\NetworkAccessProfileNetworkContext;
use Twilio\Rest\Supersim\V1\NetworkAccessProfile\NetworkAccessProfileNetworkList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class NetworkAccessProfileContext extends InstanceContext
{
    protected $_networks;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/NetworkAccessProfiles/' . rawurlencode($sid) . '';
    }

    public function fetch(): NetworkAccessProfileInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new NetworkAccessProfileInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): NetworkAccessProfileInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new NetworkAccessProfileInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getNetworks(): NetworkAccessProfileNetworkList
    {
        if (!$this->_networks) {
            $this->_networks = new NetworkAccessProfileNetworkList($this->version, $this->solution['sid']);
        }
        return $this->_networks;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Supersim.V1.NetworkAccessProfileContext ' . implode(' ', $context) . ']';
    }
}