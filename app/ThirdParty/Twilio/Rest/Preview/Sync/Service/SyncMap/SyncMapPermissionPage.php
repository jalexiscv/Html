<?php

namespace Twilio\Rest\Preview\Sync\Service\SyncMap;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SyncMapPermissionPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SyncMapPermissionInstance
    {
        return new SyncMapPermissionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['mapSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Sync.SyncMapPermissionPage]';
    }
}