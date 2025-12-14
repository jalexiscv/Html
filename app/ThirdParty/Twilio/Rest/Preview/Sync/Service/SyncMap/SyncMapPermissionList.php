<?php

namespace Twilio\Rest\Preview\Sync\Service\SyncMap;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class SyncMapPermissionList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $mapSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'mapSid' => $mapSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Maps/' . rawurlencode($mapSid) . '/Permissions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SyncMapPermissionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SyncMapPermissionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SyncMapPermissionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SyncMapPermissionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $identity): SyncMapPermissionContext
    {
        return new SyncMapPermissionContext($this->version, $this->solution['serviceSid'], $this->solution['mapSid'], $identity);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Sync.SyncMapPermissionList]';
    }
}