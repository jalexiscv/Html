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

class NetworkAccessProfileList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/NetworkAccessProfiles';
    }

    public function create(array $options = []): NetworkAccessProfileInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'], 'Networks' => Serialize::map($options['networks'], function ($e) {
            return $e;
        }),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new NetworkAccessProfileInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): NetworkAccessProfilePage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new NetworkAccessProfilePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): NetworkAccessProfilePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new NetworkAccessProfilePage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): NetworkAccessProfileContext
    {
        return new NetworkAccessProfileContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Supersim.V1.NetworkAccessProfileList]';
    }
}