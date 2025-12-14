<?php

namespace Twilio\Rest\Preview\HostedNumbers\AuthorizationDocument;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class DependentHostedNumberOrderPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): DependentHostedNumberOrderInstance
    {
        return new DependentHostedNumberOrderInstance($this->version, $payload, $this->solution['signingDocumentSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.HostedNumbers.DependentHostedNumberOrderPage]';
    }
}