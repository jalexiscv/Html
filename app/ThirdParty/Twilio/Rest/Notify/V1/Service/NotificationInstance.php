<?php

namespace Twilio\Rest\Notify\V1\Service;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class NotificationInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'identities' => Values::array_get($payload, 'identities'), 'tags' => Values::array_get($payload, 'tags'), 'segments' => Values::array_get($payload, 'segments'), 'priority' => Values::array_get($payload, 'priority'), 'ttl' => Values::array_get($payload, 'ttl'), 'title' => Values::array_get($payload, 'title'), 'body' => Values::array_get($payload, 'body'), 'sound' => Values::array_get($payload, 'sound'), 'action' => Values::array_get($payload, 'action'), 'data' => Values::array_get($payload, 'data'), 'apn' => Values::array_get($payload, 'apn'), 'gcm' => Values::array_get($payload, 'gcm'), 'fcm' => Values::array_get($payload, 'fcm'), 'sms' => Values::array_get($payload, 'sms'), 'facebookMessenger' => Values::array_get($payload, 'facebook_messenger'), 'alexa' => Values::array_get($payload, 'alexa'),];
        $this->solution = ['serviceSid' => $serviceSid,];
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
        return '[Twilio.Notify.V1.NotificationInstance]';
    }
}