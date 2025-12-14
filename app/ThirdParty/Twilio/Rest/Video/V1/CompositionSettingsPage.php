<?php

namespace Twilio\Rest\Video\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class CompositionSettingsPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): CompositionSettingsInstance
    {
        return new CompositionSettingsInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.CompositionSettingsPage]';
    }
}