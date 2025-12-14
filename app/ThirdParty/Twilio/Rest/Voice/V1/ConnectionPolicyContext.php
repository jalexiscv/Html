<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Voice\V1\ConnectionPolicy\ConnectionPolicyTargetContext;
use Twilio\Rest\Voice\V1\ConnectionPolicy\ConnectionPolicyTargetList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ConnectionPolicyContext extends InstanceContext
{
    protected $_targets;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/ConnectionPolicies/' . rawurlencode($sid) . '';
    }

    public function fetch(): ConnectionPolicyInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ConnectionPolicyInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): ConnectionPolicyInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ConnectionPolicyInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getTargets(): ConnectionPolicyTargetList
    {
        if (!$this->_targets) {
            $this->_targets = new ConnectionPolicyTargetList($this->version, $this->solution['sid']);
        }
        return $this->_targets;
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
        return '[Twilio.Voice.V1.ConnectionPolicyContext ' . implode(' ', $context) . ']';
    }
}