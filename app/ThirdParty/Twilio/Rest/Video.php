<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Video\V1;
use Twilio\Rest\Video\V1\CompositionContext;
use Twilio\Rest\Video\V1\CompositionHookContext;
use Twilio\Rest\Video\V1\CompositionHookList;
use Twilio\Rest\Video\V1\CompositionList;
use Twilio\Rest\Video\V1\CompositionSettingsContext;
use Twilio\Rest\Video\V1\CompositionSettingsList;
use Twilio\Rest\Video\V1\RecordingContext;
use Twilio\Rest\Video\V1\RecordingList;
use Twilio\Rest\Video\V1\RecordingSettingsContext;
use Twilio\Rest\Video\V1\RecordingSettingsList;
use Twilio\Rest\Video\V1\RoomContext;
use Twilio\Rest\Video\V1\RoomList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Video extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://video.twilio.com';
    }

    protected function getV1(): V1
    {
        if (!$this->_v1) {
            $this->_v1 = new V1($this);
        }
        return $this->_v1;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown version ' . $name);
    }

    public function __call(string $name, array $arguments)
    {
        $method = 'context' . ucfirst($name);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }
        throw new TwilioException('Unknown context ' . $name);
    }

    protected function getCompositions(): CompositionList
    {
        return $this->v1->compositions;
    }

    protected function contextCompositions(string $sid): CompositionContext
    {
        return $this->v1->compositions($sid);
    }

    protected function getCompositionHooks(): CompositionHookList
    {
        return $this->v1->compositionHooks;
    }

    protected function contextCompositionHooks(string $sid): CompositionHookContext
    {
        return $this->v1->compositionHooks($sid);
    }

    protected function getCompositionSettings(): CompositionSettingsList
    {
        return $this->v1->compositionSettings;
    }

    protected function contextCompositionSettings(): CompositionSettingsContext
    {
        return $this->v1->compositionSettings();
    }

    protected function getRecordings(): RecordingList
    {
        return $this->v1->recordings;
    }

    protected function contextRecordings(string $sid): RecordingContext
    {
        return $this->v1->recordings($sid);
    }

    protected function getRecordingSettings(): RecordingSettingsList
    {
        return $this->v1->recordingSettings;
    }

    protected function contextRecordingSettings(): RecordingSettingsContext
    {
        return $this->v1->recordingSettings();
    }

    protected function getRooms(): RoomList
    {
        return $this->v1->rooms;
    }

    protected function contextRooms(string $sid): RoomContext
    {
        return $this->v1->rooms($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Video]';
    }
}