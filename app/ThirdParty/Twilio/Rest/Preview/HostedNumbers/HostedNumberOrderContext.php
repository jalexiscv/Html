<?php

namespace Twilio\Rest\Preview\HostedNumbers;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class HostedNumberOrderContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/HostedNumberOrders/' . rawurlencode($sid) . '';
    }

    public function fetch(): HostedNumberOrderInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new HostedNumberOrderInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): HostedNumberOrderInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'UniqueName' => $options['uniqueName'], 'Email' => $options['email'], 'CcEmails' => Serialize::map($options['ccEmails'], function ($e) {
            return $e;
        }), 'Status' => $options['status'], 'VerificationCode' => $options['verificationCode'], 'VerificationType' => $options['verificationType'], 'VerificationDocumentSid' => $options['verificationDocumentSid'], 'Extension' => $options['extension'], 'CallDelay' => $options['callDelay'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new HostedNumberOrderInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.HostedNumbers.HostedNumberOrderContext ' . implode(' ', $context) . ']';
    }
}