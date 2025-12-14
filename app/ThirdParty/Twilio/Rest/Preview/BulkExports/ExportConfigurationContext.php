<?php

namespace Twilio\Rest\Preview\BulkExports;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ExportConfigurationContext extends InstanceContext
{
    public function __construct(Version $version, $resourceType)
    {
        parent::__construct($version);
        $this->solution = ['resourceType' => $resourceType,];
        $this->uri = '/Exports/' . rawurlencode($resourceType) . '/Configuration';
    }

    public function fetch(): ExportConfigurationInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ExportConfigurationInstance($this->version, $payload, $this->solution['resourceType']);
    }

    public function update(array $options = []): ExportConfigurationInstance
    {
        $options = new Values($options);
        $data = Values::of(['Enabled' => Serialize::booleanToString($options['enabled']), 'WebhookUrl' => $options['webhookUrl'], 'WebhookMethod' => $options['webhookMethod'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ExportConfigurationInstance($this->version, $payload, $this->solution['resourceType']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.BulkExports.ExportConfigurationContext ' . implode(' ', $context) . ']';
    }
}