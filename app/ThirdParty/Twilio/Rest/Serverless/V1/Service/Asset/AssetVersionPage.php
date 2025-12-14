<?php

namespace Twilio\Rest\Serverless\V1\Service\Asset;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class AssetVersionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): AssetVersionInstance
    {
        return new AssetVersionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['assetSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.AssetVersionPage]';
    }
}