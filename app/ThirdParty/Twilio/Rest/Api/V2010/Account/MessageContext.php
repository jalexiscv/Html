<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\Message\FeedbackList;
use Twilio\Rest\Api\V2010\Account\Message\MediaContext;
use Twilio\Rest\Api\V2010\Account\Message\MediaList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class MessageContext extends InstanceContext
{
    protected $_media;
    protected $_feedback;

    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Messages/' . rawurlencode($sid) . '.json';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): MessageInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new MessageInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function update(string $body): MessageInstance
    {
        $data = Values::of(['Body' => $body,]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new MessageInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    protected function getMedia(): MediaList
    {
        if (!$this->_media) {
            $this->_media = new MediaList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_media;
    }

    protected function getFeedback(): FeedbackList
    {
        if (!$this->_feedback) {
            $this->_feedback = new FeedbackList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_feedback;
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
        return '[Twilio.Api.V2010.MessageContext ' . implode(' ', $context) . ']';
    }
}