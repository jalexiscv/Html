<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class AuthorizedConnectAppList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/AuthorizedConnectApps.json';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AuthorizedConnectAppPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AuthorizedConnectAppPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AuthorizedConnectAppPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AuthorizedConnectAppPage($this->version, $response, $this->solution);
    }

    public function getContext(string $connectAppSid): AuthorizedConnectAppContext
    {
        return new AuthorizedConnectAppContext($this->version, $this->solution['accountSid'], $connectAppSid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AuthorizedConnectAppList]';
    }
}