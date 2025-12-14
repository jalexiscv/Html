<?php

namespace Twilio\Rest\Lookups\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function array_merge;
use function implode;
use function rawurlencode;

class PhoneNumberContext extends InstanceContext
{
    public function __construct(Version $version, $phoneNumber)
    {
        parent::__construct($version);
        $this->solution = ['phoneNumber' => $phoneNumber,];
        $this->uri = '/PhoneNumbers/' . rawurlencode($phoneNumber) . '';
    }

    public function fetch(array $options = []): PhoneNumberInstance
    {
        $options = new Values($options);
        $params = Values::of(['CountryCode' => $options['countryCode'], 'Type' => Serialize::map($options['type'], function ($e) {
            return $e;
        }), 'AddOns' => Serialize::map($options['addOns'], function ($e) {
            return $e;
        }),]);
        $params = array_merge($params, Serialize::prefixedCollapsibleMap($options['addOnsData'], 'AddOns'));
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new PhoneNumberInstance($this->version, $payload, $this->solution['phoneNumber']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Lookups.V1.PhoneNumberContext ' . implode(' ', $context) . ']';
    }
}