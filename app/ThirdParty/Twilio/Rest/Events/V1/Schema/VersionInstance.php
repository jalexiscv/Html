<?php

namespace Twilio\Rest\Events\V1\Schema;

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

class VersionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $id, int $schemaVersion = null)
    {
        parent::__construct($version);
        $this->properties = ['id' => Values::array_get($payload, 'id'), 'schemaVersion' => Values::array_get($payload, 'schema_version'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'url' => Values::array_get($payload, 'url'), 'raw' => Values::array_get($payload, 'raw'),];
        $this->solution = ['id' => $id, 'schemaVersion' => $schemaVersion ?: $this->properties['schemaVersion'],];
    }

    protected function proxy(): VersionContext
    {
        if (!$this->context) {
            $this->context = new VersionContext($this->version, $this->solution['id'], $this->solution['schemaVersion']);
        }
        return $this->context;
    }

    public function fetch(): VersionInstance
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
        return '[Twilio.Events.V1.VersionInstance ' . implode(' ', $context) . ']';
    }
}