<?php

namespace Twilio\Rest\Preview;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Preview\DeployedDevices\FleetContext;
use Twilio\Rest\Preview\DeployedDevices\FleetList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class DeployedDevices extends Version
{
    protected $_fleets;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'DeployedDevices';
    }

    protected function getFleets(): FleetList
    {
        if (!$this->_fleets) {
            $this->_fleets = new FleetList($this);
        }
        return $this->_fleets;
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
        return '[Twilio.Preview.DeployedDevices]';
    }
}