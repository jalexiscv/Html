<?php

namespace Twilio\Rest\Api\V2010\Account\Recording\AddOnResult;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class PayloadList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $referenceSid, string $addOnResultSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'referenceSid' => $referenceSid, 'addOnResultSid' => $addOnResultSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Recordings/' . rawurlencode($referenceSid) . '/AddOnResults/' . rawurlencode($addOnResultSid) . '/Payloads.json';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): PayloadPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new PayloadPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): PayloadPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new PayloadPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): PayloadContext
    {
        return new PayloadContext($this->version, $this->solution['accountSid'], $this->solution['referenceSid'], $this->solution['addOnResultSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.PayloadList]';
    }
}