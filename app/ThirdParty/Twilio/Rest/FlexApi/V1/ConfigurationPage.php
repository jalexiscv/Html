<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ConfigurationPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ConfigurationInstance
    {
        return new ConfigurationInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.FlexApi.V1.ConfigurationPage]';
    }
}