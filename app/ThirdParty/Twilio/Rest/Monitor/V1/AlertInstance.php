<?php

namespace Twilio\Rest\Monitor\V1;

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

class AlertInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'alertText' => Values::array_get($payload, 'alert_text'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateGenerated' => Deserialize::dateTime(Values::array_get($payload, 'date_generated')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'errorCode' => Values::array_get($payload, 'error_code'), 'logLevel' => Values::array_get($payload, 'log_level'), 'moreInfo' => Values::array_get($payload, 'more_info'), 'requestMethod' => Values::array_get($payload, 'request_method'), 'requestUrl' => Values::array_get($payload, 'request_url'), 'requestVariables' => Values::array_get($payload, 'request_variables'), 'resourceSid' => Values::array_get($payload, 'resource_sid'), 'responseBody' => Values::array_get($payload, 'response_body'), 'responseHeaders' => Values::array_get($payload, 'response_headers'), 'sid' => Values::array_get($payload, 'sid'), 'url' => Values::array_get($payload, 'url'), 'requestHeaders' => Values::array_get($payload, 'request_headers'), 'serviceSid' => Values::array_get($payload, 'service_sid'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): AlertContext
    {
        if (!$this->context) {
            $this->context = new AlertContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): AlertInstance
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
        return '[Twilio.Monitor.V1.AlertInstance ' . implode(' ', $context) . ']';
    }
}