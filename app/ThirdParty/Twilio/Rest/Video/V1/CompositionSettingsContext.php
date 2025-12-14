<?php

namespace Twilio\Rest\Video\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;

class CompositionSettingsContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/CompositionSettings/Default';
    }

    public function fetch(): CompositionSettingsInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new CompositionSettingsInstance($this->version, $payload);
    }

    public function create(string $friendlyName, array $options = []): CompositionSettingsInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'AwsCredentialsSid' => $options['awsCredentialsSid'], 'EncryptionKeySid' => $options['encryptionKeySid'], 'AwsS3Url' => $options['awsS3Url'], 'AwsStorageEnabled' => Serialize::booleanToString($options['awsStorageEnabled']), 'EncryptionEnabled' => Serialize::booleanToString($options['encryptionEnabled']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new CompositionSettingsInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Video.V1.CompositionSettingsContext ' . implode(' ', $context) . ']';
    }
}