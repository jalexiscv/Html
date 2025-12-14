<?php

namespace Twilio\Rest\Bulkexports\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ExportConfigurationInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $resourceType = null)
    {
        parent::__construct($version);
        $this->properties = ['enabled' => Values::array_get($payload, 'enabled'), 'webhookUrl' => Values::array_get($payload, 'webhook_url'), 'webhookMethod' => Values::array_get($payload, 'webhook_method'), 'resourceType' => Values::array_get($payload, 'resource_type'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['resourceType' => $resourceType ?: $this->properties['resourceType'],];
    }

    protected function proxy(): ExportConfigurationContext
    {
        if (!$this->context) {
            $this->context = new ExportConfigurationContext($this->version, $this->solution['resourceType']);
        }
        return $this->context;
    }

    public function fetch(): ExportConfigurationInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): ExportConfigurationInstance
    {
        return $this->proxy()->update($options);
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
        return '[Twilio.Bulkexports.V1.ExportConfigurationInstance ' . implode(' ', $context) . ']';
    }
}