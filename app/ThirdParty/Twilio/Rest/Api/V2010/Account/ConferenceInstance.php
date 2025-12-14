<?php

namespace Twilio\Rest\Api\V2010\Account;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Conference\ParticipantList;
use Twilio\Rest\Api\V2010\Account\Conference\RecordingList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ConferenceInstance extends InstanceResource
{
    protected $_participants;
    protected $_recordings;

    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'apiVersion' => Values::array_get($payload, 'api_version'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'region' => Values::array_get($payload, 'region'), 'sid' => Values::array_get($payload, 'sid'), 'status' => Values::array_get($payload, 'status'), 'uri' => Values::array_get($payload, 'uri'), 'subresourceUris' => Values::array_get($payload, 'subresource_uris'), 'reasonConferenceEnded' => Values::array_get($payload, 'reason_conference_ended'), 'callSidEndingConference' => Values::array_get($payload, 'call_sid_ending_conference'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ConferenceContext
    {
        if (!$this->context) {
            $this->context = new ConferenceContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ConferenceInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): ConferenceInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getParticipants(): ParticipantList
    {
        return $this->proxy()->participants;
    }

    protected function getRecordings(): RecordingList
    {
        return $this->proxy()->recordings;
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
        return '[Twilio.Api.V2010.ConferenceInstance ' . implode(' ', $context) . ']';
    }
}