<?php

namespace Twilio\Rest\Accounts;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Accounts\V1\AuthTokenPromotionList;
use Twilio\Rest\Accounts\V1\CredentialList;
use Twilio\Rest\Accounts\V1\SecondaryAuthTokenList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_authTokenPromotion;
    protected $_credentials;
    protected $_secondaryAuthToken;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getAuthTokenPromotion(): AuthTokenPromotionList
    {
        if (!$this->_authTokenPromotion) {
            $this->_authTokenPromotion = new AuthTokenPromotionList($this);
        }
        return $this->_authTokenPromotion;
    }

    protected function getCredentials(): CredentialList
    {
        if (!$this->_credentials) {
            $this->_credentials = new CredentialList($this);
        }
        return $this->_credentials;
    }

    protected function getSecondaryAuthToken(): SecondaryAuthTokenList
    {
        if (!$this->_secondaryAuthToken) {
            $this->_secondaryAuthToken = new SecondaryAuthTokenList($this);
        }
        return $this->_secondaryAuthToken;
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
        return '[Twilio.Accounts.V1]';
    }
}