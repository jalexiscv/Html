<?php

namespace Twilio\Rest\Verify\V2\Service\Entity;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FactorPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FactorInstance
    {
        return new FactorInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['identity']);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.FactorPage]';
    }
}