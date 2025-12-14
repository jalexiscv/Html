<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class WebChannelList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/WebChannels';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): WebChannelPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new WebChannelPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): WebChannelPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new WebChannelPage($this->version, $response, $this->solution);
    }

    public function create(string $flexFlowSid, string $identity, string $customerFriendlyName, string $chatFriendlyName, array $options = []): WebChannelInstance
    {
        $options = new Values($options);
        $data = Values::of(['FlexFlowSid' => $flexFlowSid, 'Identity' => $identity, 'CustomerFriendlyName' => $customerFriendlyName, 'ChatFriendlyName' => $chatFriendlyName, 'ChatUniqueName' => $options['chatUniqueName'], 'PreEngagementData' => $options['preEngagementData'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new WebChannelInstance($this->version, $payload);
    }

    public function getContext(string $sid): WebChannelContext
    {
        return new WebChannelContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.FlexApi.V1.WebChannelList]';
    }
}