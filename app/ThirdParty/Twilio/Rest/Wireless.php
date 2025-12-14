<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Wireless\V1;
use Twilio\Rest\Wireless\V1\CommandContext;
use Twilio\Rest\Wireless\V1\CommandList;
use Twilio\Rest\Wireless\V1\RatePlanContext;
use Twilio\Rest\Wireless\V1\RatePlanList;
use Twilio\Rest\Wireless\V1\SimContext;
use Twilio\Rest\Wireless\V1\SimList;
use Twilio\Rest\Wireless\V1\UsageRecordList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Wireless extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://wireless.twilio.com';
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

    protected function getUsageRecords(): UsageRecordList
    {
        return $this->v1->usageRecords;
    }

    protected function getCommands(): CommandList
    {
        return $this->v1->commands;
    }

    protected function contextCommands(string $sid): CommandContext
    {
        return $this->v1->commands($sid);
    }

    protected function getRatePlans(): RatePlanList
    {
        return $this->v1->ratePlans;
    }

    protected function contextRatePlans(string $sid): RatePlanContext
    {
        return $this->v1->ratePlans($sid);
    }

    protected function getSims(): SimList
    {
        return $this->v1->sims;
    }

    protected function contextSims(string $sid): SimContext
    {
        return $this->v1->sims($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Wireless]';
    }
}