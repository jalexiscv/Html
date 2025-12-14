<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class MessagingConfigurationContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $country)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'country' => $country,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/MessagingConfigurations/' . rawurlencode($country) . '';
    }

    public function update(string $messagingServiceSid): MessagingConfigurationInstance
    {
        $data = Values::of(['MessagingServiceSid' => $messagingServiceSid,]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new MessagingConfigurationInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['country']);
    }

    public function fetch(): MessagingConfigurationInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new MessagingConfigurationInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['country']);
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
        return '[Twilio.Verify.V2.MessagingConfigurationContext ' . implode(' ', $context) . ']';
    }
}