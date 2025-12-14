<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SupportingDocumentTypeContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/RegulatoryCompliance/SupportingDocumentTypes/' . rawurlencode($sid) . '';
    }

    public function fetch(): SupportingDocumentTypeInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SupportingDocumentTypeInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Numbers.V2.SupportingDocumentTypeContext ' . implode(' ', $context) . ']';
    }
}