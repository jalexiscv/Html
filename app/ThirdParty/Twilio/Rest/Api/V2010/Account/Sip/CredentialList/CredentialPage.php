<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\CredentialList;

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
        return new CredentialInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['credentialListSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.CredentialPage]';
    }
}