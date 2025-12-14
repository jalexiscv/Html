<?php

namespace Twilio\Rest\Serverless\V1\Service\Environment;

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

class DeploymentInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $environmentSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'environmentSid' => Values::array_get($payload, 'environment_sid'), 'buildSid' => Values::array_get($payload, 'build_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'environmentSid' => $environmentSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): DeploymentContext
    {
        if (!$this->context) {
            $this->context = new DeploymentContext($this->version, $this->solution['serviceSid'], $this->solution['environmentSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): DeploymentInstance
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
        return '[Twilio.Serverless.V1.DeploymentInstance ' . implode(' ', $context) . ']';
    }
}