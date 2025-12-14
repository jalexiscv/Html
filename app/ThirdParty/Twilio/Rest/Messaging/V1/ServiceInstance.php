<?php

namespace Twilio\Rest\Messaging\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Messaging\V1\Service\AlphaSenderList;
use Twilio\Rest\Messaging\V1\Service\PhoneNumberList;
use Twilio\Rest\Messaging\V1\Service\ShortCodeList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ServiceInstance extends InstanceResource
{
    protected $_phoneNumbers;
    protected $_shortCodes;
    protected $_alphaSenders;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'inboundRequestUrl' => Values::array_get($payload, 'inbound_request_url'), 'inboundMethod' => Values::array_get($payload, 'inbound_method'), 'fallbackUrl' => Values::array_get($payload, 'fallback_url'), 'fallbackMethod' => Values::array_get($payload, 'fallback_method'), 'statusCallback' => Values::array_get($payload, 'status_callback'), 'stickySender' => Values::array_get($payload, 'sticky_sender'), 'mmsConverter' => Values::array_get($payload, 'mms_converter'), 'smartEncoding' => Values::array_get($payload, 'smart_encoding'), 'scanMessageContent' => Values::array_get($payload, 'scan_message_content'), 'fallbackToLongCode' => Values::array_get($payload, 'fallback_to_long_code'), 'areaCodeGeomatch' => Values::array_get($payload, 'area_code_geomatch'), 'synchronousValidation' => Values::array_get($payload, 'synchronous_validation'), 'validityPeriod' => Values::array_get($payload, 'validity_period'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ServiceContext
    {
        if (!$this->context) {
            $this->context = new ServiceContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(array $options = []): ServiceInstance
    {
        return $this->proxy()->update($options);
    }

    public function fetch(): ServiceInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getPhoneNumbers(): PhoneNumberList
    {
        return $this->proxy()->phoneNumbers;
    }

    protected function getShortCodes(): ShortCodeList
    {
        return $this->proxy()->shortCodes;
    }

    protected function getAlphaSenders(): AlphaSenderList
    {
        return $this->proxy()->alphaSenders;
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
        return '[Twilio.Messaging.V1.ServiceInstance ' . implode(' ', $context) . ']';
    }
}