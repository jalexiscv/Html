<?php

namespace Twilio\Rest\Api\V2010;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
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
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class AccountContext extends InstanceContext
{
    protected $_addresses;
    protected $_applications;
    protected $_authorizedConnectApps;
    protected $_availablePhoneNumbers;
    protected $_balance;
    protected $_calls;
    protected $_conferences;
    protected $_connectApps;
    protected $_incomingPhoneNumbers;
    protected $_keys;
    protected $_messages;
    protected $_newKeys;
    protected $_newSigningKeys;
    protected $_notifications;
    protected $_outgoingCallerIds;
    protected $_queues;
    protected $_recordings;
    protected $_signingKeys;
    protected $_sip;
    protected $_shortCodes;
    protected $_tokens;
    protected $_transcriptions;
    protected $_usage;
    protected $_validationRequests;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): AccountInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new AccountInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): AccountInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'Status' => $options['status'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new AccountInstance($this->version, $payload, $this->solution['sid']);
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
        return '[Twilio.Api.V2010.AccountContext ' . implode(' ', $context) . ']';
    }

    protected function getAddresses(): AddressList
    {
        if (!$this->_addresses) {
            $this->_addresses = new AddressList($this->version, $this->solution['sid']);
        }
        return $this->_addresses;
    }

    protected function getApplications(): ApplicationList
    {
        if (!$this->_applications) {
            $this->_applications = new ApplicationList($this->version, $this->solution['sid']);
        }
        return $this->_applications;
    }

    protected function getAuthorizedConnectApps(): AuthorizedConnectAppList
    {
        if (!$this->_authorizedConnectApps) {
            $this->_authorizedConnectApps = new AuthorizedConnectAppList($this->version, $this->solution['sid']);
        }
        return $this->_authorizedConnectApps;
    }

    protected function getAvailablePhoneNumbers(): AvailablePhoneNumberCountryList
    {
        if (!$this->_availablePhoneNumbers) {
            $this->_availablePhoneNumbers = new AvailablePhoneNumberCountryList($this->version, $this->solution['sid']);
        }
        return $this->_availablePhoneNumbers;
    }

    protected function getBalance(): BalanceList
    {
        if (!$this->_balance) {
            $this->_balance = new BalanceList($this->version, $this->solution['sid']);
        }
        return $this->_balance;
    }

    protected function getCalls(): CallList
    {
        if (!$this->_calls) {
            $this->_calls = new CallList($this->version, $this->solution['sid']);
        }
        return $this->_calls;
    }

    protected function getConferences(): ConferenceList
    {
        if (!$this->_conferences) {
            $this->_conferences = new ConferenceList($this->version, $this->solution['sid']);
        }
        return $this->_conferences;
    }

    protected function getConnectApps(): ConnectAppList
    {
        if (!$this->_connectApps) {
            $this->_connectApps = new ConnectAppList($this->version, $this->solution['sid']);
        }
        return $this->_connectApps;
    }

    protected function getIncomingPhoneNumbers(): IncomingPhoneNumberList
    {
        if (!$this->_incomingPhoneNumbers) {
            $this->_incomingPhoneNumbers = new IncomingPhoneNumberList($this->version, $this->solution['sid']);
        }
        return $this->_incomingPhoneNumbers;
    }

    protected function getKeys(): KeyList
    {
        if (!$this->_keys) {
            $this->_keys = new KeyList($this->version, $this->solution['sid']);
        }
        return $this->_keys;
    }

    protected function getMessages(): MessageList
    {
        if (!$this->_messages) {
            $this->_messages = new MessageList($this->version, $this->solution['sid']);
        }
        return $this->_messages;
    }

    protected function getNewKeys(): NewKeyList
    {
        if (!$this->_newKeys) {
            $this->_newKeys = new NewKeyList($this->version, $this->solution['sid']);
        }
        return $this->_newKeys;
    }

    protected function getNewSigningKeys(): NewSigningKeyList
    {
        if (!$this->_newSigningKeys) {
            $this->_newSigningKeys = new NewSigningKeyList($this->version, $this->solution['sid']);
        }
        return $this->_newSigningKeys;
    }

    protected function getNotifications(): NotificationList
    {
        if (!$this->_notifications) {
            $this->_notifications = new NotificationList($this->version, $this->solution['sid']);
        }
        return $this->_notifications;
    }

    protected function getOutgoingCallerIds(): OutgoingCallerIdList
    {
        if (!$this->_outgoingCallerIds) {
            $this->_outgoingCallerIds = new OutgoingCallerIdList($this->version, $this->solution['sid']);
        }
        return $this->_outgoingCallerIds;
    }

    protected function getQueues(): QueueList
    {
        if (!$this->_queues) {
            $this->_queues = new QueueList($this->version, $this->solution['sid']);
        }
        return $this->_queues;
    }

    protected function getRecordings(): RecordingList
    {
        if (!$this->_recordings) {
            $this->_recordings = new RecordingList($this->version, $this->solution['sid']);
        }
        return $this->_recordings;
    }

    protected function getSigningKeys(): SigningKeyList
    {
        if (!$this->_signingKeys) {
            $this->_signingKeys = new SigningKeyList($this->version, $this->solution['sid']);
        }
        return $this->_signingKeys;
    }

    protected function getSip(): SipList
    {
        if (!$this->_sip) {
            $this->_sip = new SipList($this->version, $this->solution['sid']);
        }
        return $this->_sip;
    }

    protected function getShortCodes(): ShortCodeList
    {
        if (!$this->_shortCodes) {
            $this->_shortCodes = new ShortCodeList($this->version, $this->solution['sid']);
        }
        return $this->_shortCodes;
    }

    protected function getTokens(): TokenList
    {
        if (!$this->_tokens) {
            $this->_tokens = new TokenList($this->version, $this->solution['sid']);
        }
        return $this->_tokens;
    }

    protected function getTranscriptions(): TranscriptionList
    {
        if (!$this->_transcriptions) {
            $this->_transcriptions = new TranscriptionList($this->version, $this->solution['sid']);
        }
        return $this->_transcriptions;
    }

    protected function getUsage(): UsageList
    {
        if (!$this->_usage) {
            $this->_usage = new UsageList($this->version, $this->solution['sid']);
        }
        return $this->_usage;
    }

    protected function getValidationRequests(): ValidationRequestList
    {
        if (!$this->_validationRequests) {
            $this->_validationRequests = new ValidationRequestList($this->version, $this->solution['sid']);
        }
        return $this->_validationRequests;
    }
}