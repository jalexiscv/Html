<?php

namespace Twilio\Rest\Api\V2010\Account\Recording;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Api\V2010\Account\Recording\AddOnResult\PayloadList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AddOnResultInstance extends InstanceResource
{
    protected $_payloads;

    public function __construct(Version $version, array $payload, string $accountSid, string $referenceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'status' => Values::array_get($payload, 'status'), 'addOnSid' => Values::array_get($payload, 'add_on_sid'), 'addOnConfigurationSid' => Values::array_get($payload, 'add_on_configuration_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'dateCompleted' => Deserialize::dateTime(Values::array_get($payload, 'date_completed')), 'referenceSid' => Values::array_get($payload, 'reference_sid'), 'subresourceUris' => Values::array_get($payload, 'subresource_uris'),];
        $this->solution = ['accountSid' => $accountSid, 'referenceSid' => $referenceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    public function fetch(): AddOnResultInstance
    {
        return $this->proxy()->fetch();
    }

    protected function proxy(): AddOnResultContext
    {
        if (!$this->context) {
            $this->context = new AddOnResultContext($this->version, $this->solution['accountSid'], $this->solution['referenceSid'], $this->solution['sid']);
        }
        return $this->context;
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
        return '[Twilio.Api.V2010.AddOnResultInstance ' . implode(' ', $context) . ']';
    }

    protected function getPayloads(): PayloadList
    {
        return $this->proxy()->payloads;
    }
}