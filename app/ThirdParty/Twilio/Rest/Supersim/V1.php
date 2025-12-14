<?php

namespace Twilio\Rest\Supersim;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Supersim\V1\CommandContext;
use Twilio\Rest\Supersim\V1\CommandList;
use Twilio\Rest\Supersim\V1\FleetContext;
use Twilio\Rest\Supersim\V1\FleetList;
use Twilio\Rest\Supersim\V1\NetworkAccessProfileContext;
use Twilio\Rest\Supersim\V1\NetworkAccessProfileList;
use Twilio\Rest\Supersim\V1\NetworkContext;
use Twilio\Rest\Supersim\V1\NetworkList;
use Twilio\Rest\Supersim\V1\SimContext;
use Twilio\Rest\Supersim\V1\SimList;
use Twilio\Rest\Supersim\V1\UsageRecordList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_commands;
    protected $_fleets;
    protected $_networks;
    protected $_networkAccessProfiles;
    protected $_sims;
    protected $_usageRecords;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getCommands(): CommandList
    {
        if (!$this->_commands) {
            $this->_commands = new CommandList($this);
        }
        return $this->_commands;
    }

    protected function getFleets(): FleetList
    {
        if (!$this->_fleets) {
            $this->_fleets = new FleetList($this);
        }
        return $this->_fleets;
    }

    protected function getNetworks(): NetworkList
    {
        if (!$this->_networks) {
            $this->_networks = new NetworkList($this);
        }
        return $this->_networks;
    }

    protected function getNetworkAccessProfiles(): NetworkAccessProfileList
    {
        if (!$this->_networkAccessProfiles) {
            $this->_networkAccessProfiles = new NetworkAccessProfileList($this);
        }
        return $this->_networkAccessProfiles;
    }

    protected function getSims(): SimList
    {
        if (!$this->_sims) {
            $this->_sims = new SimList($this);
        }
        return $this->_sims;
    }

    protected function getUsageRecords(): UsageRecordList
    {
        if (!$this->_usageRecords) {
            $this->_usageRecords = new UsageRecordList($this);
        }
        return $this->_usageRecords;
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
        return '[Twilio.Supersim.V1]';
    }
}