<?php

namespace Twilio\Rest\Preview\Understand\Assistant\FieldType;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FieldValueContext extends InstanceContext
{
    public function __construct(Version $version, $assistantSid, $fieldTypeSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'fieldTypeSid' => $fieldTypeSid, 'sid' => $sid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/FieldTypes/' . rawurlencode($fieldTypeSid) . '/FieldValues/' . rawurlencode($sid) . '';
    }

    public function fetch(): FieldValueInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FieldValueInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['fieldTypeSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Understand.FieldValueContext ' . implode(' ', $context) . ']';
    }
}