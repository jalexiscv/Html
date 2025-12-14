<?php

namespace Twilio\Rest\Chat\V2\Service\Channel;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class InviteInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $channelSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'channelSid' => Values::array_get($payload, 'channel_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'identity' => Values::array_get($payload, 'identity'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'roleSid' => Values::array_get($payload, 'role_sid'), 'createdBy' => Values::array_get($payload, 'created_by'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'channelSid' => $channelSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): InviteContext
    {
        if (!$this->context) {
            $this->context = new InviteContext($this->version, $this->solution['serviceSid'], $this->solution['channelSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): InviteInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return '[Twilio.Chat.V2.InviteInstance ' . implode(' ', $context) . ']';
    }
}