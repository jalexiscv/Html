<?php

namespace Twilio\Rest\Preview\Sync\Service\SyncList;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class SyncListItemList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $listSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'listSid' => $listSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Lists/' . rawurlencode($listSid) . '/Items';
    }

    public function create(array $data): SyncListItemInstance
    {
        $data = Values::of(['Data' => Serialize::jsonObject($data),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new SyncListItemInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['listSid']);
    }

    public function stream(array $options = [], int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($options, $limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function read(array $options = [], int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SyncListItemPage
    {
        $options = new Values($options);
        $params = Values::of(['Order' => $options['order'], 'From' => $options['from'], 'Bounds' => $options['bounds'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SyncListItemPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SyncListItemPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SyncListItemPage($this->version, $response, $this->solution);
    }

    public function getContext(int $index): SyncListItemContext
    {
        return new SyncListItemContext($this->version, $this->solution['serviceSid'], $this->solution['listSid'], $index);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Sync.SyncListItemList]';
    }
}