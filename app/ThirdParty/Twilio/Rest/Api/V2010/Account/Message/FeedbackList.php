<?php

namespace Twilio\Rest\Api\V2010\Account\Message;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class FeedbackList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $messageSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'messageSid' => $messageSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Messages/' . rawurlencode($messageSid) . '/Feedback.json';
    }

    public function create(array $options = []): FeedbackInstance
    {
        $options = new Values($options);
        $data = Values::of(['Outcome' => $options['outcome'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new FeedbackInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['messageSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.FeedbackList]';
    }
}