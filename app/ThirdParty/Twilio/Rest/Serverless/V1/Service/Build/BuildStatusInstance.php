<?php

namespace Twilio\Rest\Serverless\V1\Service\Build;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class BuildStatusInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $sid)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'status' => Values::array_get($payload, 'status'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
    }

    protected function proxy(): BuildStatusContext
    {
        if (!$this->context) {
            $this->context = new BuildStatusContext($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): BuildStatusInstance
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
        return '[Twilio.Serverless.V1.BuildStatusInstance ' . implode(' ', $context) . ']';
    }
}