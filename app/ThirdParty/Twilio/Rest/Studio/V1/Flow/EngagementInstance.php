<?php

namespace Twilio\Rest\Studio\V1\Flow;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Studio\V1\Flow\Engagement\EngagementContextList;
use Twilio\Rest\Studio\V1\Flow\Engagement\StepList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class EngagementInstance extends InstanceResource
{
    protected $_steps;
    protected $_engagementContext;

    public function __construct(Version $version, array $payload, string $flowSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'flowSid' => Values::array_get($payload, 'flow_sid'), 'contactSid' => Values::array_get($payload, 'contact_sid'), 'contactChannelAddress' => Values::array_get($payload, 'contact_channel_address'), 'context' => Values::array_get($payload, 'context'), 'status' => Values::array_get($payload, 'status'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['flowSid' => $flowSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): EngagementContext
    {
        if (!$this->context) {
            $this->context = new EngagementContext($this->version, $this->solution['flowSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): EngagementInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getSteps(): StepList
    {
        return $this->proxy()->steps;
    }

    protected function getEngagementContext(): EngagementContextList
    {
        return $this->proxy()->engagementContext;
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
        return '[Twilio.Studio.V1.EngagementInstance ' . implode(' ', $context) . ']';
    }
}