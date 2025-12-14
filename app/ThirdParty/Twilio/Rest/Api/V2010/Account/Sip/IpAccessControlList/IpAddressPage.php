<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlList;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class IpAddressPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): IpAddressInstance
    {
        return new IpAddressInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['ipAccessControlListSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.IpAddressPage]';
    }
}