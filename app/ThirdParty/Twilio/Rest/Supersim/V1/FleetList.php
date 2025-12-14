<?php

namespace Twilio\Rest\Supersim\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class FleetList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Fleets';
    }

    public function create(string $networkAccessProfile, array $options = []): FleetInstance
    {
        $options = new Values($options);
        $data = Values::of(['NetworkAccessProfile' => $networkAccessProfile, 'UniqueName' => $options['uniqueName'], 'DataEnabled' => Serialize::booleanToString($options['dataEnabled']), 'DataLimit' => $options['dataLimit'], 'CommandsEnabled' => Serialize::booleanToString($options['commandsEnabled']), 'CommandsUrl' => $options['commandsUrl'], 'CommandsMethod' => $options['commandsMethod'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new FleetInstance($this->version, $payload);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): FleetPage
    {
        $options = new Values($options);
        $params = Values::of(['NetworkAccessProfile' => $options['networkAccessProfile'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new FleetPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): FleetPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new FleetPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): FleetContext
    {
        return new FleetContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Supersim.V1.FleetList]';
    }
}