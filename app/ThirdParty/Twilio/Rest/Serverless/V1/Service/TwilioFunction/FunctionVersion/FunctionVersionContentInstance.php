<?php

namespace Twilio\Rest\Serverless\V1\Service\TwilioFunction\FunctionVersion;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class FunctionVersionContentInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $functionSid, string $sid)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'functionSid' => Values::array_get($payload, 'function_sid'), 'content' => Values::array_get($payload, 'content'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'functionSid' => $functionSid, 'sid' => $sid,];
    }

    protected function proxy(): FunctionVersionContentContext
    {
        if (!$this->context) {
            $this->context = new FunctionVersionContentContext($this->version, $this->solution['serviceSid'], $this->solution['functionSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): FunctionVersionContentInstance
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
        return '[Twilio.Serverless.V1.FunctionVersionContentInstance ' . implode(' ', $context) . ']';
    }
}