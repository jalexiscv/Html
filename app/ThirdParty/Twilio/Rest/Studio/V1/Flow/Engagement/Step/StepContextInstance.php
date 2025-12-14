<?php

namespace Twilio\Rest\Studio\V1\Flow\Engagement\Step;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class StepContextInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $flowSid, string $engagementSid, string $stepSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'context' => Values::array_get($payload, 'context'), 'engagementSid' => Values::array_get($payload, 'engagement_sid'), 'flowSid' => Values::array_get($payload, 'flow_sid'), 'stepSid' => Values::array_get($payload, 'step_sid'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['flowSid' => $flowSid, 'engagementSid' => $engagementSid, 'stepSid' => $stepSid,];
    }

    protected function proxy(): StepContextContext
    {
        if (!$this->context) {
            $this->context = new StepContextContext($this->version, $this->solution['flowSid'], $this->solution['engagementSid'], $this->solution['stepSid']);
        }
        return $this->context;
    }

    public function fetch(): StepContextInstance
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
        return '[Twilio.Studio.V1.StepContextInstance ' . implode(' ', $context) . ']';
    }
}