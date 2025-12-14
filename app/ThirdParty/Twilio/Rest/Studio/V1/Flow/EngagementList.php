<?php

namespace Twilio\Rest\Studio\V1\Flow;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class EngagementList extends ListResource
{
    public function __construct(Version $version, string $flowSid)
    {
        parent::__construct($version);
        $this->solution = ['flowSid' => $flowSid,];
        $this->uri = '/Flows/' . rawurlencode($flowSid) . '/Engagements';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): EngagementPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new EngagementPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): EngagementPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new EngagementPage($this->version, $response, $this->solution);
    }

    public function create(string $to, string $from, array $options = []): EngagementInstance
    {
        $options = new Values($options);
        $data = Values::of(['To' => $to, 'From' => $from, 'Parameters' => Serialize::jsonObject($options['parameters']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new EngagementInstance($this->version, $payload, $this->solution['flowSid']);
    }

    public function getContext(string $sid): EngagementContext
    {
        return new EngagementContext($this->version, $this->solution['flowSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Studio.V1.EngagementList]';
    }
}