<?php

namespace Twilio\Rest\Insights\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Insights\V1\Room\ParticipantList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class RoomInstance extends InstanceResource
{
    protected $_participants;

    public function __construct(Version $version, array $payload, string $roomSid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'roomSid' => Values::array_get($payload, 'room_sid'), 'roomName' => Values::array_get($payload, 'room_name'), 'createTime' => Deserialize::dateTime(Values::array_get($payload, 'create_time')), 'endTime' => Deserialize::dateTime(Values::array_get($payload, 'end_time')), 'roomType' => Values::array_get($payload, 'room_type'), 'roomStatus' => Values::array_get($payload, 'room_status'), 'statusCallback' => Values::array_get($payload, 'status_callback'), 'statusCallbackMethod' => Values::array_get($payload, 'status_callback_method'), 'createdMethod' => Values::array_get($payload, 'created_method'), 'endReason' => Values::array_get($payload, 'end_reason'), 'maxParticipants' => Values::array_get($payload, 'max_participants'), 'uniqueParticipants' => Values::array_get($payload, 'unique_participants'), 'uniqueParticipantIdentities' => Values::array_get($payload, 'unique_participant_identities'), 'concurrentParticipants' => Values::array_get($payload, 'concurrent_participants'), 'maxConcurrentParticipants' => Values::array_get($payload, 'max_concurrent_participants'), 'codecs' => Values::array_get($payload, 'codecs'), 'mediaRegion' => Values::array_get($payload, 'media_region'), 'durationSec' => Values::array_get($payload, 'duration_sec'), 'totalParticipantDurationSec' => Values::array_get($payload, 'total_participant_duration_sec'), 'totalRecordingDurationSec' => Values::array_get($payload, 'total_recording_duration_sec'), 'processingState' => Values::array_get($payload, 'processing_state'), 'recordingEnabled' => Values::array_get($payload, 'recording_enabled'), 'edgeLocation' => Values::array_get($payload, 'edge_location'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['roomSid' => $roomSid ?: $this->properties['roomSid'],];
    }

    protected function proxy(): RoomContext
    {
        if (!$this->context) {
            $this->context = new RoomContext($this->version, $this->solution['roomSid']);
        }
        return $this->context;
    }

    public function fetch(): RoomInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Insights.V1.RoomInstance ' . implode(' ', $context) . ']';
    }
}