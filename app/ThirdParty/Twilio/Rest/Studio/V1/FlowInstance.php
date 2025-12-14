<?php

namespace Twilio\Rest\Studio\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Studio\V1\Flow\EngagementList;
use Twilio\Rest\Studio\V1\Flow\ExecutionList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class FlowInstance extends InstanceResource
{
    protected $_engagements;
    protected $_executions;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'status' => Values::array_get($payload, 'status'), 'version' => Values::array_get($payload, 'version'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    public function fetch(): FlowInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return '[Twilio.Studio.V1.FlowInstance ' . implode(' ', $context) . ']';
    }

    protected function proxy(): FlowContext
    {
        if (!$this->context) {
            $this->context = new FlowContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    protected function getEngagements(): EngagementList
    {
        return $this->proxy()->engagements;
    }

    protected function getExecutions(): ExecutionList
    {
        return $this->proxy()->executions;
    }
}