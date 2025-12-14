<?php

namespace Twilio\Rest\Supersim\V1\NetworkAccessProfile;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class NetworkAccessProfileNetworkPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): NetworkAccessProfileNetworkInstance
    {
        return new NetworkAccessProfileNetworkInstance($this->version, $payload, $this->solution['networkAccessProfileSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Supersim.V1.NetworkAccessProfileNetworkPage]';
    }
}