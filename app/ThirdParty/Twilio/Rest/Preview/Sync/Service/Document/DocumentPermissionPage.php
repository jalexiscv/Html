<?php

namespace Twilio\Rest\Preview\Sync\Service\Document;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class DocumentPermissionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): DocumentPermissionInstance
    {
        return new DocumentPermissionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['documentSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Sync.DocumentPermissionPage]';
    }
}