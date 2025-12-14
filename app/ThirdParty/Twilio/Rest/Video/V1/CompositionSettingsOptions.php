<?php

namespace Twilio\Rest\Video\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CompositionSettingsOptions
{
    public static function create(string $awsCredentialsSid = Values::NONE, string $encryptionKeySid = Values::NONE, string $awsS3Url = Values::NONE, bool $awsStorageEnabled = Values::NONE, bool $encryptionEnabled = Values::NONE): CreateCompositionSettingsOptions
    {
        return new CreateCompositionSettingsOptions($awsCredentialsSid, $encryptionKeySid, $awsS3Url, $awsStorageEnabled, $encryptionEnabled);
    }
}

class CreateCompositionSettingsOptions extends Options
{
    public function __construct(string $awsCredentialsSid = Values::NONE, string $encryptionKeySid = Values::NONE, string $awsS3Url = Values::NONE, bool $awsStorageEnabled = Values::NONE, bool $encryptionEnabled = Values::NONE)
    {
        $this->options['awsCredentialsSid'] = $awsCredentialsSid;
        $this->options['encryptionKeySid'] = $encryptionKeySid;
        $this->options['awsS3Url'] = $awsS3Url;
        $this->options['awsStorageEnabled'] = $awsStorageEnabled;
        $this->options['encryptionEnabled'] = $encryptionEnabled;
    }

    public function setAwsCredentialsSid(string $awsCredentialsSid): self
    {
        $this->options['awsCredentialsSid'] = $awsCredentialsSid;
        return $this;
    }

    public function setEncryptionKeySid(string $encryptionKeySid): self
    {
        $this->options['encryptionKeySid'] = $encryptionKeySid;
        return $this;
    }

    public function setAwsS3Url(string $awsS3Url): self
    {
        $this->options['awsS3Url'] = $awsS3Url;
        return $this;
    }

    public function setAwsStorageEnabled(bool $awsStorageEnabled): self
    {
        $this->options['awsStorageEnabled'] = $awsStorageEnabled;
        return $this;
    }

    public function setEncryptionEnabled(bool $encryptionEnabled): self
    {
        $this->options['encryptionEnabled'] = $encryptionEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.CreateCompositionSettingsOptions ' . $options . ']';
    }
}