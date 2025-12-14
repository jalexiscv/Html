<?php

namespace Twilio\Rest\Video\V1\Room;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class RecordingRulesList extends ListResource
{
    public function __construct(Version $version, string $roomSid)
    {
        parent::__construct($version);
        $this->solution = ['roomSid' => $roomSid,];
        $this->uri = '/Rooms/' . rawurlencode($roomSid) . '/RecordingRules';
    }

    public function fetch(): RecordingRulesInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new RecordingRulesInstance($this->version, $payload, $this->solution['roomSid']);
    }

    public function update(array $options = []): RecordingRulesInstance
    {
        $options = new Values($options);
        $data = Values::of(['Rules' => Serialize::jsonObject($options['rules']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new RecordingRulesInstance($this->version, $payload, $this->solution['roomSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.RecordingRulesList]';
    }
}