<?php

namespace Twilio\Rest\Chat\V2;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class CredentialPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): CredentialInstance
    {
        return new CredentialInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Chat.V2.CredentialPage]';
    }
}