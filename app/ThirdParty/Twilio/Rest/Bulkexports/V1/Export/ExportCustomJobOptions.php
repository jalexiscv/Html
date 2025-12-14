<?php

namespace Twilio\Rest\Bulkexports\V1\Export;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ExportCustomJobOptions
{
    public static function create(string $webhookUrl = Values::NONE, string $webhookMethod = Values::NONE, string $email = Values::NONE): CreateExportCustomJobOptions
    {
        return new CreateExportCustomJobOptions($webhookUrl, $webhookMethod, $email);
    }
}

class CreateExportCustomJobOptions extends Options
{
    public function __construct(string $webhookUrl = Values::NONE, string $webhookMethod = Values::NONE, string $email = Values::NONE)
    {
        $this->options['webhookUrl'] = $webhookUrl;
        $this->options['webhookMethod'] = $webhookMethod;
        $this->options['email'] = $email;
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

    public function setEmail(string $email): self
    {
        $this->options['email'] = $email;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Bulkexports.V1.CreateExportCustomJobOptions ' . $options . ']';
    }
}