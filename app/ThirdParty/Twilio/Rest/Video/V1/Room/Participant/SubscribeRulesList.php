<?php

namespace Twilio\Rest\Video\V1\Room\Participant;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class SubscribeRulesList extends ListResource
{
    public function __construct(Version $version, string $roomSid, string $participantSid)
    {
        parent::__construct($version);
        $this->solution = ['roomSid' => $roomSid, 'participantSid' => $participantSid,];
        $this->uri = '/Rooms/' . rawurlencode($roomSid) . '/Participants/' . rawurlencode($participantSid) . '/SubscribeRules';
    }

    public function fetch(): SubscribeRulesInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SubscribeRulesInstance($this->version, $payload, $this->solution['roomSid'], $this->solution['participantSid']);
    }

    public function update(array $options = []): SubscribeRulesInstance
    {
        $options = new Values($options);
        $data = Values::of(['Rules' => Serialize::jsonObject($options['rules']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SubscribeRulesInstance($this->version, $payload, $this->solution['roomSid'], $this->solution['participantSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.SubscribeRulesList]';
    }
}