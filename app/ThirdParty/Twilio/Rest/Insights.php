<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Insights\V1;
use Twilio\Rest\Insights\V1\CallContext;
use Twilio\Rest\Insights\V1\CallList;
use Twilio\Rest\Insights\V1\RoomContext;
use Twilio\Rest\Insights\V1\RoomList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Insights extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://insights.twilio.com';
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

    protected function getCalls(): CallList
    {
        return $this->v1->calls;
    }

    protected function contextCalls(string $sid): CallContext
    {
        return $this->v1->calls($sid);
    }

    protected function getRooms(): RoomList
    {
        return $this->v1->rooms;
    }

    protected function contextRooms(string $roomSid): RoomContext
    {
        return $this->v1->rooms($roomSid);
    }

    public function __toString(): string
    {
        return '[Twilio.Insights]';
    }
}