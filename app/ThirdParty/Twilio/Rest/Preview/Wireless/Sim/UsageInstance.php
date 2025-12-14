<?php

namespace Twilio\Rest\Preview\Wireless\Sim;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class UsageInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $simSid)
    {
        parent::__construct($version);
        $this->properties = ['simSid' => Values::array_get($payload, 'sim_sid'), 'simUniqueName' => Values::array_get($payload, 'sim_unique_name'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'period' => Values::array_get($payload, 'period'), 'commandsUsage' => Values::array_get($payload, 'commands_usage'), 'commandsCosts' => Values::array_get($payload, 'commands_costs'), 'dataUsage' => Values::array_get($payload, 'data_usage'), 'dataCosts' => Values::array_get($payload, 'data_costs'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['simSid' => $simSid,];
    }

    protected function proxy(): UsageContext
    {
        if (!$this->context) {
            $this->context = new UsageContext($this->version, $this->solution['simSid']);
        }
        return $this->context;
    }

    public function fetch(array $options = []): UsageInstance
    {
        return $this->proxy()->fetch($options);
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
        return '[Twilio.Preview.Wireless.UsageInstance ' . implode(' ', $context) . ']';
    }
}