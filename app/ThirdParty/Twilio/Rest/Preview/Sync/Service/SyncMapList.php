<?php

namespace Twilio\Rest\Preview\Sync\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class SyncMapList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Maps';
    }

    public function create(array $options = []): SyncMapInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new SyncMapInstance($this->version, $payload, $this->solution['serviceSid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SyncMapPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SyncMapPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SyncMapPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SyncMapPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): SyncMapContext
    {
        return new SyncMapContext($this->version, $this->solution['serviceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Sync.SyncMapList]';
    }
}