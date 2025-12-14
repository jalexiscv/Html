<?php

namespace Twilio\Rest\Video\V1\Room;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Video\V1\Room\Participant\PublishedTrackList;
use Twilio\Rest\Video\V1\Room\Participant\SubscribeRulesList;
use Twilio\Rest\Video\V1\Room\Participant\SubscribedTrackList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ParticipantInstance extends InstanceResource
{
    protected $_publishedTracks;
    protected $_subscribedTracks;
    protected $_subscribeRules;

    public function __construct(Version $version, array $payload, string $roomSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'roomSid' => Values::array_get($payload, 'room_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'status' => Values::array_get($payload, 'status'), 'identity' => Values::array_get($payload, 'identity'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'startTime' => Deserialize::dateTime(Values::array_get($payload, 'start_time')), 'endTime' => Deserialize::dateTime(Values::array_get($payload, 'end_time')), 'duration' => Values::array_get($payload, 'duration'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['roomSid' => $roomSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ParticipantContext
    {
        if (!$this->context) {
            $this->context = new ParticipantContext($this->version, $this->solution['roomSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ParticipantInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): ParticipantInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getPublishedTracks(): PublishedTrackList
    {
        return $this->proxy()->publishedTracks;
    }

    protected function getSubscribedTracks(): SubscribedTrackList
    {
        return $this->proxy()->subscribedTracks;
    }

    protected function getSubscribeRules(): SubscribeRulesList
    {
        return $this->proxy()->subscribeRules;
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
        return '[Twilio.Video.V1.ParticipantInstance ' . implode(' ', $context) . ']';
    }
}