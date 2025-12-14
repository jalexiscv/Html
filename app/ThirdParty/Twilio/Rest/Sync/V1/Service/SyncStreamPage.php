<?php

namespace Twilio\Rest\Sync\V1\Service;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SyncStreamPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SyncStreamInstance
    {
        return new SyncStreamInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Sync.V1.SyncStreamPage]';
    }
}