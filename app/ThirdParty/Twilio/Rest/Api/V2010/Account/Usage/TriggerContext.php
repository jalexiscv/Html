<?php

namespace Twilio\Rest\Api\V2010\Account\Usage;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class TriggerContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Usage/Triggers/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): TriggerInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new TriggerInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function update(array $options = []): TriggerInstance
    {
        $options = new Values($options);
        $data = Values::of(['CallbackMethod' => $options['callbackMethod'], 'CallbackUrl' => $options['callbackUrl'], 'FriendlyName' => $options['friendlyName'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new TriggerInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.TriggerContext ' . implode(' ', $context) . ']';
    }
}