<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Brand;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class BrandedChannelPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): BrandedChannelInstance
    {
        return new BrandedChannelInstance($this->version, $payload, $this->solution['businessSid'], $this->solution['brandSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.BrandedChannelPage]';
    }
}