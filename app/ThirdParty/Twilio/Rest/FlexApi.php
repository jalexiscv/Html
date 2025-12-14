<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\FlexApi\V1;
use Twilio\Rest\FlexApi\V1\ChannelContext;
use Twilio\Rest\FlexApi\V1\ChannelList;
use Twilio\Rest\FlexApi\V1\ConfigurationContext;
use Twilio\Rest\FlexApi\V1\ConfigurationList;
use Twilio\Rest\FlexApi\V1\FlexFlowContext;
use Twilio\Rest\FlexApi\V1\FlexFlowList;
use Twilio\Rest\FlexApi\V1\WebChannelContext;
use Twilio\Rest\FlexApi\V1\WebChannelList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class FlexApi extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://flex-api.twilio.com';
    }

    protected function getV1(): V1
    {
        if (!$this->_v1) {
            $this->_v1 = new V1($this);
        }
        return $this->_v1;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown version ' . $name);
    }

    public function __call(string $name, array $arguments)
    {
        $method = 'context' . ucfirst($name);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }
        throw new TwilioException('Unknown context ' . $name);
    }

    protected function getChannel(): ChannelList
    {
        return $this->v1->channel;
    }

    protected function contextChannel(string $sid): ChannelContext
    {
        return $this->v1->channel($sid);
    }

    protected function getConfiguration(): ConfigurationList
    {
        return $this->v1->configuration;
    }

    protected function contextConfiguration(): ConfigurationContext
    {
        return $this->v1->configuration();
    }

    protected function getFlexFlow(): FlexFlowList
    {
        return $this->v1->flexFlow;
    }

    protected function contextFlexFlow(string $sid): FlexFlowContext
    {
        return $this->v1->flexFlow($sid);
    }

    protected function getWebChannel(): WebChannelList
    {
        return $this->v1->webChannel;
    }

    protected function contextWebChannel(string $sid): WebChannelContext
    {
        return $this->v1->webChannel($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.FlexApi]';
    }
}