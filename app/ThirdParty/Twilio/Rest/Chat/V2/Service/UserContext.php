<?php

namespace Twilio\Rest\Chat\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Chat\V2\Service\User\UserBindingContext;
use Twilio\Rest\Chat\V2\Service\User\UserBindingList;
use Twilio\Rest\Chat\V2\Service\User\UserChannelContext;
use Twilio\Rest\Chat\V2\Service\User\UserChannelList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class UserContext extends InstanceContext
{
    protected $_userChannels;
    protected $_userBindings;

    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Users/' . rawurlencode($sid) . '';
    }

    public function fetch(): UserInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new UserInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): UserInstance
    {
        $options = new Values($options);
        $data = Values::of(['RoleSid' => $options['roleSid'], 'Attributes' => $options['attributes'], 'FriendlyName' => $options['friendlyName'],]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);
        return new UserInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    protected function getUserChannels(): UserChannelList
    {
        if (!$this->_userChannels) {
            $this->_userChannels = new UserChannelList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_userChannels;
    }

    protected function getUserBindings(): UserBindingList
    {
        if (!$this->_userBindings) {
            $this->_userBindings = new UserBindingList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_userBindings;
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
        return '[Twilio.Chat.V2.UserContext ' . implode(' ', $context) . ']';
    }
}