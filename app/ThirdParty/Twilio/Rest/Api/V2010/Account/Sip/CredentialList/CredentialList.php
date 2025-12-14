<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\CredentialList;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class CredentialList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $credentialListSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'credentialListSid' => $credentialListSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/SIP/CredentialLists/' . rawurlencode($credentialListSid) . '/Credentials.json';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): CredentialPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new CredentialPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): CredentialPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new CredentialPage($this->version, $response, $this->solution);
    }

    public function create(string $username, string $password): CredentialInstance
    {
        $data = Values::of(['Username' => $username, 'Password' => $password,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new CredentialInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['credentialListSid']);
    }

    public function getContext(string $sid): CredentialContext
    {
        return new CredentialContext($this->version, $this->solution['accountSid'], $this->solution['credentialListSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.CredentialList]';
    }
}