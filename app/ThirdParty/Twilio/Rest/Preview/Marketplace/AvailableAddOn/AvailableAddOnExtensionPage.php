<?php

namespace Twilio\Rest\Preview\Marketplace\AvailableAddOn;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AvailableAddOnExtensionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AvailableAddOnExtensionInstance
    {
        return new AvailableAddOnExtensionInstance($this->version, $payload, $this->solution['availableAddOnSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Marketplace.AvailableAddOnExtensionPage]';
    }
}