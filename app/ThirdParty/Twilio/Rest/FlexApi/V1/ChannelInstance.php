<?php

namespace Twilio\Rest\FlexApi\V1;

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

class ChannelInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'flexFlowSid' => Values::array_get($payload, 'flex_flow_sid'), 'sid' => Values::array_get($payload, 'sid'), 'userSid' => Values::array_get($payload, 'user_sid'), 'taskSid' => Values::array_get($payload, 'task_sid'), 'url' => Values::array_get($payload, 'url'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ChannelContext
    {
        if (!$this->context) {
            $this->context = new ChannelContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ChannelInstance
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
        return '[Twilio.FlexApi.V1.ChannelInstance ' . implode(' ', $context) . ']';
    }
}