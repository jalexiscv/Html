<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Autopilot\V1\Assistant\FieldType\FieldValueList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class FieldTypeInstance extends InstanceResource
{
    protected $_fieldValues;

    public function __construct(Version $version, array $payload, string $assistantSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'links' => Values::array_get($payload, 'links'), 'assistantSid' => Values::array_get($payload, 'assistant_sid'), 'sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): FieldTypeContext
    {
        if (!$this->context) {
            $this->context = new FieldTypeContext($this->version, $this->solution['assistantSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): FieldTypeInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): FieldTypeInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getFieldValues(): FieldValueList
    {
        return $this->proxy()->fieldValues;
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
        return '[Twilio.Autopilot.V1.FieldTypeInstance ' . implode(' ', $context) . ']';
    }
}