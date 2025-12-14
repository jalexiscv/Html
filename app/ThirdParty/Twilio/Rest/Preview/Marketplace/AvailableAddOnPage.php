<?php

namespace Twilio\Rest\Preview\Marketplace;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AvailableAddOnPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AvailableAddOnInstance
    {
        return new AvailableAddOnInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Marketplace.AvailableAddOnPage]';
    }
}