<?php

namespace Twilio\Rest\Api\V2010\Account\Usage;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class TriggerList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Usage/Triggers.json';
    }

    public function create(string $callbackUrl, string $triggerValue, string $usageCategory, array $options = []): TriggerInstance
    {
        $options = new Values($options);
        $data = Values::of(['CallbackUrl' => $callbackUrl, 'TriggerValue' => $triggerValue, 'UsageCategory' => $usageCategory, 'CallbackMethod' => $options['callbackMethod'], 'FriendlyName' => $options['friendlyName'], 'Recurring' => $options['recurring'], 'TriggerBy' => $options['triggerBy'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new TriggerInstance($this->version, $payload, $this->solution['accountSid']);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): TriggerPage
    {
        $options = new Values($options);
        $params = Values::of(['Recurring' => $options['recurring'], 'TriggerBy' => $options['triggerBy'], 'UsageCategory' => $options['usageCategory'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new TriggerPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): TriggerPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new TriggerPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): TriggerContext
    {
        return new TriggerContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.TriggerList]';
    }
}