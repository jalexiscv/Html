<?php

namespace Twilio\Rest\FlexApi;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\FlexApi\V1\ChannelContext;
use Twilio\Rest\FlexApi\V1\ChannelList;
use Twilio\Rest\FlexApi\V1\ConfigurationList;
use Twilio\Rest\FlexApi\V1\FlexFlowContext;
use Twilio\Rest\FlexApi\V1\FlexFlowList;
use Twilio\Rest\FlexApi\V1\WebChannelContext;
use Twilio\Rest\FlexApi\V1\WebChannelList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_channel;
    protected $_configuration;
    protected $_flexFlow;
    protected $_webChannel;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getChannel(): ChannelList
    {
        if (!$this->_channel) {
            $this->_channel = new ChannelList($this);
        }
        return $this->_channel;
    }

    protected function getConfiguration(): ConfigurationList
    {
        if (!$this->_configuration) {
            $this->_configuration = new ConfigurationList($this);
        }
        return $this->_configuration;
    }

    protected function getFlexFlow(): FlexFlowList
    {
        if (!$this->_flexFlow) {
            $this->_flexFlow = new FlexFlowList($this);
        }
        return $this->_flexFlow;
    }

    protected function getWebChannel(): WebChannelList
    {
        if (!$this->_webChannel) {
            $this->_webChannel = new WebChannelList($this);
        }
        return $this->_webChannel;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown resource ' . $name);
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
        return '[Twilio.FlexApi.V1]';
    }
}