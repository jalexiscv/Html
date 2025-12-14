<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class WorkersStatisticsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $workspaceSid)
    {
        parent::__construct($version);
        $this->properties = ['realtime' => Values::array_get($payload, 'realtime'), 'cumulative' => Values::array_get($payload, 'cumulative'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['workspaceSid' => $workspaceSid,];
    }

    protected function proxy(): WorkersStatisticsContext
    {
        if (!$this->context) {
            $this->context = new WorkersStatisticsContext($this->version, $this->solution['workspaceSid']);
        }
        return $this->context;
    }

    public function fetch(array $options = []): WorkersStatisticsInstance
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
        return '[Twilio.Taskrouter.V1.WorkersStatisticsInstance ' . implode(' ', $context) . ']';
    }
}