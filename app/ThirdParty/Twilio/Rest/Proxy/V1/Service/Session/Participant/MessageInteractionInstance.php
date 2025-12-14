<?php

namespace Twilio\Rest\Proxy\V1\Service\Session\Participant;

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

class MessageInteractionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $sessionSid, string $participantSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'sessionSid' => Values::array_get($payload, 'session_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'data' => Values::array_get($payload, 'data'), 'type' => Values::array_get($payload, 'type'), 'participantSid' => Values::array_get($payload, 'participant_sid'), 'inboundParticipantSid' => Values::array_get($payload, 'inbound_participant_sid'), 'inboundResourceSid' => Values::array_get($payload, 'inbound_resource_sid'), 'inboundResourceStatus' => Values::array_get($payload, 'inbound_resource_status'), 'inboundResourceType' => Values::array_get($payload, 'inbound_resource_type'), 'inboundResourceUrl' => Values::array_get($payload, 'inbound_resource_url'), 'outboundParticipantSid' => Values::array_get($payload, 'outbound_participant_sid'), 'outboundResourceSid' => Values::array_get($payload, 'outbound_resource_sid'), 'outboundResourceStatus' => Values::array_get($payload, 'outbound_resource_status'), 'outboundResourceType' => Values::array_get($payload, 'outbound_resource_type'), 'outboundResourceUrl' => Values::array_get($payload, 'outbound_resource_url'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'sessionSid' => $sessionSid, 'participantSid' => $participantSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): MessageInteractionContext
    {
        if (!$this->context) {
            $this->context = new MessageInteractionContext($this->version, $this->solution['serviceSid'], $this->solution['sessionSid'], $this->solution['participantSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): MessageInteractionInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Proxy.V1.MessageInteractionInstance ' . implode(' ', $context) . ']';
    }
}