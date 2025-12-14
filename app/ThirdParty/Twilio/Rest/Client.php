<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\Client as HttpClient;
use Twilio\Http\CurlClient;
use Twilio\Http\Response;
use Twilio\InstanceContext;
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
use Twilio\Security\RequestValidator;
use Twilio\VersionInfo;
use function array_filter;
use function array_key_exists;
use function array_slice;
use function call_user_func_array;
use function explode;
use function getenv;
use function implode;
use function method_exists;
use function parse_url;
use function ucfirst;

class Client
{
    const ENV_ACCOUNT_SID = 'TWILIO_ACCOUNT_SID';
    const ENV_AUTH_TOKEN = 'TWILIO_AUTH_TOKEN';
    const ENV_REGION = 'TWILIO_REGION';
    const ENV_EDGE = 'TWILIO_EDGE';
    const DEFAULT_REGION = 'us1';
    const ENV_LOG = 'TWILIO_LOG_LEVEL';
    protected $username;
    protected $password;
    protected $accountSid;
    protected $region;
    protected $edge;
    protected $httpClient;
    protected $environment;
    protected $logLevel;
    protected $_account;
    protected $_accounts;
    protected $_api;
    protected $_autopilot;
    protected $_chat;
    protected $_conversations;
    protected $_events;
    protected $_fax;
    protected $_flexApi;
    protected $_insights;
    protected $_ipMessaging;
    protected $_lookups;
    protected $_messaging;
    protected $_monitor;
    protected $_notify;
    protected $_numbers;
    protected $_preview;
    protected $_pricing;
    protected $_proxy;
    protected $_serverless;
    protected $_studio;
    protected $_sync;
    protected $_taskrouter;
    protected $_trunking;
    protected $_verify;
    protected $_video;
    protected $_voice;
    protected $_wireless;
    protected $_supersim;
    protected $_bulkexports;

    public function __construct(string $username = null, string $password = null, string $accountSid = null, string $region = null, HttpClient $httpClient = null, array $environment = null)
    {
        $this->environment = $environment ?: getenv();
        $this->username = $this->getArg($username, self::ENV_ACCOUNT_SID);
        $this->password = $this->getArg($password, self::ENV_AUTH_TOKEN);
        $this->region = $this->getArg($region, self::ENV_REGION);
        $this->edge = $this->getArg(null, self::ENV_EDGE);
        $this->logLevel = $this->getArg(null, self::ENV_LOG);
        if (!$this->username || !$this->password) {
            throw new ConfigurationException('Credentials are required to create a Client');
        }
        $this->accountSid = $accountSid ?: $this->username;
        if ($httpClient) {
            $this->httpClient = $httpClient;
        } else {
            $this->httpClient = new CurlClient();
        }
    }

    public function getArg(?string $arg, string $envVar): ?string
    {
        if ($arg) {
            return $arg;
        }
        if (array_key_exists($envVar, $this->environment)) {
            return $this->environment[$envVar];
        }
        return null;
    }

    public function request(string $method, string $uri, array $params = [], array $data = [], array $headers = [], string $username = null, string $password = null, int $timeout = null): Response
    {
        $username = $username ?: $this->username;
        $password = $password ?: $this->password;
        $logLevel = (getenv('DEBUG_HTTP_TRAFFIC') === 'true' ? 'debug' : $this->getLogLevel());
        $headers['User-Agent'] = 'twilio-php/' . VersionInfo::string() . ' (PHP ' . PHP_VERSION . ')';
        $headers['Accept-Charset'] = 'utf-8';
        if ($method === 'POST' && !array_key_exists('Content-Type', $headers)) {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }
        if (!array_key_exists('Accept', $headers)) {
            $headers['Accept'] = 'application/json';
        }
        $uri = $this->buildUri($uri);
        if ($logLevel === 'debug') {
            error_log('-- BEGIN Twilio API Request --');
            error_log('Request Method: ' . $method);
            $u = parse_url($uri);
            if (isset($u['path'])) {
                error_log('Request URL: ' . $u['path']);
            }
            if (isset($u['query']) && strlen($u['query']) > 0) {
                error_log('Query Params: ' . $u['query']);
            }
            error_log('Request Headers: ');
            foreach ($headers as $key => $value) {
                if (strpos(strtolower($key), 'authorization') === false) {
                    error_log("$key: $value");
                }
            }
            error_log('-- END Twilio API Request --');
        }
        $response = $this->getHttpClient()->request($method, $uri, $params, $data, $headers, $username, $password, $timeout);
        if ($logLevel === 'debug') {
            error_log('Status Code: ' . $response->getStatusCode());
            error_log('Response Headers:');
            $responseHeaders = $response->getHeaders();
            foreach ($responseHeaders as $key => $value) {
                error_log("$key: $value");
            }
        }
        return $response;
    }

