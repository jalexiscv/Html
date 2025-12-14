<?php

namespace Twilio\Rest\Insights\V1\Room;

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

class ParticipantInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $roomSid, string $participantSid = null)
    {
        parent::__construct($version);
        $this->properties = ['participantSid' => Values::array_get($payload, 'participant_sid'), 'participantIdentity' => Values::array_get($payload, 'participant_identity'), 'joinTime' => Deserialize::dateTime(Values::array_get($payload, 'join_time')), 'leaveTime' => Deserialize::dateTime(Values::array_get($payload, 'leave_time')), 'durationSec' => Values::array_get($payload, 'duration_sec'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'roomSid' => Values::array_get($payload, 'room_sid'), 'status' => Values::array_get($payload, 'status'), 'codecs' => Values::array_get($payload, 'codecs'), 'endReason' => Values::array_get($payload, 'end_reason'), 'errorCode' => Values::array_get($payload, 'error_code'), 'errorCodeUrl' => Values::array_get($payload, 'error_code_url'), 'mediaRegion' => Values::array_get($payload, 'media_region'), 'properties' => Values::array_get($payload, 'properties'), 'edgeLocation' => Values::array_get($payload, 'edge_location'), 'publisherInfo' => Values::array_get($payload, 'publisher_info'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['roomSid' => $roomSid, 'participantSid' => $participantSid ?: $this->properties['participantSid'],];
    }

    protected function proxy(): ParticipantContext
    {
        if (!$this->context) {
            $this->context = new ParticipantContext($this->version, $this->solution['roomSid'], $this->solution['participantSid']);
        }
        return $this->context;
    }

    public function fetch(): ParticipantInstance
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
        return '[Twilio.Insights.V1.ParticipantInstance ' . implode(' ', $context) . ']';
    }
}