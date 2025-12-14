<?php

namespace Twilio\Rest\Video;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Video\V1\CompositionContext;
use Twilio\Rest\Video\V1\CompositionHookContext;
use Twilio\Rest\Video\V1\CompositionHookList;
use Twilio\Rest\Video\V1\CompositionList;
use Twilio\Rest\Video\V1\CompositionSettingsList;
use Twilio\Rest\Video\V1\RecordingContext;
use Twilio\Rest\Video\V1\RecordingList;
use Twilio\Rest\Video\V1\RecordingSettingsList;
use Twilio\Rest\Video\V1\RoomContext;
use Twilio\Rest\Video\V1\RoomList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_compositions;
    protected $_compositionHooks;
    protected $_compositionSettings;
    protected $_recordings;
    protected $_recordingSettings;
    protected $_rooms;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getCompositions(): CompositionList
    {
        if (!$this->_compositions) {
            $this->_compositions = new CompositionList($this);
        }
        return $this->_compositions;
    }

    protected function getCompositionHooks(): CompositionHookList
    {
        if (!$this->_compositionHooks) {
            $this->_compositionHooks = new CompositionHookList($this);
        }
        return $this->_compositionHooks;
    }

    protected function getCompositionSettings(): CompositionSettingsList
    {
        if (!$this->_compositionSettings) {
            $this->_compositionSettings = new CompositionSettingsList($this);
        }
        return $this->_compositionSettings;
    }

    protected function getRecordings(): RecordingList
    {
        if (!$this->_recordings) {
            $this->_recordings = new RecordingList($this);
        }
        return $this->_recordings;
    }

    protected function getRecordingSettings(): RecordingSettingsList
    {
        if (!$this->_recordingSettings) {
            $this->_recordingSettings = new RecordingSettingsList($this);
        }
        return $this->_recordingSettings;
    }

    protected function getRooms(): RoomList
    {
        if (!$this->_rooms) {
            $this->_rooms = new RoomList($this);
        }
        return $this->_rooms;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown resource ' . $name);
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
        return '[Twilio.Video.V1]';
    }
}