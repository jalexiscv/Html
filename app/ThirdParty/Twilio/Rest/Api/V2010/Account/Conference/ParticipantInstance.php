<?php

namespace Twilio\Rest\Api\V2010\Account\Conference;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ParticipantInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $conferenceSid, string $callSid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'callSid' => Values::array_get($payload, 'call_sid'), 'label' => Values::array_get($payload, 'label'), 'callSidToCoach' => Values::array_get($payload, 'call_sid_to_coach'), 'coaching' => Values::array_get($payload, 'coaching'), 'conferenceSid' => Values::array_get($payload, 'conference_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'endConferenceOnExit' => Values::array_get($payload, 'end_conference_on_exit'), 'muted' => Values::array_get($payload, 'muted'), 'hold' => Values::array_get($payload, 'hold'), 'startConferenceOnEnter' => Values::array_get($payload, 'start_conference_on_enter'), 'status' => Values::array_get($payload, 'status'), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['accountSid' => $accountSid, 'conferenceSid' => $conferenceSid, 'callSid' => $callSid ?: $this->properties['callSid'],];
    }

    protected function proxy(): ParticipantContext
    {
        if (!$this->context) {
            $this->context = new ParticipantContext($this->version, $this->solution['accountSid'], $this->solution['conferenceSid'], $this->solution['callSid']);
        }
        return $this->context;
    }

    public function fetch(): ParticipantInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): ParticipantInstance
    {
        return $this->proxy()->update($options);
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
        return '[Twilio.Api.V2010.ParticipantInstance ' . implode(' ', $context) . ']';
    }
}