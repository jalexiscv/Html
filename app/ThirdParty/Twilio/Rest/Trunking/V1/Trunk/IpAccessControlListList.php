<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class IpAccessControlListList extends ListResource
{
    public function __construct(Version $version, string $trunkSid)
    {
        parent::__construct($version);
        $this->solution = ['trunkSid' => $trunkSid,];
        $this->uri = '/Trunks/' . rawurlencode($trunkSid) . '/IpAccessControlLists';
    }

    public function create(string $ipAccessControlListSid): IpAccessControlListInstance
    {
        $data = Values::of(['IpAccessControlListSid' => $ipAccessControlListSid,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new IpAccessControlListInstance($this->version, $payload, $this->solution['trunkSid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): IpAccessControlListPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new IpAccessControlListPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): IpAccessControlListPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new IpAccessControlListPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): IpAccessControlListContext
    {
        return new IpAccessControlListContext($this->version, $this->solution['trunkSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Trunking.V1.IpAccessControlListList]';
    }
}