<?php

namespace Twilio\Rest\Preview\TrustedComms;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class BrandedCallInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'bgColor' => Values::array_get($payload, 'bg_color'), 'brandSid' => Values::array_get($payload, 'brand_sid'), 'brandedChannelSid' => Values::array_get($payload, 'branded_channel_sid'), 'businessSid' => Values::array_get($payload, 'business_sid'), 'callSid' => Values::array_get($payload, 'call_sid'), 'caller' => Values::array_get($payload, 'caller'), 'createdAt' => Deserialize::dateTime(Values::array_get($payload, 'created_at')), 'fontColor' => Values::array_get($payload, 'font_color'), 'from' => Values::array_get($payload, 'from'), 'logo' => Values::array_get($payload, 'logo'), 'phoneNumberSid' => Values::array_get($payload, 'phone_number_sid'), 'reason' => Values::array_get($payload, 'reason'), 'sid' => Values::array_get($payload, 'sid'), 'status' => Values::array_get($payload, 'status'), 'to' => Values::array_get($payload, 'to'), 'url' => Values::array_get($payload, 'url'), 'useCase' => Values::array_get($payload, 'use_case'),];
        $this->solution = [];
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
        return '[Twilio.Preview.TrustedComms.BrandedCallInstance]';
    }
}