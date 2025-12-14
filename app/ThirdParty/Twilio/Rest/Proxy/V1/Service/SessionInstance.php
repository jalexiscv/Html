<?php

namespace Twilio\Rest\Proxy\V1\Service;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Proxy\V1\Service\Session\InteractionList;
use Twilio\Rest\Proxy\V1\Service\Session\ParticipantList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class SessionInstance extends InstanceResource
{
    protected $_interactions;
    protected $_participants;

    public function __construct(Version $version, array $payload, string $serviceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'dateStarted' => Deserialize::dateTime(Values::array_get($payload, 'date_started')), 'dateEnded' => Deserialize::dateTime(Values::array_get($payload, 'date_ended')), 'dateLastInteraction' => Deserialize::dateTime(Values::array_get($payload, 'date_last_interaction')), 'dateExpiry' => Deserialize::dateTime(Values::array_get($payload, 'date_expiry')), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'status' => Values::array_get($payload, 'status'), 'closedReason' => Values::array_get($payload, 'closed_reason'), 'ttl' => Values::array_get($payload, 'ttl'), 'mode' => Values::array_get($payload, 'mode'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): SessionContext
    {
        if (!$this->context) {
            $this->context = new SessionContext($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): SessionInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): SessionInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getInteractions(): InteractionList
    {
        return $this->proxy()->interactions;
    }

    protected function getParticipants(): ParticipantList
    {
        return $this->proxy()->participants;
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
        return '[Twilio.Proxy.V1.SessionInstance ' . implode(' ', $context) . ']';
    }
}