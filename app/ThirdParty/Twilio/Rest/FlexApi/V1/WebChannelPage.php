<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class WebChannelPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): WebChannelInstance
    {
        return new WebChannelInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.FlexApi.V1.WebChannelPage]';
    }
}