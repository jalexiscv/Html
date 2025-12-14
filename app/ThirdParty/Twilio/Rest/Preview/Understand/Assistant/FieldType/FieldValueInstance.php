<?php

namespace Twilio\Rest\Preview\Understand\Assistant\FieldType;

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

class FieldValueInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $assistantSid, string $fieldTypeSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'fieldTypeSid' => Values::array_get($payload, 'field_type_sid'), 'language' => Values::array_get($payload, 'language'), 'assistantSid' => Values::array_get($payload, 'assistant_sid'), 'sid' => Values::array_get($payload, 'sid'), 'value' => Values::array_get($payload, 'value'), 'url' => Values::array_get($payload, 'url'), 'synonymOf' => Values::array_get($payload, 'synonym_of'),];
        $this->solution = ['assistantSid' => $assistantSid, 'fieldTypeSid' => $fieldTypeSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): FieldValueContext
    {
        if (!$this->context) {
            $this->context = new FieldValueContext($this->version, $this->solution['assistantSid'], $this->solution['fieldTypeSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): FieldValueInstance
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
        return '[Twilio.Preview.Understand.FieldValueInstance ' . implode(' ', $context) . ']';
    }
}