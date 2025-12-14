<?php

namespace Twilio\Rest\Events\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class SinkList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Sinks';
    }

    public function create(string $description, array $sinkConfiguration, string $sinkType): SinkInstance
    {
        $data = Values::of(['Description' => $description, 'SinkConfiguration' => Serialize::jsonObject($sinkConfiguration), 'SinkType' => $sinkType,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new SinkInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SinkPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SinkPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SinkPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SinkPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): SinkContext
    {
        return new SinkContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Events.V1.SinkList]';
    }
}