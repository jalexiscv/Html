<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Api\V2010;
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
use Twilio\Rest\Api\V2010\AccountList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Api extends Domain
{
    protected $_v2010;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://api.twilio.com';
    }

    protected function getV2010(): V2010
    {
        if (!$this->_v2010) {
            $this->_v2010 = new V2010($this);
        }
        return $this->_v2010;
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

    protected function getAccount(): AccountContext
    {
        return $this->v2010->account;
    }

    protected function getAccounts(): AccountList
    {
        return $this->v2010->accounts;
    }

    protected function contextAccounts(string $sid): AccountContext
    {
        return $this->v2010->accounts($sid);
    }

    protected function getAddresses(): AddressList
    {
        return $this->v2010->account->addresses;
    }

    protected function contextAddresses(string $sid): AddressContext
    {
        return $this->v2010->account->addresses($sid);
    }

    protected function getApplications(): ApplicationList
    {
        return $this->v2010->account->applications;
    }

    protected function contextApplications(string $sid): ApplicationContext
    {
        return $this->v2010->account->applications($sid);
    }

    protected function getAuthorizedConnectApps(): AuthorizedConnectAppList
    {
        return $this->v2010->account->authorizedConnectApps;
    }

    protected function contextAuthorizedConnectApps(string $connectAppSid): AuthorizedConnectAppContext
    {
        return $this->v2010->account->authorizedConnectApps($connectAppSid);
    }

    protected function getAvailablePhoneNumbers(): AvailablePhoneNumberCountryList
    {
        return $this->v2010->account->availablePhoneNumbers;
    }

    protected function contextAvailablePhoneNumbers(string $countryCode): AvailablePhoneNumberCountryContext
    {
        return $this->v2010->account->availablePhoneNumbers($countryCode);
    }

    protected function getBalance(): BalanceList
    {
        return $this->v2010->account->balance;
    }

    protected function getCalls(): CallList
    {
        return $this->v2010->account->calls;
    }

    protected function contextCalls(string $sid): CallContext
    {
        return $this->v2010->account->calls($sid);
    }

    protected function getConferences(): ConferenceList
    {
        return $this->v2010->account->conferences;
    }

    protected function contextConferences(string $sid): ConferenceContext
    {
        return $this->v2010->account->conferences($sid);
    }

    protected function getConnectApps(): ConnectAppList
    {
        return $this->v2010->account->connectApps;
    }

    protected function contextConnectApps(string $sid): ConnectAppContext
    {
        return $this->v2010->account->connectApps($sid);
    }

    protected function getIncomingPhoneNumbers(): IncomingPhoneNumberList
    {
        return $this->v2010->account->incomingPhoneNumbers;
    }

    protected function contextIncomingPhoneNumbers(string $sid): IncomingPhoneNumberContext
    {
        return $this->v2010->account->incomingPhoneNumbers($sid);
    }

    protected function getKeys(): KeyList
    {
        return $this->v2010->account->keys;
    }

    protected function contextKeys(string $sid): KeyContext
    {
        return $this->v2010->account->keys($sid);
    }

    protected function getMessages(): MessageList
    {
        return $this->v2010->account->messages;
    }

    protected function contextMessages(string $sid): MessageContext
    {
        return $this->v2010->account->messages($sid);
    }

    protected function getNewKeys(): NewKeyList
    {
        return $this->v2010->account->newKeys;
    }

    protected function getNewSigningKeys(): NewSigningKeyList
    {
        return $this->v2010->account->newSigningKeys;
    }

    protected function getNotifications(): NotificationList
    {
        return $this->v2010->account->notifications;
    }

    protected function contextNotifications(string $sid): NotificationContext
    {
        return $this->v2010->account->notifications($sid);
    }

    protected function getOutgoingCallerIds(): OutgoingCallerIdList
    {
        return $this->v2010->account->outgoingCallerIds;
    }

    protected function contextOutgoingCallerIds(string $sid): OutgoingCallerIdContext
    {
        return $this->v2010->account->outgoingCallerIds($sid);
    }

    protected function getQueues(): QueueList
    {
        return $this->v2010->account->queues;
    }

    protected function contextQueues(string $sid): QueueContext
    {
        return $this->v2010->account->queues($sid);
    }

    protected function getRecordings(): RecordingList
    {
        return $this->v2010->account->recordings;
    }

    protected function contextRecordings(string $sid): RecordingContext
    {
        return $this->v2010->account->recordings($sid);
    }

    protected function getSigningKeys(): SigningKeyList
    {
        return $this->v2010->account->signingKeys;
    }

    protected function contextSigningKeys(string $sid): SigningKeyContext
    {
        return $this->v2010->account->signingKeys($sid);
    }

    protected function getSip(): SipList
    {
        return $this->v2010->account->sip;
    }

    protected function getShortCodes(): ShortCodeList
    {
        return $this->v2010->account->shortCodes;
    }

    protected function contextShortCodes(string $sid): ShortCodeContext
    {
        return $this->v2010->account->shortCodes($sid);
    }

    protected function getTokens(): TokenList
    {
        return $this->v2010->account->tokens;
    }

    protected function getTranscriptions(): TranscriptionList
    {
        return $this->v2010->account->transcriptions;
    }

    protected function contextTranscriptions(string $sid): TranscriptionContext
    {
        return $this->v2010->account->transcriptions($sid);
    }

    protected function getUsage(): UsageList
    {
        return $this->v2010->account->usage;
    }

    protected function getValidationRequests(): ValidationRequestList
    {
        return $this->v2010->account->validationRequests;
    }

    public function __toString(): string
    {
        return '[Twilio.Api]';
    }
}