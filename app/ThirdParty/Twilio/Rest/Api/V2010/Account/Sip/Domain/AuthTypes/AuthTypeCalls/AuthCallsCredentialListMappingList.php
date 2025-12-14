<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes\AuthTypeCalls;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class AuthCallsCredentialListMappingList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $domainSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'domainSid' => $domainSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/SIP/Domains/' . rawurlencode($domainSid) . '/Auth/Calls/CredentialListMappings.json';
    }

    public function create(string $credentialListSid): AuthCallsCredentialListMappingInstance
    {
        $data = Values::of(['CredentialListSid' => $credentialListSid,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new AuthCallsCredentialListMappingInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['domainSid']);
    }

    public function stream(int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function read(int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($limit, $pageSize), false);
    }

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AuthCallsCredentialListMappingPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AuthCallsCredentialListMappingPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AuthCallsCredentialListMappingPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AuthCallsCredentialListMappingPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): AuthCallsCredentialListMappingContext
    {
        return new AuthCallsCredentialListMappingContext($this->version, $this->solution['accountSid'], $this->solution['domainSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AuthCallsCredentialListMappingList]';
    }
}