<?php

namespace Twilio\Rest\Proxy\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Proxy\V1\Service\PhoneNumberContext;
use Twilio\Rest\Proxy\V1\Service\PhoneNumberList;
use Twilio\Rest\Proxy\V1\Service\SessionContext;
use Twilio\Rest\Proxy\V1\Service\SessionList;
use Twilio\Rest\Proxy\V1\Service\ShortCodeContext;
use Twilio\Rest\Proxy\V1\Service\ShortCodeList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ServiceContext extends InstanceContext
{
    protected $_sessions;
    protected $_phoneNumbers;
    protected $_shortCodes;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($sid) . '';
    }

    public function fetch(): ServiceInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): ServiceInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'], 'DefaultTtl' => $options['defaultTtl'], 'CallbackUrl' => $options['callbackUrl'], 'GeoMatchLevel' => $options['geoMatchLevel'], 'NumberSelectionBehavior' => $options['numberSelectionBehavior'], 'InterceptCallbackUrl' => $options['interceptCallbackUrl'], 'OutOfSessionCallbackUrl' => $options['outOfSessionCallbackUrl'], 'ChatInstanceSid' => $options['chatInstanceSid'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getSessions(): SessionList
    {
        if (!$this->_sessions) {
            $this->_sessions = new SessionList($this->version, $this->solution['sid']);
        }
        return $this->_sessions;
    }

    protected function getPhoneNumbers(): PhoneNumberList
    {
        if (!$this->_phoneNumbers) {
            $this->_phoneNumbers = new PhoneNumberList($this->version, $this->solution['sid']);
        }
        return $this->_phoneNumbers;
    }

    protected function getShortCodes(): ShortCodeList
    {
        if (!$this->_shortCodes) {
            $this->_shortCodes = new ShortCodeList($this->version, $this->solution['sid']);
        }
        return $this->_shortCodes;
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
        return '[Twilio.Proxy.V1.ServiceContext ' . implode(' ', $context) . ']';
    }
}