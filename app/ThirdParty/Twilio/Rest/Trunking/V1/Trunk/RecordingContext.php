<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class RecordingContext extends InstanceContext
{
    public function __construct(Version $version, $trunkSid)
    {
        parent::__construct($version);
        $this->solution = ['trunkSid' => $trunkSid,];
        $this->uri = '/Trunks/' . rawurlencode($trunkSid) . '/Recording';
    }

    public function fetch(): RecordingInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new RecordingInstance($this->version, $payload, $this->solution['trunkSid']);
    }

    public function update(array $options = []): RecordingInstance
    {
        $options = new Values($options);
        $data = Values::of(['Mode' => $options['mode'], 'Trim' => $options['trim'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new RecordingInstance($this->version, $payload, $this->solution['trunkSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Trunking.V1.RecordingContext ' . implode(' ', $context) . ']';
    }
}