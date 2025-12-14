<?php

namespace Twilio\Rest\Api\V2010\Account;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Call\EventList;
use Twilio\Rest\Api\V2010\Account\Call\FeedbackList;
use Twilio\Rest\Api\V2010\Account\Call\NotificationList;
use Twilio\Rest\Api\V2010\Account\Call\PaymentList;
use Twilio\Rest\Api\V2010\Account\Call\RecordingList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class CallInstance extends InstanceResource
{
    protected $_recordings;
    protected $_notifications;
    protected $_feedback;
    protected $_events;
    protected $_payments;

    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'parentCallSid' => Values::array_get($payload, 'parent_call_sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'to' => Values::array_get($payload, 'to'), 'toFormatted' => Values::array_get($payload, 'to_formatted'), 'from' => Values::array_get($payload, 'from'), 'fromFormatted' => Values::array_get($payload, 'from_formatted'), 'phoneNumberSid' => Values::array_get($payload, 'phone_number_sid'), 'status' => Values::array_get($payload, 'status'), 'startTime' => Deserialize::dateTime(Values::array_get($payload, 'start_time')), 'endTime' => Deserialize::dateTime(Values::array_get($payload, 'end_time')), 'duration' => Values::array_get($payload, 'duration'), 'price' => Values::array_get($payload, 'price'), 'priceUnit' => Values::array_get($payload, 'price_unit'), 'direction' => Values::array_get($payload, 'direction'), 'answeredBy' => Values::array_get($payload, 'answered_by'), 'annotation' => Values::array_get($payload, 'annotation'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'forwardedFrom' => Values::array_get($payload, 'forwarded_from'), 'groupSid' => Values::array_get($payload, 'group_sid'), 'callerName' => Values::array_get($payload, 'caller_name'), 'queueTime' => Values::array_get($payload, 'queue_time'), 'trunkSid' => Values::array_get($payload, 'trunk_sid'), 'uri' => Values::array_get($payload, 'uri'), 'subresourceUris' => Values::array_get($payload, 'subresource_uris'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): CallContext
    {
        if (!$this->context) {
            $this->context = new CallContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function fetch(): CallInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): CallInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getRecordings(): RecordingList
    {
        return $this->proxy()->recordings;
    }

    protected function getNotifications(): NotificationList
    {
        return $this->proxy()->notifications;
    }

    protected function getFeedback(): FeedbackList
    {
        return $this->proxy()->feedback;
    }

    protected function getEvents(): EventList
    {
        return $this->proxy()->events;
    }

    protected function getPayments(): PaymentList
    {
        return $this->proxy()->payments;
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
        return '[Twilio.Api.V2010.CallInstance ' . implode(' ', $context) . ']';
    }
}