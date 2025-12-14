<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

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

class NotificationInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $callSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'callSid' => Values::array_get($payload, 'call_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'errorCode' => Values::array_get($payload, 'error_code'), 'log' => Values::array_get($payload, 'log'), 'messageDate' => Deserialize::dateTime(Values::array_get($payload, 'message_date')), 'messageText' => Values::array_get($payload, 'message_text'), 'moreInfo' => Values::array_get($payload, 'more_info'), 'requestMethod' => Values::array_get($payload, 'request_method'), 'requestUrl' => Values::array_get($payload, 'request_url'), 'requestVariables' => Values::array_get($payload, 'request_variables'), 'responseBody' => Values::array_get($payload, 'response_body'), 'responseHeaders' => Values::array_get($payload, 'response_headers'), 'sid' => Values::array_get($payload, 'sid'), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['accountSid' => $accountSid, 'callSid' => $callSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): NotificationContext
    {
        if (!$this->context) {
            $this->context = new NotificationContext($this->version, $this->solution['accountSid'], $this->solution['callSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): NotificationInstance
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
        return '[Twilio.Api.V2010.NotificationInstance ' . implode(' ', $context) . ']';
    }
}