<?php

namespace Twilio\Rest\Preview\Marketplace\InstalledAddOn;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class InstalledAddOnExtensionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): InstalledAddOnExtensionInstance
    {
        return new InstalledAddOnExtensionInstance($this->version, $payload, $this->solution['installedAddOnSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Marketplace.InstalledAddOnExtensionPage]';
    }
}