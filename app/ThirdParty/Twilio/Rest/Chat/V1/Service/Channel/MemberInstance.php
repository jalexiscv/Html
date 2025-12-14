<?php

namespace Twilio\Rest\Chat\V1\Service\Channel;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class MemberInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $channelSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'channelSid' => Values::array_get($payload, 'channel_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'identity' => Values::array_get($payload, 'identity'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'roleSid' => Values::array_get($payload, 'role_sid'), 'lastConsumedMessageIndex' => Values::array_get($payload, 'last_consumed_message_index'), 'lastConsumptionTimestamp' => Deserialize::dateTime(Values::array_get($payload, 'last_consumption_timestamp')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'channelSid' => $channelSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): MemberContext
    {
        if (!$this->context) {
            $this->context = new MemberContext($this->version, $this->solution['serviceSid'], $this->solution['channelSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): MemberInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): MemberInstance
    {
        return $this->proxy()->update($options);
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Chat.V1.MemberInstance ' . implode(' ', $context) . ']';
    }
}