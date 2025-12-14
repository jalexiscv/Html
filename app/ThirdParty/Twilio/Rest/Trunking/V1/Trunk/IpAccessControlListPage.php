<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class IpAccessControlListPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): IpAccessControlListInstance
    {
        return new IpAccessControlListInstance($this->version, $payload, $this->solution['trunkSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Trunking.V1.IpAccessControlListPage]';
    }
}