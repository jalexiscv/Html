<?php

namespace Twilio\Rest\Fax;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Fax\V1\FaxContext;
use Twilio\Rest\Fax\V1\FaxList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_faxes;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getFaxes(): FaxList
    {
        if (!$this->_faxes) {
            $this->_faxes = new FaxList($this);
        }
        return $this->_faxes;
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
        return '[Twilio.Fax.V1]';
    }
}