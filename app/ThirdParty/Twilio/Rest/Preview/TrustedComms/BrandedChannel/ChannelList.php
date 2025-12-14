<?php

namespace Twilio\Rest\Preview\TrustedComms\BrandedChannel;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class ChannelList extends ListResource
{
    public function __construct(Version $version, string $brandedChannelSid)
    {
        parent::__construct($version);
        $this->solution = ['brandedChannelSid' => $brandedChannelSid,];
        $this->uri = '/BrandedChannels/' . rawurlencode($brandedChannelSid) . '/Channels';
    }

    public function create(string $phoneNumberSid): ChannelInstance
    {
        $data = Values::of(['PhoneNumberSid' => $phoneNumberSid,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ChannelInstance($this->version, $payload, $this->solution['brandedChannelSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.ChannelList]';
    }
}