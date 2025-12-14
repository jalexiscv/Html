<?php

namespace Twilio\Rest\Insights\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Insights\V1\Call\CallSummaryList;
use Twilio\Rest\Insights\V1\Call\EventList;
use Twilio\Rest\Insights\V1\Call\MetricList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class CallInstance extends InstanceResource
{
    protected $_events;
    protected $_metrics;
    protected $_summary;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): CallContext
    {
        if (!$this->context) {
            $this->context = new CallContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): CallInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getEvents(): EventList
    {
        return $this->proxy()->events;
    }

    protected function getMetrics(): MetricList
    {
        return $this->proxy()->metrics;
    }

    protected function getSummary(): CallSummaryList
    {
        return $this->proxy()->summary;
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
        return '[Twilio.Insights.V1.CallInstance ' . implode(' ', $context) . ']';
    }
}