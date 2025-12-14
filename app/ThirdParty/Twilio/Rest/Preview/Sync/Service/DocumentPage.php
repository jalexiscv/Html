<?php

namespace Twilio\Rest\Preview\Sync\Service;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class DocumentPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): DocumentInstance
    {
        return new DocumentInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Sync.DocumentPage]';
    }
}