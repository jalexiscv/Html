<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes\AuthTypeRegistrations;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AuthRegistrationsCredentialListMappingPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AuthRegistrationsCredentialListMappingInstance
    {
        return new AuthRegistrationsCredentialListMappingInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['domainSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AuthRegistrationsCredentialListMappingPage]';
    }
}