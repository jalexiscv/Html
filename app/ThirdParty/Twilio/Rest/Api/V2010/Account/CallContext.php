<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Call\EventList;
use Twilio\Rest\Api\V2010\Account\Call\FeedbackContext;
use Twilio\Rest\Api\V2010\Account\Call\FeedbackList;
use Twilio\Rest\Api\V2010\Account\Call\NotificationList;
use Twilio\Rest\Api\V2010\Account\Call\PaymentContext;
use Twilio\Rest\Api\V2010\Account\Call\PaymentList;
use Twilio\Rest\Api\V2010\Account\Call\RecordingList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class CallContext extends InstanceContext
{
    protected $_recordings;
    protected $_notifications;
    protected $_feedback;
    protected $_events;
    protected $_payments;

    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Calls/' . rawurlencode($sid) . '.json';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): CallInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new CallInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function update(array $options = []): CallInstance
    {
        $options = new Values($options);
        $data = Values::of(['Url' => $options['url'], 'Method' => $options['method'], 'Status' => $options['status'], 'FallbackUrl' => $options['fallbackUrl'], 'FallbackMethod' => $options['fallbackMethod'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'Twiml' => $options['twiml'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new CallInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    protected function getRecordings(): RecordingList
    {
        if (!$this->_recordings) {
            $this->_recordings = new RecordingList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_recordings;
    }

    protected function getNotifications(): NotificationList
    {
        if (!$this->_notifications) {
            $this->_notifications = new NotificationList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_notifications;
    }

    protected function getFeedback(): FeedbackList
    {
        if (!$this->_feedback) {
            $this->_feedback = new FeedbackList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_feedback;
    }

    protected function getEvents(): EventList
    {
        if (!$this->_events) {
            $this->_events = new EventList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_events;
    }

    protected function getPayments(): PaymentList
    {
        if (!$this->_payments) {
            $this->_payments = new PaymentList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_payments;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.CallContext ' . implode(' ', $context) . ']';
    }
}