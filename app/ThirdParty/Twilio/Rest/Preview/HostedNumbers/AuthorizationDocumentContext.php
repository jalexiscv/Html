<?php

namespace Twilio\Rest\Preview\HostedNumbers;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Preview\HostedNumbers\AuthorizationDocument\DependentHostedNumberOrderList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class AuthorizationDocumentContext extends InstanceContext
{
    protected $_dependentHostedNumberOrders;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/AuthorizationDocuments/' . rawurlencode($sid) . '';
    }

    public function fetch(): AuthorizationDocumentInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AuthorizationDocumentInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): AuthorizationDocumentInstance
    {
        $options = new Values($options);
        $data = Values::of(['HostedNumberOrderSids' => Serialize::map($options['hostedNumberOrderSids'], function ($e) {
            return $e;
        }), 'AddressSid' => $options['addressSid'], 'Email' => $options['email'], 'CcEmails' => Serialize::map($options['ccEmails'], function ($e) {
            return $e;
        }), 'Status' => $options['status'], 'ContactTitle' => $options['contactTitle'], 'ContactPhoneNumber' => $options['contactPhoneNumber'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new AuthorizationDocumentInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getDependentHostedNumberOrders(): DependentHostedNumberOrderList
    {
        if (!$this->_dependentHostedNumberOrders) {
            $this->_dependentHostedNumberOrders = new DependentHostedNumberOrderList($this->version, $this->solution['sid']);
        }
        return $this->_dependentHostedNumberOrders;
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
        return '[Twilio.Preview.HostedNumbers.AuthorizationDocumentContext ' . implode(' ', $context) . ']';
    }
}