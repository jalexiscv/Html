<?php

namespace Twilio\Rest\Api\V2010\Account;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Queue\MemberList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class QueueInstance extends InstanceResource
{
    protected $_members;

    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'currentSize' => Values::array_get($payload, 'current_size'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'uri' => Values::array_get($payload, 'uri'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'averageWaitTime' => Values::array_get($payload, 'average_wait_time'), 'sid' => Values::array_get($payload, 'sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'maxSize' => Values::array_get($payload, 'max_size'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): QueueContext
    {
        if (!$this->context) {
            $this->context = new QueueContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): QueueInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): QueueInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getMembers(): MemberList
    {
        return $this->proxy()->members;
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
        return '[Twilio.Api.V2010.QueueInstance ' . implode(' ', $context) . ']';
    }
}