<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

class PhoneCallList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Business/PhoneCalls';
    }

    public function create(string $from, string $to, array $options = []): PhoneCallInstance
    {
        $options = new Values($options);
        $data = Values::of(['From' => $from, 'To' => $to, 'Reason' => $options['reason'], 'ApplicationSid' => $options['applicationSid'], 'CallerId' => $options['callerId'], 'FallbackMethod' => $options['fallbackMethod'], 'FallbackUrl' => $options['fallbackUrl'], 'MachineDetection' => $options['machineDetection'], 'MachineDetectionSilenceTimeout' => $options['machineDetectionSilenceTimeout'], 'MachineDetectionSpeechEndThreshold' => $options['machineDetectionSpeechEndThreshold'], 'MachineDetectionSpeechThreshold' => $options['machineDetectionSpeechThreshold'], 'MachineDetectionTimeout' => $options['machineDetectionTimeout'], 'Method' => $options['method'], 'Record' => Serialize::booleanToString($options['record']), 'RecordingChannels' => $options['recordingChannels'], 'RecordingStatusCallback' => $options['recordingStatusCallback'], 'RecordingStatusCallbackEvent' => Serialize::map($options['recordingStatusCallbackEvent'], function ($e) {
            return $e;
        }), 'RecordingStatusCallbackMethod' => $options['recordingStatusCallbackMethod'], 'SendDigits' => $options['sendDigits'], 'SipAuthPassword' => $options['sipAuthPassword'], 'SipAuthUsername' => $options['sipAuthUsername'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackEvent' => Serialize::map($options['statusCallbackEvent'], function ($e) {
            return $e;
        }), 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'Timeout' => $options['timeout'], 'Trim' => $options['trim'], 'Url' => $options['url'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new PhoneCallInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.TrustedComms.PhoneCallList]';
    }
}