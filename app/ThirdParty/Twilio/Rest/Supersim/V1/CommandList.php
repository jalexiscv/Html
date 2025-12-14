<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
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

    public function create(string $sim, string $command, array $options = []): CommandInstance
    {
        $options = new Values($options);
        $data = Values::of(['Sim' => $sim, 'Command' => $command, 'CallbackMethod' => $options['callbackMethod'], 'CallbackUrl' => $options['callbackUrl'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new CommandInstance($this->version, $payload);
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
        $params = Values::of(['Sim' => $options['sim'], 'Status' => $options['status'], 'Direction' => $options['direction'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new CommandPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): CommandPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new CommandPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): CommandContext
    {
        return new CommandContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Supersim.V1.CommandList]';
    }
}