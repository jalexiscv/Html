<?php

namespace Twilio\Rest\Api\V2010\Account\Recording;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\Recording\AddOnResult\PayloadContext;
use Twilio\Rest\Api\V2010\Account\Recording\AddOnResult\PayloadList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class AddOnResultContext extends InstanceContext
{
    protected $_payloads;

    public function __construct(Version $version, $accountSid, $referenceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'referenceSid' => $referenceSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Recordings/' . rawurlencode($referenceSid) . '/AddOnResults/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): AddOnResultInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AddOnResultInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['referenceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
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
        return '[Twilio.Api.V2010.AddOnResultContext ' . implode(' ', $context) . ']';
    }

    protected function getPayloads(): PayloadList
    {
        if (!$this->_payloads) {
            $this->_payloads = new PayloadList($this->version, $this->solution['accountSid'], $this->solution['referenceSid'], $this->solution['sid']);
        }
        return $this->_payloads;
    }
}