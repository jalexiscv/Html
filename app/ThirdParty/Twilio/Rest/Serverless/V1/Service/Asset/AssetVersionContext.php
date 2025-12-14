<?php

namespace Twilio\Rest\Serverless\V1\Service\Asset;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class AssetVersionContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $assetSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'assetSid' => $assetSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Assets/' . rawurlencode($assetSid) . '/Versions/' . rawurlencode($sid) . '';
    }

    public function fetch(): AssetVersionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AssetVersionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['assetSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Serverless.V1.AssetVersionContext ' . implode(' ', $context) . ']';
    }
}