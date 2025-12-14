<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Trunking\V1;
use Twilio\Rest\Trunking\V1\TrunkContext;
use Twilio\Rest\Trunking\V1\TrunkList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Trunking extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://trunking.twilio.com';
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

    protected function getTrunks(): TrunkList
    {
        return $this->v1->trunks;
    }

    protected function contextTrunks(string $sid): TrunkContext
    {
        return $this->v1->trunks($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Trunking]';
    }
}