    public function buildUri(string $uri): string
    {
        if ($this->region == null && $this->edge == null) {
            return $uri;
        }
        $parsedUrl = parse_url($uri);
        $pieces = explode('.', $parsedUrl['host']);
        $product = $pieces[0];
        $domain = implode('.', array_slice($pieces, -2));
        $newEdge = $this->edge;
        $newRegion = $this->region;
        if (count($pieces) == 4) {
            $newRegion = $newRegion ?: $pieces[1];
        } elseif (count($pieces) == 5) {
            $newEdge = $newEdge ?: $pieces[1];
            $newRegion = $newRegion ?: $pieces[2];
        }
        if ($newEdge != null && $newRegion == null) {
            $newRegion = self::DEFAULT_REGION;
        }
        $parsedUrl['host'] = implode('.', array_filter([$product, $newEdge, $newRegion, $domain]));
        return RequestValidator::unparse_url($parsedUrl);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAccountSid(): string
    {
        return $this->accountSid;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getEdge(): string
    {
        return $this->edge;
    }

    public function setEdge(string $edge = null): void
    {
        $this->edge = $this->getArg($edge, self::ENV_EDGE);
    }

    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    public function setHttpClient(HttpClient $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    public function getLogLevel(): ?string
    {
        return $this->logLevel;
    }

    public function setLogLevel(string $logLevel = null): void
    {
        $this->logLevel = $this->getArg($logLevel, self::ENV_LOG);
    }

    protected function getAccounts(): Accounts
    {
        if (!$this->_accounts) {
            $this->_accounts = new Accounts($this);
        }
        return $this->_accounts;
    }

    protected function getApi(): Api
    {
        if (!$this->_api) {
            $this->_api = new Api($this);
        }
        return $this->_api;
    }

    public function getAccount(): AccountContext
    {
        return $this->api->v2010->account;
    }

    protected function getAddresses(): AddressList
    {
        return $this->api->v2010->account->addresses;
    }

    protected function contextAddresses(string $sid): AddressContext
    {
        return $this->api->v2010->account->addresses($sid);
    }

    protected function getApplications(): ApplicationList
    {
        return $this->api->v2010->account->applications;
    }

    protected function contextApplications(string $sid): ApplicationContext
    {
        return $this->api->v2010->account->applications($sid);
    }

    protected function getAuthorizedConnectApps(): AuthorizedConnectAppList
    {
        return $this->api->v2010->account->authorizedConnectApps;
    }

    protected function contextAuthorizedConnectApps(string $connectAppSid): AuthorizedConnectAppContext
    {
        return $this->api->v2010->account->authorizedConnectApps($connectAppSid);
    }

    protected function getAvailablePhoneNumbers(): AvailablePhoneNumberCountryList
    {
        return $this->api->v2010->account->availablePhoneNumbers;
    }

    protected function contextAvailablePhoneNumbers(string $countryCode): AvailablePhoneNumberCountryContext
    {
        return $this->api->v2010->account->availablePhoneNumbers($countryCode);
    }

    protected function getBalance(): BalanceList
    {
        return $this->api->v2010->account->balance;
    }

    protected function getCalls(): CallList
    {
        return $this->api->v2010->account->calls;
    }

    protected function contextCalls(string $sid): CallContext
    {
        return $this->api->v2010->account->calls($sid);
    }

    protected function getConferences(): ConferenceList
    {
        return $this->api->v2010->account->conferences;
    }

    protected function contextConferences(string $sid): ConferenceContext
    {
        return $this->api->v2010->account->conferences($sid);
    }

    protected function getConnectApps(): ConnectAppList
    {
        return $this->api->v2010->account->connectApps;
    }

    protected function contextConnectApps(string $sid): ConnectAppContext
    {
        return $this->api->v2010->account->connectApps($sid);
    }

    protected function getIncomingPhoneNumbers(): IncomingPhoneNumberList
    {
        return $this->api->v2010->account->incomingPhoneNumbers;
    }

    protected function contextIncomingPhoneNumbers(string $sid): IncomingPhoneNumberContext
    {
        return $this->api->v2010->account->incomingPhoneNumbers($sid);
    }

    protected function getKeys(): KeyList
    {
        return $this->api->v2010->account->keys;
    }

    protected function contextKeys(string $sid): KeyContext
    {
        return $this->api->v2010->account->keys($sid);
    }

    protected function getMessages(): MessageList
    {
        return $this->api->v2010->account->messages;
    }

    protected function contextMessages(string $sid): MessageContext
    {
        return $this->api->v2010->account->messages($sid);
    }

    protected function getNewKeys(): NewKeyList
    {
        return $this->api->v2010->account->newKeys;
    }

    protected function getNewSigningKeys(): NewSigningKeyList
    {
        return $this->api->v2010->account->newSigningKeys;
    }

    protected function getNotifications(): NotificationList
    {
        return $this->api->v2010->account->notifications;
    }

    protected function contextNotifications(string $sid): NotificationContext
    {
        return $this->api->v2010->account->notifications($sid);
    }

    protected function getOutgoingCallerIds(): OutgoingCallerIdList
    {
        return $this->api->v2010->account->outgoingCallerIds;
    }

    protected function contextOutgoingCallerIds(string $sid): OutgoingCallerIdContext
    {
        return $this->api->v2010->account->outgoingCallerIds($sid);
    }

    protected function getQueues(): QueueList
    {
        return $this->api->v2010->account->queues;
    }

    protected function contextQueues(string $sid): QueueContext
    {
        return $this->api->v2010->account->queues($sid);
    }

    protected function getRecordings(): RecordingList
    {
        return $this->api->v2010->account->recordings;
    }

    protected function contextRecordings(string $sid): RecordingContext
    {
        return $this->api->v2010->account->recordings($sid);
    }

    protected function getSigningKeys(): SigningKeyList
    {
        return $this->api->v2010->account->signingKeys;
    }

    protected function contextSigningKeys(string $sid): SigningKeyContext
    {
        return $this->api->v2010->account->signingKeys($sid);
    }

    protected function getSip(): SipList
    {
        return $this->api->v2010->account->sip;
    }

    protected function getShortCodes(): ShortCodeList
    {
        return $this->api->v2010->account->shortCodes;
    }

    protected function contextShortCodes(string $sid): ShortCodeContext
    {
        return $this->api->v2010->account->shortCodes($sid);
    }

    protected function getTokens(): TokenList
    {
        return $this->api->v2010->account->tokens;
    }

    protected function getTranscriptions(): TranscriptionList
    {
        return $this->api->v2010->account->transcriptions;
    }

    protected function contextTranscriptions(string $sid): TranscriptionContext
    {
        return $this->api->v2010->account->transcriptions($sid);
    }

    protected function getUsage(): UsageList
    {
        return $this->api->v2010->account->usage;
    }

    protected function getValidationRequests(): ValidationRequestList
    {
        return $this->api->v2010->account->validationRequests;
    }

    protected function getAutopilot(): Autopilot
    {
        if (!$this->_autopilot) {
            $this->_autopilot = new Autopilot($this);
        }
        return $this->_autopilot;
    }

    protected function getChat(): Chat
    {
        if (!$this->_chat) {
            $this->_chat = new Chat($this);
        }
        return $this->_chat;
    }

    protected function getConversations(): Conversations
    {
        if (!$this->_conversations) {
            $this->_conversations = new Conversations($this);
        }
        return $this->_conversations;
    }

    protected function getEvents(): Events
    {
        if (!$this->_events) {
            $this->_events = new Events($this);
        }
        return $this->_events;
    }

    protected function getFax(): Fax
    {
        if (!$this->_fax) {
            $this->_fax = new Fax($this);
        }
        return $this->_fax;
    }

    protected function getFlexApi(): FlexApi
    {
        if (!$this->_flexApi) {
            $this->_flexApi = new FlexApi($this);
        }
        return $this->_flexApi;
    }

    protected function getInsights(): Insights
    {
        if (!$this->_insights) {
            $this->_insights = new Insights($this);
        }
        return $this->_insights;
    }

    protected function getIpMessaging(): IpMessaging
    {
        if (!$this->_ipMessaging) {
            $this->_ipMessaging = new IpMessaging($this);
        }
        return $this->_ipMessaging;
    }

    protected function getLookups(): Lookups
    {
        if (!$this->_lookups) {
            $this->_lookups = new Lookups($this);
        }
        return $this->_lookups;
    }

    protected function getMessaging(): Messaging
    {
        if (!$this->_messaging) {
            $this->_messaging = new Messaging($this);
        }
        return $this->_messaging;
    }

    protected function getMonitor(): Monitor
    {
        if (!$this->_monitor) {
            $this->_monitor = new Monitor($this);
        }
        return $this->_monitor;
    }

    protected function getNotify(): Notify
    {
        if (!$this->_notify) {
            $this->_notify = new Notify($this);
        }
        return $this->_notify;
    }

    protected function getNumbers(): Numbers
    {
        if (!$this->_numbers) {
            $this->_numbers = new Numbers($this);
        }
        return $this->_numbers;
    }

    protected function getPreview(): Preview
    {
        if (!$this->_preview) {
            $this->_preview = new Preview($this);
        }
        return $this->_preview;
    }

    protected function getPricing(): Pricing
    {
        if (!$this->_pricing) {
            $this->_pricing = new Pricing($this);
        }
        return $this->_pricing;
    }

    protected function getProxy(): Proxy
    {
        if (!$this->_proxy) {
            $this->_proxy = new Proxy($this);
        }
        return $this->_proxy;
    }

    protected function getServerless(): Serverless
    {
        if (!$this->_serverless) {
            $this->_serverless = new Serverless($this);
        }
        return $this->_serverless;
    }

    protected function getStudio(): Studio
    {
        if (!$this->_studio) {
            $this->_studio = new Studio($this);
        }
        return $this->_studio;
    }

    protected function getSync(): Sync
    {
        if (!$this->_sync) {
            $this->_sync = new Sync($this);
        }
        return $this->_sync;
    }

    protected function getTaskrouter(): Taskrouter
    {
        if (!$this->_taskrouter) {
            $this->_taskrouter = new Taskrouter($this);
        }
        return $this->_taskrouter;
    }

    protected function getTrunking(): Trunking
    {
        if (!$this->_trunking) {
            $this->_trunking = new Trunking($this);
        }
        return $this->_trunking;
    }

    protected function getVerify(): Verify
    {
        if (!$this->_verify) {
            $this->_verify = new Verify($this);
        }
        return $this->_verify;
    }

    protected function getVideo(): Video
    {
        if (!$this->_video) {
            $this->_video = new Video($this);
        }
        return $this->_video;
    }

    protected function getVoice(): Voice
    {
        if (!$this->_voice) {
            $this->_voice = new Voice($this);
        }
        return $this->_voice;
    }

    protected function getWireless(): Wireless
    {
        if (!$this->_wireless) {
            $this->_wireless = new Wireless($this);
        }
        return $this->_wireless;
    }

    protected function getSupersim(): Supersim
    {
        if (!$this->_supersim) {
            $this->_supersim = new Supersim($this);
        }
        return $this->_supersim;
    }

    protected function getBulkexports(): Bulkexports
    {
        if (!$this->_bulkexports) {
            $this->_bulkexports = new Bulkexports($this);
        }
        return $this->_bulkexports;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown domain ' . $name);
    }

    public function __call(string $name, array $arguments)
    {
        $method = 'context' . ucfirst($name);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }
        throw new TwilioException('Unknown context ' . $name);
    }

    public function __toString(): string
    {
        return '[Client ' . $this->getAccountSid() . ']';
    }

    public function validateSslCertificate(CurlClient $client): void
    {
        $response = $client->request('GET', 'https://api.twilio.com:8443');
        if ($response->getStatusCode() < 200 || $response->getStatusCode() > 300) {
            throw new TwilioException('Failed to validate SSL certificate');
        }
    }
}