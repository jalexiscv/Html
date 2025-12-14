<?php

namespace Twilio\Rest\Video\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class CompositionSettingsInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'awsCredentialsSid' => Values::array_get($payload, 'aws_credentials_sid'), 'awsS3Url' => Values::array_get($payload, 'aws_s3_url'), 'awsStorageEnabled' => Values::array_get($payload, 'aws_storage_enabled'), 'encryptionKeySid' => Values::array_get($payload, 'encryption_key_sid'), 'encryptionEnabled' => Values::array_get($payload, 'encryption_enabled'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = [];
    }

    protected function proxy(): CompositionSettingsContext
    {
        if (!$this->context) {
            $this->context = new CompositionSettingsContext($this->version);
        }
        return $this->context;
    }

    public function fetch(): CompositionSettingsInstance
    {
        return $this->proxy()->fetch();
    }

    public function create(string $friendlyName, array $options = []): CompositionSettingsInstance
    {
        return $this->proxy()->create($friendlyName, $options);
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
        return '[Twilio.Video.V1.CompositionSettingsInstance ' . implode(' ', $context) . ']';
    }
}