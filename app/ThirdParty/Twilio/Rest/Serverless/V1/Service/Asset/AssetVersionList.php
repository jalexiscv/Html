<?php

namespace Twilio\Rest\Serverless\V1\Service\Asset;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class AssetVersionList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $assetSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'assetSid' => $assetSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Assets/' . rawurlencode($assetSid) . '/Versions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AssetVersionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AssetVersionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AssetVersionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AssetVersionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): AssetVersionContext
    {
        return new AssetVersionContext($this->version, $this->solution['serviceSid'], $this->solution['assetSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.AssetVersionList]';
    }
}