<?php

namespace Twilio\Rest\Proxy\V1\Service\Session;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Proxy\V1\Service\Session\Participant\MessageInteractionList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ParticipantInstance extends InstanceResource
{
    protected $_messageInteractions;

    public function __construct(Version $version, array $payload, string $serviceSid, string $sessionSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'sessionSid' => Values::array_get($payload, 'session_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'identifier' => Values::array_get($payload, 'identifier'), 'proxyIdentifier' => Values::array_get($payload, 'proxy_identifier'), 'proxyIdentifierSid' => Values::array_get($payload, 'proxy_identifier_sid'), 'dateDeleted' => Deserialize::dateTime(Values::array_get($payload, 'date_deleted')), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['serviceSid' => $serviceSid, 'sessionSid' => $sessionSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ParticipantContext
    {
        if (!$this->context) {
            $this->context = new ParticipantContext($this->version, $this->solution['serviceSid'], $this->solution['sessionSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ParticipantInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getMessageInteractions(): MessageInteractionList
    {
        return $this->proxy()->messageInteractions;
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
        return '[Twilio.Proxy.V1.ParticipantInstance ' . implode(' ', $context) . ']';
    }
}