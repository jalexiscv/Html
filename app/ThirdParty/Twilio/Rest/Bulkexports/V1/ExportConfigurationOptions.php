<?php

namespace Twilio\Rest\Bulkexports\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ExportConfigurationOptions
{
    public static function update(bool $enabled = Values::NONE, string $webhookUrl = Values::NONE, string $webhookMethod = Values::NONE): UpdateExportConfigurationOptions
    {
        return new UpdateExportConfigurationOptions($enabled, $webhookUrl, $webhookMethod);
    }
}

class UpdateExportConfigurationOptions extends Options
{
    public function __construct(bool $enabled = Values::NONE, string $webhookUrl = Values::NONE, string $webhookMethod = Values::NONE)
    {
        $this->options['enabled'] = $enabled;
        $this->options['webhookUrl'] = $webhookUrl;
        $this->options['webhookMethod'] = $webhookMethod;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->options['enabled'] = $enabled;
        return $this;
    }

    public function setWebhookUrl(string $webhookUrl): self
    {
        $this->options['webhookUrl'] = $webhookUrl;
        return $this;
    }

    public function setWebhookMethod(string $webhookMethod): self
    {
        $this->options['webhookMethod'] = $webhookMethod;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Bulkexports.V1.UpdateExportConfigurationOptions ' . $options . ']';
    }
}