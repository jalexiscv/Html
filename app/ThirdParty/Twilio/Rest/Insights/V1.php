<?php

namespace Twilio\Rest\Insights;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Insights\V1\CallContext;
use Twilio\Rest\Insights\V1\CallList;
use Twilio\Rest\Insights\V1\RoomContext;
use Twilio\Rest\Insights\V1\RoomList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_calls;
    protected $_rooms;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getCalls(): CallList
    {
        if (!$this->_calls) {
            $this->_calls = new CallList($this);
        }
        return $this->_calls;
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
        return '[Twilio.Insights.V1]';
    }
}