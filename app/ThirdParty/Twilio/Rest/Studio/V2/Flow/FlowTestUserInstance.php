<?php

namespace Twilio\Rest\Studio\V2\Flow;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class FlowTestUserInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'testUsers' => Values::array_get($payload, 'test_users'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['sid' => $sid,];
    }

    public function fetch(): FlowTestUserInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $testUsers): FlowTestUserInstance
    {
        return $this->proxy()->update($testUsers);
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
        return '[Twilio.Studio.V2.FlowTestUserInstance ' . implode(' ', $context) . ']';
    }

    protected function proxy(): FlowTestUserContext
    {
        if (!$this->context) {
            $this->context = new FlowTestUserContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }
}