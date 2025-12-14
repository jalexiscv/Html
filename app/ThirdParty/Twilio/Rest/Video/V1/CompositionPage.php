<?php

namespace Twilio\Rest\Video\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class CompositionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): CompositionInstance
    {
        return new CompositionInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.CompositionPage]';
    }
}