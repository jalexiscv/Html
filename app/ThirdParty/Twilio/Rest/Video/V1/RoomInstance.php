<?php

namespace Twilio\Rest\Video\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Video\V1\Room\ParticipantList;
use Twilio\Rest\Video\V1\Room\RecordingRulesList;
use Twilio\Rest\Video\V1\Room\RoomRecordingList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class RoomInstance extends InstanceResource
{
    protected $_recordings;
    protected $_participants;
    protected $_recordingRules;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'status' => Values::array_get($payload, 'status'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'accountSid' => Values::array_get($payload, 'account_sid'), 'enableTurn' => Values::array_get($payload, 'enable_turn'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'statusCallback' => Values::array_get($payload, 'status_callback'), 'statusCallbackMethod' => Values::array_get($payload, 'status_callback_method'), 'endTime' => Deserialize::dateTime(Values::array_get($payload, 'end_time')), 'duration' => Values::array_get($payload, 'duration'), 'type' => Values::array_get($payload, 'type'), 'maxParticipants' => Values::array_get($payload, 'max_participants'), 'maxConcurrentPublishedTracks' => Values::array_get($payload, 'max_concurrent_published_tracks'), 'recordParticipantsOnConnect' => Values::array_get($payload, 'record_participants_on_connect'), 'videoCodecs' => Values::array_get($payload, 'video_codecs'), 'mediaRegion' => Values::array_get($payload, 'media_region'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): RoomContext
    {
        if (!$this->context) {
            $this->context = new RoomContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): RoomInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(string $status): RoomInstance
    {
        return $this->proxy()->update($status);
    }

    protected function getRecordings(): RoomRecordingList
    {
        return $this->proxy()->recordings;
    }

    protected function getParticipants(): ParticipantList
    {
        return $this->proxy()->participants;
    }

    protected function getRecordingRules(): RecordingRulesList
    {
        return $this->proxy()->recordingRules;
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
        return '[Twilio.Video.V1.RoomInstance ' . implode(' ', $context) . ']';
    }
}