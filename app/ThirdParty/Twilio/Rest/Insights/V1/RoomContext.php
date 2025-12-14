<?php

namespace Twilio\Rest\Insights\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Insights\V1\Room\ParticipantContext;
use Twilio\Rest\Insights\V1\Room\ParticipantList;
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
    protected $_participants;

    public function __construct(Version $version, $roomSid)
    {
        parent::__construct($version);
        $this->solution = ['roomSid' => $roomSid,];
        $this->uri = '/Video/Rooms/' . rawurlencode($roomSid) . '';
    }

    public function fetch(): RoomInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new RoomInstance($this->version, $payload, $this->solution['roomSid']);
    }

    protected function getParticipants(): ParticipantList
    {
        if (!$this->_participants) {
            $this->_participants = new ParticipantList($this->version, $this->solution['roomSid']);
        }
        return $this->_participants;
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
        return '[Twilio.Insights.V1.RoomContext ' . implode(' ', $context) . ']';
    }
}