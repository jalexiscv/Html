<?php

namespace Twilio\Rest\Sync\V1\Service\SyncList;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SyncListItemPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SyncListItemInstance
    {
        return new SyncListItemInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['listSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Sync.V1.SyncListItemPage]';
    }
}