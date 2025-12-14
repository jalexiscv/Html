<?php

namespace Twilio\Rest\Bulkexports\V1\Export;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class JobInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $jobSid = null)
    {
        parent::__construct($version);
        $this->properties = ['resourceType' => Values::array_get($payload, 'resource_type'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'details' => Values::array_get($payload, 'details'), 'startDay' => Values::array_get($payload, 'start_day'), 'endDay' => Values::array_get($payload, 'end_day'), 'jobSid' => Values::array_get($payload, 'job_sid'), 'webhookUrl' => Values::array_get($payload, 'webhook_url'), 'webhookMethod' => Values::array_get($payload, 'webhook_method'), 'email' => Values::array_get($payload, 'email'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['jobSid' => $jobSid ?: $this->properties['jobSid'],];
    }

    protected function proxy(): JobContext
    {
        if (!$this->context) {
            $this->context = new JobContext($this->version, $this->solution['jobSid']);
        }
        return $this->context;
    }

    public function fetch(): JobInstance
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
        return '[Twilio.Bulkexports.V1.JobInstance ' . implode(' ', $context) . ']';
    }
}