<?php

namespace Twilio\Rest\Serverless\V1\Service\Asset;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AssetVersionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $assetSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'assetSid' => Values::array_get($payload, 'asset_sid'), 'path' => Values::array_get($payload, 'path'), 'visibility' => Values::array_get($payload, 'visibility'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'assetSid' => $assetSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): AssetVersionContext
    {
        if (!$this->context) {
            $this->context = new AssetVersionContext($this->version, $this->solution['serviceSid'], $this->solution['assetSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): AssetVersionInstance
    {
        return $this->proxy()->fetch();
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Serverless.V1.AssetVersionInstance ' . implode(' ', $context) . ']';
    }
}