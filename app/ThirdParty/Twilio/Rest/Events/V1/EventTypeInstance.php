<?php

namespace Twilio\Rest\Events\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class EventTypeInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $type = null)
    {
        parent::__construct($version);
        $this->properties = ['type' => Values::array_get($payload, 'type'), 'schemaId' => Values::array_get($payload, 'schema_id'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'description' => Values::array_get($payload, 'description'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['type' => $type ?: $this->properties['type'],];
    }

    protected function proxy(): EventTypeContext
    {
        if (!$this->context) {
            $this->context = new EventTypeContext($this->version, $this->solution['type']);
        }
        return $this->context;
    }

    public function fetch(): EventTypeInstance
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
        return '[Twilio.Events.V1.EventTypeInstance ' . implode(' ', $context) . ']';
    }
}