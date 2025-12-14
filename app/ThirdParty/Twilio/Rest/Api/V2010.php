<?php

namespace Twilio\Rest\Api;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\AddressContext;
use Twilio\Rest\Api\V2010\Account\AddressList;
use Twilio\Rest\Api\V2010\Account\ApplicationContext;
use Twilio\Rest\Api\V2010\Account\ApplicationList;
use Twilio\Rest\Api\V2010\Account\AuthorizedConnectAppContext;
use Twilio\Rest\Api\V2010\Account\AuthorizedConnectAppList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountryContext;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountryList;
use Twilio\Rest\Api\V2010\Account\BalanceList;
use Twilio\Rest\Api\V2010\Account\CallContext;
use Twilio\Rest\Api\V2010\Account\CallList;
use Twilio\Rest\Api\V2010\Account\ConferenceContext;
use Twilio\Rest\Api\V2010\Account\ConferenceList;
use Twilio\Rest\Api\V2010\Account\ConnectAppContext;
use Twilio\Rest\Api\V2010\Account\ConnectAppList;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumberContext;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumberList;
use Twilio\Rest\Api\V2010\Account\KeyContext;
use Twilio\Rest\Api\V2010\Account\KeyList;
use Twilio\Rest\Api\V2010\Account\MessageContext;
use Twilio\Rest\Api\V2010\Account\MessageList;
use Twilio\Rest\Api\V2010\Account\NewKeyList;
use Twilio\Rest\Api\V2010\Account\NewSigningKeyList;
use Twilio\Rest\Api\V2010\Account\NotificationContext;
use Twilio\Rest\Api\V2010\Account\NotificationList;
use Twilio\Rest\Api\V2010\Account\OutgoingCallerIdContext;
use Twilio\Rest\Api\V2010\Account\OutgoingCallerIdList;
use Twilio\Rest\Api\V2010\Account\QueueContext;
use Twilio\Rest\Api\V2010\Account\QueueList;
use Twilio\Rest\Api\V2010\Account\RecordingContext;
use Twilio\Rest\Api\V2010\Account\RecordingList;
use Twilio\Rest\Api\V2010\Account\ShortCodeContext;
use Twilio\Rest\Api\V2010\Account\ShortCodeList;
use Twilio\Rest\Api\V2010\Account\SigningKeyContext;
use Twilio\Rest\Api\V2010\Account\SigningKeyList;
use Twilio\Rest\Api\V2010\Account\SipList;
use Twilio\Rest\Api\V2010\Account\TokenList;
use Twilio\Rest\Api\V2010\Account\TranscriptionContext;
use Twilio\Rest\Api\V2010\Account\TranscriptionList;
use Twilio\Rest\Api\V2010\Account\UsageList;
use Twilio\Rest\Api\V2010\Account\ValidationRequestList;
use Twilio\Rest\Api\V2010\AccountContext;
use Twilio\Rest\Api\V2010\AccountInstance;
use Twilio\Rest\Api\V2010\AccountList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V2010 extends Version
{
    protected $_accounts;
    protected $_account = null;
    protected $_addresses = null;
    protected $_applications = null;
    protected $_authorizedConnectApps = null;
    protected $_availablePhoneNumbers = null;
    protected $_balance = null;
    protected $_calls = null;
    protected $_conferences = null;
    protected $_connectApps = null;
    protected $_incomingPhoneNumbers = null;
    protected $_keys = null;
    protected $_messages = null;
    protected $_newKeys = null;
    protected $_newSigningKeys = null;
    protected $_notifications = null;
    protected $_outgoingCallerIds = null;
    protected $_queues = null;
    protected $_recordings = null;
    protected $_signingKeys = null;
    protected $_sip = null;
    protected $_shortCodes = null;
    protected $_tokens = null;
    protected $_transcriptions = null;
    protected $_usage = null;
    protected $_validationRequests = null;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = '2010-04-01';
    }

    protected function getAccounts(): AccountList
    {
        if (!$this->_accounts) {
            $this->_accounts = new AccountList($this);
        }
        return $this->_accounts;
    }

    protected function getAccount(): AccountContext
    {
        if (!$this->_account) {
            $this->_account = new AccountContext($this, $this->domain->getClient()->getAccountSid());
        }
        return $this->_account;
    }

    public function setAccount($account): void
    {
        $this->_account = $account;
    }

    protected function getAddresses(): AddressList
    {
        return $this->account->addresses;
    }

    protected function getApplications(): ApplicationList
    {
        return $this->account->applications;
    }

    protected function getAuthorizedConnectApps(): AuthorizedConnectAppList
    {
        return $this->account->authorizedConnectApps;
    }

    protected function getAvailablePhoneNumbers(): AvailablePhoneNumberCountryList
    {
        return $this->account->availablePhoneNumbers;
    }

    protected function getBalance(): BalanceList
    {
        return $this->account->balance;
    }

    protected function getCalls(): CallList
    {
        return $this->account->calls;
    }

    protected function getConferences(): ConferenceList
    {
        return $this->account->conferences;
    }

    protected function getConnectApps(): ConnectAppList
    {
        return $this->account->connectApps;
    }

    protected function getIncomingPhoneNumbers(): IncomingPhoneNumberList
    {
        return $this->account->incomingPhoneNumbers;
    }

    protected function getKeys(): KeyList
    {
        return $this->account->keys;
    }

    protected function getMessages(): MessageList
    {
        return $this->account->messages;
    }

    protected function getNewKeys(): NewKeyList
    {
        return $this->account->newKeys;
    }

    protected function getNewSigningKeys(): NewSigningKeyList
    {
        return $this->account->newSigningKeys;
    }

    protected function getNotifications(): NotificationList
    {
        return $this->account->notifications;
    }

    protected function getOutgoingCallerIds(): OutgoingCallerIdList
    {
        return $this->account->outgoingCallerIds;
    }

    protected function getQueues(): QueueList
    {
        return $this->account->queues;
    }

    protected function getRecordings(): RecordingList
    {
        return $this->account->recordings;
    }

    protected function getSigningKeys(): SigningKeyList
    {
        return $this->account->signingKeys;
    }

    protected function getSip(): SipList
    {
        return $this->account->sip;
    }

    protected function getShortCodes(): ShortCodeList
    {
        return $this->account->shortCodes;
    }

    protected function getTokens(): TokenList
    {
        return $this->account->tokens;
    }

    protected function getTranscriptions(): TranscriptionList
    {
        return $this->account->transcriptions;
    }

    protected function getUsage(): UsageList
    {
        return $this->account->usage;
    }

    protected function getValidationRequests(): ValidationRequestList
    {
        return $this->account->validationRequests;
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
        return '[Twilio.Api.V2010]';
    }
}