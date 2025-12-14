<?php

namespace Twilio\Rest\Preview\HostedNumbers;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Preview\HostedNumbers\AuthorizationDocument\DependentHostedNumberOrderList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AuthorizationDocumentInstance extends InstanceResource
{
    protected $_dependentHostedNumberOrders;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'addressSid' => Values::array_get($payload, 'address_sid'), 'status' => Values::array_get($payload, 'status'), 'email' => Values::array_get($payload, 'email'), 'ccEmails' => Values::array_get($payload, 'cc_emails'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): AuthorizationDocumentContext
    {
        if (!$this->context) {
            $this->context = new AuthorizationDocumentContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): AuthorizationDocumentInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): AuthorizationDocumentInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getDependentHostedNumberOrders(): DependentHostedNumberOrderList
    {
        return $this->proxy()->dependentHostedNumberOrders;
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
        return '[Twilio.Preview.HostedNumbers.AuthorizationDocumentInstance ' . implode(' ', $context) . ']';
    }
}