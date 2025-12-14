<?php

namespace Twilio\Rest\Serverless\V1\Service\Environment;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class LogList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $environmentSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'environmentSid' => $environmentSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Environments/' . rawurlencode($environmentSid) . '/Logs';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): LogPage
    {
        $options = new Values($options);
        $params = Values::of(['FunctionSid' => $options['functionSid'], 'StartDate' => Serialize::iso8601DateTime($options['startDate']), 'EndDate' => Serialize::iso8601DateTime($options['endDate']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new LogPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): LogPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new LogPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): LogContext
    {
        return new LogContext($this->version, $this->solution['serviceSid'], $this->solution['environmentSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.LogList]';
    }
}