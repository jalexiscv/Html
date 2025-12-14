<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class ValidationRequestList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/OutgoingCallerIds.json';
    }

    public function create(string $phoneNumber, array $options = []): ValidationRequestInstance
    {
        $options = new Values($options);
        $data = Values::of(['PhoneNumber' => $phoneNumber, 'FriendlyName' => $options['friendlyName'], 'CallDelay' => $options['callDelay'], 'Extension' => $options['extension'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ValidationRequestInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.ValidationRequestList]';
    }
}