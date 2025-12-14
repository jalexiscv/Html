<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ByocTrunkPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): ByocTrunkInstance
    {
        return new ByocTrunkInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.ByocTrunkPage]';
    }
}