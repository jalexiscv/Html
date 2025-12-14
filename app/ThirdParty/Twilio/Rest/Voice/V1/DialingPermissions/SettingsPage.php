<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SettingsPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SettingsInstance
    {
        return new SettingsInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.SettingsPage]';
    }
}