<?php

namespace Twilio\Rest\Sync\V1\Service\SyncStream;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class StreamMessageList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $streamSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'streamSid' => $streamSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Streams/' . rawurlencode($streamSid) . '/Messages';
    }

    public function create(array $data): StreamMessageInstance
    {
        $data = Values::of(['Data' => Serialize::jsonObject($data),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new StreamMessageInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['streamSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Sync.V1.StreamMessageList]';
    }
}