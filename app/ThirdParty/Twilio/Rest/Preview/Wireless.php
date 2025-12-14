<?php

namespace Twilio\Rest\Preview;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Preview\Wireless\CommandContext;
use Twilio\Rest\Preview\Wireless\CommandList;
use Twilio\Rest\Preview\Wireless\RatePlanContext;
use Twilio\Rest\Preview\Wireless\RatePlanList;
use Twilio\Rest\Preview\Wireless\SimContext;
use Twilio\Rest\Preview\Wireless\SimList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Wireless extends Version
{
    protected $_commands;
    protected $_ratePlans;
    protected $_sims;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'wireless';
    }

    protected function getCommands(): CommandList
    {
        if (!$this->_commands) {
            $this->_commands = new CommandList($this);
        }
        return $this->_commands;
    }

    protected function getRatePlans(): RatePlanList
    {
        if (!$this->_ratePlans) {
            $this->_ratePlans = new RatePlanList($this);
        }
        return $this->_ratePlans;
    }

    protected function getSims(): SimList
    {
        if (!$this->_sims) {
            $this->_sims = new SimList($this);
        }
        return $this->_sims;
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
        return '[Twilio.Preview.Wireless]';
    }
}