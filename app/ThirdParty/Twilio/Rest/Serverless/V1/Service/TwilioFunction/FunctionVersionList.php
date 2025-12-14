<?php

namespace Twilio\Rest\Serverless\V1\Service\TwilioFunction;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class FunctionVersionList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $functionSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'functionSid' => $functionSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Functions/' . rawurlencode($functionSid) . '/Versions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): FunctionVersionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new FunctionVersionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): FunctionVersionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new FunctionVersionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): FunctionVersionContext
    {
        return new FunctionVersionContext($this->version, $this->solution['serviceSid'], $this->solution['functionSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.FunctionVersionList]';
    }
}