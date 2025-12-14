<?php

namespace Twilio\Rest\Preview\HostedNumbers;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class HostedNumberOrderInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'incomingPhoneNumberSid' => Values::array_get($payload, 'incoming_phone_number_sid'), 'addressSid' => Values::array_get($payload, 'address_sid'), 'signingDocumentSid' => Values::array_get($payload, 'signing_document_sid'), 'phoneNumber' => Values::array_get($payload, 'phone_number'), 'capabilities' => Values::array_get($payload, 'capabilities'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'status' => Values::array_get($payload, 'status'), 'failureReason' => Values::array_get($payload, 'failure_reason'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'verificationAttempts' => Values::array_get($payload, 'verification_attempts'), 'email' => Values::array_get($payload, 'email'), 'ccEmails' => Values::array_get($payload, 'cc_emails'), 'url' => Values::array_get($payload, 'url'), 'verificationType' => Values::array_get($payload, 'verification_type'), 'verificationDocumentSid' => Values::array_get($payload, 'verification_document_sid'), 'extension' => Values::array_get($payload, 'extension'), 'callDelay' => Values::array_get($payload, 'call_delay'), 'verificationCode' => Values::array_get($payload, 'verification_code'), 'verificationCallSids' => Values::array_get($payload, 'verification_call_sids'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): HostedNumberOrderContext
    {
        if (!$this->context) {
            $this->context = new HostedNumberOrderContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): HostedNumberOrderInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): HostedNumberOrderInstance
    {
        return $this->proxy()->update($options);
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
        return '[Twilio.Preview.HostedNumbers.HostedNumberOrderInstance ' . implode(' ', $context) . ']';
    }
}