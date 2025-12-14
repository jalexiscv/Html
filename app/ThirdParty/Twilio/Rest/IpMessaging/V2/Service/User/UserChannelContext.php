<?php

namespace Twilio\Rest\IpMessaging\V2\Service\User;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class UserChannelContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $userSid, $channelSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'userSid' => $userSid, 'channelSid' => $channelSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Users/' . rawurlencode($userSid) . '/Channels/' . rawurlencode($channelSid) . '';
    }

    public function fetch(): UserChannelInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new UserChannelInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['userSid'], $this->solution['channelSid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): UserChannelInstance
    {
        $options = new Values($options);
        $data = Values::of(['NotificationLevel' => $options['notificationLevel'], 'LastConsumedMessageIndex' => $options['lastConsumedMessageIndex'], 'LastConsumptionTimestamp' => Serialize::iso8601DateTime($options['lastConsumptionTimestamp']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new UserChannelInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['userSid'], $this->solution['channelSid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.IpMessaging.V2.UserChannelContext ' . implode(' ', $context) . ']';
    }
}