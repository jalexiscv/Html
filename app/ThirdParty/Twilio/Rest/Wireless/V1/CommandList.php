<?php

namespace Twilio\Rest\Wireless\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class CommandList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Commands';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): CommandPage
    {
        $options = new Values($options);
        $params = Values::of(['Sim' => $options['sim'], 'Status' => $options['status'], 'Direction' => $options['direction'], 'Transport' => $options['transport'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new CommandPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): CommandPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new CommandPage($this->version, $response, $this->solution);
    }

    public function create(string $command, array $options = []): CommandInstance
    {
        $options = new Values($options);
        $data = Values::of(['Command' => $command, 'Sim' => $options['sim'], 'CallbackMethod' => $options['callbackMethod'], 'CallbackUrl' => $options['callbackUrl'], 'CommandMode' => $options['commandMode'], 'IncludeSid' => $options['includeSid'], 'DeliveryReceiptRequested' => Serialize::booleanToString($options['deliveryReceiptRequested']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new CommandInstance($this->version, $payload);
    }

    public function getContext(string $sid): CommandContext
    {
        return new CommandContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Wireless.V1.CommandList]';
    }
}