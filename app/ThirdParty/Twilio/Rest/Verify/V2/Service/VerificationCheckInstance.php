<?php

namespace Twilio\Rest\Verify\V2\Service;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class VerificationCheckInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'to' => Values::array_get($payload, 'to'), 'channel' => Values::array_get($payload, 'channel'), 'status' => Values::array_get($payload, 'status'), 'valid' => Values::array_get($payload, 'valid'), 'amount' => Values::array_get($payload, 'amount'), 'payee' => Values::array_get($payload, 'payee'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),];
        $this->solution = ['serviceSid' => $serviceSid,];
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
        return '[Twilio.Verify.V2.VerificationCheckInstance]';
    }
}