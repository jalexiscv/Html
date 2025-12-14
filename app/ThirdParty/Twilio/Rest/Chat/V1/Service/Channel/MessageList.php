<?php

namespace Twilio\Rest\Chat\V1\Service\Channel;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class MessageList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $channelSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'channelSid' => $channelSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Channels/' . rawurlencode($channelSid) . '/Messages';
    }

    public function create(string $body, array $options = []): MessageInstance
    {
        $options = new Values($options);
        $data = Values::of(['Body' => $body, 'From' => $options['from'], 'Attributes' => $options['attributes'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new MessageInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['channelSid']);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): MessagePage
    {
        $options = new Values($options);
        $params = Values::of(['Order' => $options['order'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new MessagePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): MessagePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new MessagePage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): MessageContext
    {
        return new MessageContext($this->version, $this->solution['serviceSid'], $this->solution['channelSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Chat.V1.MessageList]';
    }
}