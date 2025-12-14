<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Brand\BrandedChannel;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ChannelPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ChannelInstance
    {
        return new ChannelInstance($this->version, $payload, $this->solution['businessSid'], $this->solution['brandSid'], $this->solution['brandedChannelSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.ChannelPage]';
    }
}