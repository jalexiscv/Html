<?php

namespace Twilio\Rest\IpMessaging\V2\Service\Channel;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class WebhookList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $channelSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'channelSid' => $channelSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Channels/' . rawurlencode($channelSid) . '/Webhooks';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): WebhookPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new WebhookPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): WebhookPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new WebhookPage($this->version, $response, $this->solution);
    }

    public function create(string $type, array $options = []): WebhookInstance
    {
        $options = new Values($options);
        $data = Values::of(['Type' => $type, 'Configuration.Url' => $options['configurationUrl'], 'Configuration.Method' => $options['configurationMethod'], 'Configuration.Filters' => Serialize::map($options['configurationFilters'], function ($e) {
            return $e;
        }), 'Configuration.Triggers' => Serialize::map($options['configurationTriggers'], function ($e) {
            return $e;
        }), 'Configuration.FlowSid' => $options['configurationFlowSid'], 'Configuration.RetryCount' => $options['configurationRetryCount'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new WebhookInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['channelSid']);
    }

    public function getContext(string $sid): WebhookContext
    {
        return new WebhookContext($this->version, $this->solution['serviceSid'], $this->solution['channelSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.IpMessaging.V2.WebhookList]';
    }
}