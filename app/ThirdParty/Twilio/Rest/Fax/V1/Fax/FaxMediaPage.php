<?php

namespace Twilio\Rest\Fax\V1\Fax;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FaxMediaPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FaxMediaInstance
    {
        return new FaxMediaInstance($this->version, $payload, $this->solution['faxSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Fax.V1.FaxMediaPage]';
    }
}