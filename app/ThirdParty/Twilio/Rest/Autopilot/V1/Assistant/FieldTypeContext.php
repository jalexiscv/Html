<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Autopilot\V1\Assistant\FieldType\FieldValueContext;
use Twilio\Rest\Autopilot\V1\Assistant\FieldType\FieldValueList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class FieldTypeContext extends InstanceContext
{
    protected $_fieldValues;

    public function __construct(Version $version, $assistantSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/FieldTypes/' . rawurlencode($sid) . '';
    }

    public function fetch(): FieldTypeInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FieldTypeInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['sid']);
    }

    public function update(array $options = []): FieldTypeInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'UniqueName' => $options['uniqueName'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new FieldTypeInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getFieldValues(): FieldValueList
    {
        if (!$this->_fieldValues) {
            $this->_fieldValues = new FieldValueList($this->version, $this->solution['assistantSid'], $this->solution['sid']);
        }
        return $this->_fieldValues;
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
        return '[Twilio.Autopilot.V1.FieldTypeContext ' . implode(' ', $context) . ']';
    }
}