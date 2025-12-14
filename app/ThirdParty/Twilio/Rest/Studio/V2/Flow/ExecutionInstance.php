<?php

namespace Twilio\Rest\Studio\V2\Flow;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Studio\V2\Flow\Execution\ExecutionContextList;
use Twilio\Rest\Studio\V2\Flow\Execution\ExecutionStepList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ExecutionInstance extends InstanceResource
{
    protected $_steps;
    protected $_executionContext;

    public function __construct(Version $version, array $payload, string $flowSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'flowSid' => Values::array_get($payload, 'flow_sid'), 'contactChannelAddress' => Values::array_get($payload, 'contact_channel_address'), 'context' => Values::array_get($payload, 'context'), 'status' => Values::array_get($payload, 'status'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['flowSid' => $flowSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ExecutionContext
    {
        if (!$this->context) {
            $this->context = new ExecutionContext($this->version, $this->solution['flowSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ExecutionInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(string $status): ExecutionInstance
    {
        return $this->proxy()->update($status);
    }

    protected function getSteps(): ExecutionStepList
    {
        return $this->proxy()->steps;
    }

    protected function getExecutionContext(): ExecutionContextList
    {
        return $this->proxy()->executionContext;
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
        return '[Twilio.Studio.V2.ExecutionInstance ' . implode(' ', $context) . ']';
    }
}