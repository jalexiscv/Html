<?php

namespace Twilio\Rest\Sync\V1\Service\SyncList;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class SyncListPermissionList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $listSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'listSid' => $listSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Lists/' . rawurlencode($listSid) . '/Permissions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SyncListPermissionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SyncListPermissionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SyncListPermissionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SyncListPermissionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $identity): SyncListPermissionContext
    {
        return new SyncListPermissionContext($this->version, $this->solution['serviceSid'], $this->solution['listSid'], $identity);
    }

    public function __toString(): string
    {
        return '[Twilio.Sync.V1.SyncListPermissionList]';
    }
}