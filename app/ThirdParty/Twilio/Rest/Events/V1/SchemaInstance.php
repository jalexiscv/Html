<?php

namespace Twilio\Rest\Events\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Events\V1\Schema\VersionList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class SchemaInstance extends InstanceResource
{
    protected $_versions;

    public function __construct(Version $version, array $payload, string $id = null)
    {
        parent::__construct($version);
        $this->properties = ['id' => Values::array_get($payload, 'id'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'), 'lastCreated' => Deserialize::dateTime(Values::array_get($payload, 'last_created')), 'lastVersion' => Values::array_get($payload, 'last_version'),];
        $this->solution = ['id' => $id ?: $this->properties['id'],];
    }

    protected function proxy(): SchemaContext
    {
        if (!$this->context) {
            $this->context = new SchemaContext($this->version, $this->solution['id']);
        }
        return $this->context;
    }

    public function fetch(): SchemaInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getVersions(): VersionList
    {
        return $this->proxy()->versions;
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
        return '[Twilio.Events.V1.SchemaInstance ' . implode(' ', $context) . ']';
    }
}