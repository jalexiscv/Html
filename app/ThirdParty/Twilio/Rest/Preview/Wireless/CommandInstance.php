<?php

namespace Twilio\Rest\Preview\Wireless;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class CommandInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'deviceSid' => Values::array_get($payload, 'device_sid'), 'simSid' => Values::array_get($payload, 'sim_sid'), 'command' => Values::array_get($payload, 'command'), 'commandMode' => Values::array_get($payload, 'command_mode'), 'status' => Values::array_get($payload, 'status'), 'direction' => Values::array_get($payload, 'direction'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): CommandContext
    {
        if (!$this->context) {
            $this->context = new CommandContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): CommandInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Preview.Wireless.CommandInstance ' . implode(' ', $context) . ']';
    }
}