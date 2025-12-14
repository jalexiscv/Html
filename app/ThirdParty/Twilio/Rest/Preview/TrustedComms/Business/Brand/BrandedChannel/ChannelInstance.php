<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Brand\BrandedChannel;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class ChannelInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $businessSid, string $brandSid, string $brandedChannelSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'businessSid' => Values::array_get($payload, 'business_sid'), 'brandSid' => Values::array_get($payload, 'brand_sid'), 'brandedChannelSid' => Values::array_get($payload, 'branded_channel_sid'), 'phoneNumberSid' => Values::array_get($payload, 'phone_number_sid'), 'phoneNumber' => Values::array_get($payload, 'phone_number'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['businessSid' => $businessSid, 'brandSid' => $brandSid, 'brandedChannelSid' => $brandedChannelSid,];
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
        return '[Twilio.Preview.TrustedComms.ChannelInstance]';
    }
}