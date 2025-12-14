<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class ChannelList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Channels';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ChannelPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ChannelPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ChannelPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ChannelPage($this->version, $response, $this->solution);
    }

    public function create(string $flexFlowSid, string $identity, string $chatUserFriendlyName, string $chatFriendlyName, array $options = []): ChannelInstance
    {
        $options = new Values($options);
        $data = Values::of(['FlexFlowSid' => $flexFlowSid, 'Identity' => $identity, 'ChatUserFriendlyName' => $chatUserFriendlyName, 'ChatFriendlyName' => $chatFriendlyName, 'Target' => $options['target'], 'ChatUniqueName' => $options['chatUniqueName'], 'PreEngagementData' => $options['preEngagementData'], 'TaskSid' => $options['taskSid'], 'TaskAttributes' => $options['taskAttributes'], 'LongLived' => Serialize::booleanToString($options['longLived']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ChannelInstance($this->version, $payload);
    }

    public function getContext(string $sid): ChannelContext
    {
        return new ChannelContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.FlexApi.V1.ChannelList]';
    }
}