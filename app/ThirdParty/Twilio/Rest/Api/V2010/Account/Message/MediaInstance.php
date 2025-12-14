<?php

namespace Twilio\Rest\Api\V2010\Account\Message;

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

class MediaInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $messageSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'contentType' => Values::array_get($payload, 'content_type'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'parentSid' => Values::array_get($payload, 'parent_sid'), 'sid' => Values::array_get($payload, 'sid'), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['accountSid' => $accountSid, 'messageSid' => $messageSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): MediaContext
    {
        if (!$this->context) {
            $this->context = new MediaContext($this->version, $this->solution['accountSid'], $this->solution['messageSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function fetch(): MediaInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Api.V2010.MediaInstance ' . implode(' ', $context) . ']';
    }
}