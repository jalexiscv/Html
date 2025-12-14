<?php

namespace Twilio\Rest\Accounts\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Accounts\V1\Credential\AwsContext;
use Twilio\Rest\Accounts\V1\Credential\AwsList;
use Twilio\Rest\Accounts\V1\Credential\PublicKeyContext;
use Twilio\Rest\Accounts\V1\Credential\PublicKeyList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class CredentialList extends ListResource
{
    protected $_publicKey = null;
    protected $_aws = null;

    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    protected function getPublicKey(): PublicKeyList
    {
        if (!$this->_publicKey) {
            $this->_publicKey = new PublicKeyList($this->version);
        }
        return $this->_publicKey;
    }

    protected function getAws(): AwsList
    {
        if (!$this->_aws) {
            $this->_aws = new AwsList($this->version);
        }
        return $this->_aws;
    }

    public function __get(string $name)
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
        return '[Twilio.Accounts.V1.CredentialList]';
    }
}