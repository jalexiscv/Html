<?php

namespace Twilio\Rest\Events\V1\Sink;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class SinkValidateList extends ListResource
{
    public function __construct(Version $version, string $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Sinks/' . rawurlencode($sid) . '/Validate';
    }

    public function create(string $testId): SinkValidateInstance
    {
        $data = Values::of(['TestId' => $testId,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new SinkValidateInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Events.V1.SinkValidateList]';
    }
}