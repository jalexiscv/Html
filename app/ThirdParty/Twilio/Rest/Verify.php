<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Verify\V2;
use Twilio\Rest\Verify\V2\FormContext;
use Twilio\Rest\Verify\V2\FormList;
use Twilio\Rest\Verify\V2\ServiceContext;
use Twilio\Rest\Verify\V2\ServiceList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Verify extends Domain
{
    protected $_v2;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://verify.twilio.com';
    }

    protected function getV2(): V2
    {
        if (!$this->_v2) {
            $this->_v2 = new V2($this);
        }
        return $this->_v2;
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

    protected function getForms(): FormList
    {
        return $this->v2->forms;
    }

    protected function contextForms(string $formType): FormContext
    {
        return $this->v2->forms($formType);
    }

    protected function getServices(): ServiceList
    {
        return $this->v2->services;
    }

    protected function contextServices(string $sid): ServiceContext
    {
        return $this->v2->services($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify]';
    }
}