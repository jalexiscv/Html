<?php

namespace Twilio\Rest\Api\V2010\Account\Queue;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class MemberList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $queueSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'queueSid' => $queueSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Queues/' . rawurlencode($queueSid) . '/Members.json';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): MemberPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new MemberPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): MemberPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new MemberPage($this->version, $response, $this->solution);
    }

    public function getContext(string $callSid): MemberContext
    {
        return new MemberContext($this->version, $this->solution['accountSid'], $this->solution['queueSid'], $callSid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.MemberList]';
    }
}