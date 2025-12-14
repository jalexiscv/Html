<?php

namespace Twilio\Rest\Preview\BulkExports\Export;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class ExportCustomJobInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $resourceType)
    {
        parent::__construct($version);
        $this->properties = ['friendlyName' => Values::array_get($payload, 'friendly_name'), 'resourceType' => Values::array_get($payload, 'resource_type'), 'startDay' => Values::array_get($payload, 'start_day'), 'endDay' => Values::array_get($payload, 'end_day'), 'webhookUrl' => Values::array_get($payload, 'webhook_url'), 'webhookMethod' => Values::array_get($payload, 'webhook_method'), 'email' => Values::array_get($payload, 'email'), 'jobSid' => Values::array_get($payload, 'job_sid'), 'details' => Values::array_get($payload, 'details'),];
        $this->solution = ['resourceType' => $resourceType,];
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
        return '[Twilio.Preview.BulkExports.ExportCustomJobInstance]';
    }
}