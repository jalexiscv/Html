<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Brand\BrandedChannel;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class ChannelList extends ListResource
{
    public function __construct(Version $version, string $businessSid, string $brandSid, string $brandedChannelSid)
    {
        parent::__construct($version);
        $this->solution = ['businessSid' => $businessSid, 'brandSid' => $brandSid, 'brandedChannelSid' => $brandedChannelSid,];
        $this->uri = '/Businesses/' . rawurlencode($businessSid) . '/Brands/' . rawurlencode($brandSid) . '/BrandedChannels/' . rawurlencode($brandedChannelSid) . '/Channels';
    }

    public function create(string $phoneNumberSid): ChannelInstance
    {
        $data = Values::of(['PhoneNumberSid' => $phoneNumberSid,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ChannelInstance($this->version, $payload, $this->solution['businessSid'], $this->solution['brandSid'], $this->solution['brandedChannelSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.ChannelList]';
    }
}