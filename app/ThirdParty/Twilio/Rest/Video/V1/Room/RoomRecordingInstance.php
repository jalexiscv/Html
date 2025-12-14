<?php

namespace Twilio\Rest\Video\V1\Room;

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

class RoomRecordingInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $roomSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'status' => Values::array_get($payload, 'status'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'sid' => Values::array_get($payload, 'sid'), 'sourceSid' => Values::array_get($payload, 'source_sid'), 'size' => Values::array_get($payload, 'size'), 'url' => Values::array_get($payload, 'url'), 'type' => Values::array_get($payload, 'type'), 'duration' => Values::array_get($payload, 'duration'), 'containerFormat' => Values::array_get($payload, 'container_format'), 'codec' => Values::array_get($payload, 'codec'), 'groupingSids' => Values::array_get($payload, 'grouping_sids'), 'trackName' => Values::array_get($payload, 'track_name'), 'offset' => Values::array_get($payload, 'offset'), 'roomSid' => Values::array_get($payload, 'room_sid'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['roomSid' => $roomSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): RoomRecordingContext
    {
        if (!$this->context) {
            $this->context = new RoomRecordingContext($this->version, $this->solution['roomSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): RoomRecordingInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Video.V1.RoomRecordingInstance ' . implode(' ', $context) . ']';
    }
}