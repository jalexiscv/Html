<?php

namespace Twilio\Rest\Api\V2010;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AccountPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AccountInstance
    {
        return new AccountInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AccountPage]';
    }
}