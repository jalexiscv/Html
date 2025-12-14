<?php

namespace Twilio\Rest\Sync\V1\Service\SyncStream;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class StreamMessageInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $streamSid)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'data' => Values::array_get($payload, 'data'),];
        $this->solution = ['serviceSid' => $serviceSid, 'streamSid' => $streamSid,];
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
        return '[Twilio.Sync.V1.StreamMessageInstance]';
    }
}