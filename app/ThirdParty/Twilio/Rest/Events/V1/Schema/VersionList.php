<?php

namespace Twilio\Rest\Events\V1\Schema;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class VersionList extends ListResource
{
    public function __construct(Version $version, string $id)
    {
        parent::__construct($version);
        $this->solution = ['id' => $id,];
        $this->uri = '/Schemas/' . rawurlencode($id) . '/Versions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): VersionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new VersionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): VersionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new VersionPage($this->version, $response, $this->solution);
    }

    public function getContext(int $schemaVersion): VersionContext
    {
        return new VersionContext($this->version, $this->solution['id'], $schemaVersion);
    }

    public function __toString(): string
    {
        return '[Twilio.Events.V1.VersionList]';
    }
}