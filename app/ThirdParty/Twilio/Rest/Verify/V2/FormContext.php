<?php

namespace Twilio\Rest\Verify\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FormContext extends InstanceContext
{
    public function __construct(Version $version, $formType)
    {
        parent::__construct($version);
        $this->solution = ['formType' => $formType,];
        $this->uri = '/Forms/' . rawurlencode($formType) . '';
    }

    public function fetch(): FormInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FormInstance($this->version, $payload, $this->solution['formType']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Verify.V2.FormContext ' . implode(' ', $context) . ']';
    }
}