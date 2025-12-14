<?php

namespace Twilio\Rest\Verify\V2\Service\Entity;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FactorContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $identity, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'identity' => $identity, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Entities/' . rawurlencode($identity) . '/Factors/' . rawurlencode($sid) . '';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): FactorInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FactorInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['identity'], $this->solution['sid']);
    }

    public function update(array $options = []): FactorInstance
    {
        $options = new Values($options);
        $data = Values::of(['AuthPayload' => $options['authPayload'], 'FriendlyName' => $options['friendlyName'], 'Config.NotificationToken' => $options['configNotificationToken'], 'Config.SdkVersion' => $options['configSdkVersion'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new FactorInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['identity'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Verify.V2.FactorContext ' . implode(' ', $context) . ']';
    }
}