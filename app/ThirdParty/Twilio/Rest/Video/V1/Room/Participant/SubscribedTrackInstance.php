<?php

namespace Twilio\Rest\Video\V1\Room\Participant;

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

class SubscribedTrackInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $roomSid, string $participantSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'participantSid' => Values::array_get($payload, 'participant_sid'), 'publisherSid' => Values::array_get($payload, 'publisher_sid'), 'roomSid' => Values::array_get($payload, 'room_sid'), 'name' => Values::array_get($payload, 'name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'enabled' => Values::array_get($payload, 'enabled'), 'kind' => Values::array_get($payload, 'kind'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['roomSid' => $roomSid, 'participantSid' => $participantSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): SubscribedTrackContext
    {
        if (!$this->context) {
            $this->context = new SubscribedTrackContext($this->version, $this->solution['roomSid'], $this->solution['participantSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): SubscribedTrackInstance
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
        return '[Twilio.Video.V1.SubscribedTrackInstance ' . implode(' ', $context) . ']';
    }
}