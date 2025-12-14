<?php

namespace Twilio\Rest\IpMessaging\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ChannelList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Channels';
    }

    public function create(array $options = []): ChannelInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'UniqueName' => $options['uniqueName'], 'Attributes' => $options['attributes'], 'Type' => $options['type'], 'DateCreated' => Serialize::iso8601DateTime($options['dateCreated']), 'DateUpdated' => Serialize::iso8601DateTime($options['dateUpdated']), 'CreatedBy' => $options['createdBy'],]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data, $headers);
        return new ChannelInstance($this->version, $payload, $this->solution['serviceSid']);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ChannelPage
    {
        $options = new Values($options);
        $params = Values::of(['Type' => Serialize::map($options['type'], function ($e) {
            return $e;
        }), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ChannelPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ChannelPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ChannelPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ChannelContext
    {
        return new ChannelContext($this->version, $this->solution['serviceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.IpMessaging.V2.ChannelList]';
    }
}