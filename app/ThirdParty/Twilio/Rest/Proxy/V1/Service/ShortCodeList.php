<?php

namespace Twilio\Rest\Proxy\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ShortCodeList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/ShortCodes';
    }

    public function create(string $sid): ShortCodeInstance
    {
        $data = Values::of(['Sid' => $sid,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ShortCodeInstance($this->version, $payload, $this->solution['serviceSid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ShortCodePage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ShortCodePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ShortCodePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ShortCodePage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ShortCodeContext
    {
        return new ShortCodeContext($this->version, $this->solution['serviceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Proxy.V1.ShortCodeList]';
    }
}