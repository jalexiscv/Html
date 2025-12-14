<?php

namespace Twilio\Rest\Video\V1\Room;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Video\V1\Room\Participant\PublishedTrackContext;
use Twilio\Rest\Video\V1\Room\Participant\PublishedTrackList;
use Twilio\Rest\Video\V1\Room\Participant\SubscribedTrackContext;
use Twilio\Rest\Video\V1\Room\Participant\SubscribeRulesList;
use Twilio\Rest\Video\V1\Room\Participant\SubscribedTrackList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ParticipantContext extends InstanceContext
{
    protected $_publishedTracks;
    protected $_subscribedTracks;
    protected $_subscribeRules;

    public function __construct(Version $version, $roomSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['roomSid' => $roomSid, 'sid' => $sid,];
        $this->uri = '/Rooms/' . rawurlencode($roomSid) . '/Participants/' . rawurlencode($sid) . '';
    }

    public function fetch(): ParticipantInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ParticipantInstance($this->version, $payload, $this->solution['roomSid'], $this->solution['sid']);
    }

    public function update(array $options = []): ParticipantInstance
    {
        $options = new Values($options);
        $data = Values::of(['Status' => $options['status'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ParticipantInstance($this->version, $payload, $this->solution['roomSid'], $this->solution['sid']);
    }

    protected function getPublishedTracks(): PublishedTrackList
    {
        if (!$this->_publishedTracks) {
            $this->_publishedTracks = new PublishedTrackList($this->version, $this->solution['roomSid'], $this->solution['sid']);
        }
        return $this->_publishedTracks;
    }

    protected function getSubscribedTracks(): SubscribedTrackList
    {
        if (!$this->_subscribedTracks) {
            $this->_subscribedTracks = new SubscribedTrackList($this->version, $this->solution['roomSid'], $this->solution['sid']);
        }
        return $this->_subscribedTracks;
    }

    protected function getSubscribeRules(): SubscribeRulesList
    {
        if (!$this->_subscribeRules) {
            $this->_subscribeRules = new SubscribeRulesList($this->version, $this->solution['roomSid'], $this->solution['sid']);
        }
        return $this->_subscribeRules;
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
        return '[Twilio.Video.V1.ParticipantContext ' . implode(' ', $context) . ']';
    }
}