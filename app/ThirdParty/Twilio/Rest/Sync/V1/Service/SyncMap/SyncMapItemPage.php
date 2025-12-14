<?php

namespace Twilio\Rest\Sync\V1\Service\SyncMap;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SyncMapItemPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SyncMapItemInstance
    {
        return new SyncMapItemInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['mapSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Sync.V1.SyncMapItemPage]';
    }
}