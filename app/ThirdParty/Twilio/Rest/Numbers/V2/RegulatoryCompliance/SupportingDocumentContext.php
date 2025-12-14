<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SupportingDocumentContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/RegulatoryCompliance/SupportingDocuments/' . rawurlencode($sid) . '';
    }

    public function fetch(): SupportingDocumentInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SupportingDocumentInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): SupportingDocumentInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'Attributes' => Serialize::jsonObject($options['attributes']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SupportingDocumentInstance($this->version, $payload, $this->solution['sid']);
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
        return '[Twilio.Numbers.V2.SupportingDocumentContext ' . implode(' ', $context) . ']';
    }
}