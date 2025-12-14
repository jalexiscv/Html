<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\Domain;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class CredentialListMappingInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $domainSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'sid' => Values::array_get($payload, 'sid'), 'uri' => Values::array_get($payload, 'uri'), 'subresourceUris' => Values::array_get($payload, 'subresource_uris'),];
        $this->solution = ['accountSid' => $accountSid, 'domainSid' => $domainSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): CredentialListMappingContext
    {
        if (!$this->context) {
            $this->context = new CredentialListMappingContext($this->version, $this->solution['accountSid'], $this->solution['domainSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): CredentialListMappingInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return '[Twilio.Api.V2010.CredentialListMappingInstance ' . implode(' ', $context) . ']';
    }
}