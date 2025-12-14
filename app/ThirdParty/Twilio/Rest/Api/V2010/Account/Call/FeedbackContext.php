<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FeedbackContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $callSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'callSid' => $callSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Calls/' . rawurlencode($callSid) . '/Feedback.json';
    }

    public function create(int $qualityScore, array $options = []): FeedbackInstance
    {
        $options = new Values($options);
        $data = Values::of(['QualityScore' => $qualityScore, 'Issue' => Serialize::map($options['issue'], function ($e) {
            return $e;
        }),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new FeedbackInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['callSid']);
    }

    public function fetch(): FeedbackInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FeedbackInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['callSid']);
    }

    public function update(int $qualityScore, array $options = []): FeedbackInstance
    {
        $options = new Values($options);
        $data = Values::of(['QualityScore' => $qualityScore, 'Issue' => Serialize::map($options['issue'], function ($e) {
            return $e;
        }),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new FeedbackInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['callSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.FeedbackContext ' . implode(' ', $context) . ']';
    }
}