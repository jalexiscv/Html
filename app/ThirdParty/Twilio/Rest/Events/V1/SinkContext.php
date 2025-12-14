<?php

namespace Twilio\Rest\Events\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Events\V1\Sink\SinkTestList;
use Twilio\Rest\Events\V1\Sink\SinkValidateList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class SinkContext extends InstanceContext
{
    protected $_sinkTest;
    protected $_sinkValidate;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Sinks/' . rawurlencode($sid) . '';
    }

    public function fetch(): SinkInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SinkInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getSinkTest(): SinkTestList
    {
        if (!$this->_sinkTest) {
            $this->_sinkTest = new SinkTestList($this->version, $this->solution['sid']);
        }
        return $this->_sinkTest;
    }

    protected function getSinkValidate(): SinkValidateList
    {
        if (!$this->_sinkValidate) {
            $this->_sinkValidate = new SinkValidateList($this->version, $this->solution['sid']);
        }
        return $this->_sinkValidate;
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
        return '[Twilio.Events.V1.SinkContext ' . implode(' ', $context) . ']';
    }
}