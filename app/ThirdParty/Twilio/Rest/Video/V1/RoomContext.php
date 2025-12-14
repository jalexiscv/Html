<?php

namespace Twilio\Rest\Video\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Video\V1\Room\ParticipantContext;
use Twilio\Rest\Video\V1\Room\ParticipantList;
use Twilio\Rest\Video\V1\Room\RecordingRulesList;
use Twilio\Rest\Video\V1\Room\RoomRecordingContext;
use Twilio\Rest\Video\V1\Room\RoomRecordingList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class RoomContext extends InstanceContext
{
    protected $_recordings;
    protected $_participants;
    protected $_recordingRules;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Rooms/' . rawurlencode($sid) . '';
    }

    public function fetch(): RoomInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new RoomInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(string $status): RoomInstance
    {
        $data = Values::of(['Status' => $status,]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new RoomInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getRecordings(): RoomRecordingList
    {
        if (!$this->_recordings) {
            $this->_recordings = new RoomRecordingList($this->version, $this->solution['sid']);
        }
        return $this->_recordings;
    }

    protected function getParticipants(): ParticipantList
    {
        if (!$this->_participants) {
            $this->_participants = new ParticipantList($this->version, $this->solution['sid']);
        }
        return $this->_participants;
    }

    protected function getRecordingRules(): RecordingRulesList
    {
        if (!$this->_recordingRules) {
            $this->_recordingRules = new RecordingRulesList($this->version, $this->solution['sid']);
        }
        return $this->_recordingRules;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Video.V1.RoomContext ' . implode(' ', $context) . ']';
    }
}