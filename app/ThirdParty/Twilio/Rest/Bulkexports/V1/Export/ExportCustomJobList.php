<?php

namespace Twilio\Rest\Bulkexports\V1\Export;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ExportCustomJobList extends ListResource
{
    public function __construct(Version $version, string $resourceType)
    {
        parent::__construct($version);
        $this->solution = ['resourceType' => $resourceType,];
        $this->uri = '/Exports/' . rawurlencode($resourceType) . '/Jobs';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ExportCustomJobPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ExportCustomJobPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ExportCustomJobPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ExportCustomJobPage($this->version, $response, $this->solution);
    }

    public function create(string $startDay, string $endDay, string $friendlyName, array $options = []): ExportCustomJobInstance
    {
        $options = new Values($options);
        $data = Values::of(['StartDay' => $startDay, 'EndDay' => $endDay, 'FriendlyName' => $friendlyName, 'WebhookUrl' => $options['webhookUrl'], 'WebhookMethod' => $options['webhookMethod'], 'Email' => $options['email'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ExportCustomJobInstance($this->version, $payload, $this->solution['resourceType']);
    }

    public function __toString(): string
    {
        return '[Twilio.Bulkexports.V1.ExportCustomJobList]';
    }
}