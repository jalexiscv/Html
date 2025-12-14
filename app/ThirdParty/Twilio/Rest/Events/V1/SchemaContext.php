<?php

namespace Twilio\Rest\Events\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Events\V1\Schema\VersionContext;
use Twilio\Rest\Events\V1\Schema\VersionList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class SchemaContext extends InstanceContext
{
    protected $_versions;

    public function __construct(Version $version, $id)
    {
        parent::__construct($version);
        $this->solution = ['id' => $id,];
        $this->uri = '/Schemas/' . rawurlencode($id) . '';
    }

    public function fetch(): SchemaInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SchemaInstance($this->version, $payload, $this->solution['id']);
    }

    protected function getVersions(): VersionList
    {
        if (!$this->_versions) {
            $this->_versions = new VersionList($this->version, $this->solution['id']);
        }
        return $this->_versions;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Events.V1.SchemaContext ' . implode(' ', $context) . ']';
    }
}