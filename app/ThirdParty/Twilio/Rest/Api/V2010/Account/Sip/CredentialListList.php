<?php

namespace Twilio\Rest\Api\V2010\Account\Sip;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class CredentialListList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/SIP/CredentialLists.json';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): CredentialListPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new CredentialListPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): CredentialListPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new CredentialListPage($this->version, $response, $this->solution);
    }

    public function create(string $friendlyName): CredentialListInstance
    {
        $data = Values::of(['FriendlyName' => $friendlyName,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new CredentialListInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function getContext(string $sid): CredentialListContext
    {
        return new CredentialListContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.CredentialListList]';
    }
}