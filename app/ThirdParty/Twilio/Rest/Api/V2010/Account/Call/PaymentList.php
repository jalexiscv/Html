<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class PaymentList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $callSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'callSid' => $callSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Calls/' . rawurlencode($callSid) . '/Payments.json';
    }

    public function create(string $idempotencyKey, string $statusCallback, array $options = []): PaymentInstance
    {
        $options = new Values($options);
        $data = Values::of(['IdempotencyKey' => $idempotencyKey, 'StatusCallback' => $statusCallback, 'BankAccountType' => $options['bankAccountType'], 'ChargeAmount' => $options['chargeAmount'], 'Currency' => $options['currency'], 'Description' => $options['description'], 'Input' => $options['input'], 'MinPostalCodeLength' => $options['minPostalCodeLength'], 'Parameter' => Serialize::jsonObject($options['parameter']), 'PaymentConnector' => $options['paymentConnector'], 'PaymentMethod' => $options['paymentMethod'], 'PostalCode' => Serialize::booleanToString($options['postalCode']), 'SecurityCode' => Serialize::booleanToString($options['securityCode']), 'Timeout' => $options['timeout'], 'TokenType' => $options['tokenType'], 'ValidCardTypes' => $options['validCardTypes'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new PaymentInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['callSid']);
    }

    public function getContext(string $sid): PaymentContext
    {
        return new PaymentContext($this->version, $this->solution['accountSid'], $this->solution['callSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.PaymentList]';
    }
}