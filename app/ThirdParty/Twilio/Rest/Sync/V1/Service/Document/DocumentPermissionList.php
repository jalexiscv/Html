<?php

namespace Twilio\Rest\Sync\V1\Service\Document;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class DocumentPermissionList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $documentSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'documentSid' => $documentSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Documents/' . rawurlencode($documentSid) . '/Permissions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): DocumentPermissionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new DocumentPermissionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): DocumentPermissionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new DocumentPermissionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $identity): DocumentPermissionContext
    {
        return new DocumentPermissionContext($this->version, $this->solution['serviceSid'], $this->solution['documentSid'], $identity);
    }

    public function __toString(): string
    {
        return '[Twilio.Sync.V1.DocumentPermissionList]';
    }
}