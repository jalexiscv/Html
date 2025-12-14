<?php

namespace Twilio\Rest\Trunking\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class TrunkPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): TrunkInstance
    {
        return new TrunkInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Trunking.V1.TrunkPage]';
    }
}