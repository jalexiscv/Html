<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class PaymentContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $callSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'callSid' => $callSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Calls/' . rawurlencode($callSid) . '/Payments/' . rawurlencode($sid) . '.json';
    }

    public function update(string $idempotencyKey, string $statusCallback, array $options = []): PaymentInstance
    {
        $options = new Values($options);
        $data = Values::of(['IdempotencyKey' => $idempotencyKey, 'StatusCallback' => $statusCallback, 'Capture' => $options['capture'], 'Status' => $options['status'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new PaymentInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['callSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.PaymentContext ' . implode(' ', $context) . ']';
    }
}