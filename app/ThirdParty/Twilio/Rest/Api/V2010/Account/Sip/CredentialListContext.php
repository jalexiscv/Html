<?php

namespace Twilio\Rest\Api\V2010\Account\Sip;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\Sip\CredentialList\CredentialContext;
use Twilio\Rest\Api\V2010\Account\Sip\CredentialList\CredentialList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class CredentialListContext extends InstanceContext
{
    protected $_credentials;

    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/SIP/CredentialLists/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): CredentialListInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new CredentialListInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function update(string $friendlyName): CredentialListInstance
    {
        $data = Values::of(['FriendlyName' => $friendlyName,]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new CredentialListInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getCredentials(): CredentialList
    {
        if (!$this->_credentials) {
            $this->_credentials = new CredentialList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_credentials;
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
        return '[Twilio.Api.V2010.CredentialListContext ' . implode(' ', $context) . ']';
    }
}