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

class DayInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $resourceType, string $day = null)
    {
        parent::__construct($version);
        $this->properties = ['redirectTo' => Values::array_get($payload, 'redirect_to'), 'day' => Values::array_get($payload, 'day'), 'size' => Values::array_get($payload, 'size'), 'createDate' => Values::array_get($payload, 'create_date'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'resourceType' => Values::array_get($payload, 'resource_type'),];
        $this->solution = ['resourceType' => $resourceType, 'day' => $day ?: $this->properties['day'],];
    }

    protected function proxy(): DayContext
    {
        if (!$this->context) {
            $this->context = new DayContext($this->version, $this->solution['resourceType'], $this->solution['day']);
        }
        return $this->context;
    }

    public function fetch(): DayInstance
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
        return '[Twilio.Bulkexports.V1.DayInstance ' . implode(' ', $context) . ']';
    }
}