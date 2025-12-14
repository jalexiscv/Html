<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SupportingDocumentOptions
{
    public static function create(array $attributes = Values::ARRAY_NONE): CreateSupportingDocumentOptions
    {
        return new CreateSupportingDocumentOptions($attributes);
    }

    public static function update(string $friendlyName = Values::NONE, array $attributes = Values::ARRAY_NONE): UpdateSupportingDocumentOptions
    {
        return new UpdateSupportingDocumentOptions($friendlyName, $attributes);
    }
}

class CreateSupportingDocumentOptions extends Options
{
    public function __construct(array $attributes = Values::ARRAY_NONE)
    {
        $this->options['attributes'] = $attributes;
    }

    public function setAttributes(array $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Numbers.V2.CreateSupportingDocumentOptions ' . $options . ']';
    }
}

class UpdateSupportingDocumentOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, array $attributes = Values::ARRAY_NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['attributes'] = $attributes;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setAttributes(array $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Numbers.V2.UpdateSupportingDocumentOptions ' . $options . ']';
    }
}