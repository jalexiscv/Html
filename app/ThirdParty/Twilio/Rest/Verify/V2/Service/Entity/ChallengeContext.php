<?php

namespace Twilio\Rest\Verify\V2\Service\Entity;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ChallengeContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $identity, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'identity' => $identity, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Entities/' . rawurlencode($identity) . '/Challenges/' . rawurlencode($sid) . '';
    }

    public function fetch(): ChallengeInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ChallengeInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['identity'], $this->solution['sid']);
    }

    public function update(array $options = []): ChallengeInstance
    {
        $options = new Values($options);
        $data = Values::of(['AuthPayload' => $options['authPayload'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ChallengeInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['identity'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Verify.V2.ChallengeContext ' . implode(' ', $context) . ']';
    }
}