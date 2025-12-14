<?php

namespace Twilio\Rest\Video\V1\Room\Participant;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class SubscribeRulesInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $roomSid, string $participantSid)
    {
        parent::__construct($version);
        $this->properties = ['participantSid' => Values::array_get($payload, 'participant_sid'), 'roomSid' => Values::array_get($payload, 'room_sid'), 'rules' => Values::array_get($payload, 'rules'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),];
        $this->solution = ['roomSid' => $roomSid, 'participantSid' => $participantSid,];
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
        return '[Twilio.Video.V1.SubscribeRulesInstance]';
    }
}