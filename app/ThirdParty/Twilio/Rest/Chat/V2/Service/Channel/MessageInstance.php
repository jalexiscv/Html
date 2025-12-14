<?php

namespace Twilio\Rest\Chat\V2\Service\Channel;

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

class MessageInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $channelSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'attributes' => Values::array_get($payload, 'attributes'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'to' => Values::array_get($payload, 'to'), 'channelSid' => Values::array_get($payload, 'channel_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'lastUpdatedBy' => Values::array_get($payload, 'last_updated_by'), 'wasEdited' => Values::array_get($payload, 'was_edited'), 'from' => Values::array_get($payload, 'from'), 'body' => Values::array_get($payload, 'body'), 'index' => Values::array_get($payload, 'index'), 'type' => Values::array_get($payload, 'type'), 'media' => Values::array_get($payload, 'media'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'channelSid' => $channelSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): MessageContext
    {
        if (!$this->context) {
            $this->context = new MessageContext($this->version, $this->solution['serviceSid'], $this->solution['channelSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): MessageInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(array $options = []): bool
    {
        return $this->proxy()->delete($options);
    }

    public function update(array $options = []): MessageInstance
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
        return '[Twilio.Chat.V2.MessageInstance ' . implode(' ', $context) . ']';
    }
}