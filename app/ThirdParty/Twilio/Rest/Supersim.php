<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Supersim\V1;
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

class Supersim extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://supersim.twilio.com';
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

    protected function getCommands(): CommandList
    {
        return $this->v1->commands;
    }

    protected function contextCommands(string $sid): CommandContext
    {
        return $this->v1->commands($sid);
    }

    protected function getFleets(): FleetList
    {
        return $this->v1->fleets;
    }

    protected function contextFleets(string $sid): FleetContext
    {
        return $this->v1->fleets($sid);
    }

    protected function getNetworks(): NetworkList
    {
        return $this->v1->networks;
    }

    protected function contextNetworks(string $sid): NetworkContext
    {
        return $this->v1->networks($sid);
    }

    protected function getNetworkAccessProfiles(): NetworkAccessProfileList
    {
        return $this->v1->networkAccessProfiles;
    }

    protected function contextNetworkAccessProfiles(string $sid): NetworkAccessProfileContext
    {
        return $this->v1->networkAccessProfiles($sid);
    }

    protected function getSims(): SimList
    {
        return $this->v1->sims;
    }

    protected function contextSims(string $sid): SimContext
    {
        return $this->v1->sims($sid);
    }

    protected function getUsageRecords(): UsageRecordList
    {
        return $this->v1->usageRecords;
    }

    public function __toString(): string
    {
        return '[Twilio.Supersim]';
    }
}