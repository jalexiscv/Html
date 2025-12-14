<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class RolePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): RoleInstance
    {
        return new RoleInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.RolePage]';
    }
}