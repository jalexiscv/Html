<?php

namespace Twilio\Rest\Serverless\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class ServiceList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Services';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ServicePage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ServicePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ServicePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ServicePage($this->version, $response, $this->solution);
    }

    public function create(string $uniqueName, string $friendlyName, array $options = []): ServiceInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $uniqueName, 'FriendlyName' => $friendlyName, 'IncludeCredentials' => Serialize::booleanToString($options['includeCredentials']), 'UiEditable' => Serialize::booleanToString($options['uiEditable']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ServiceInstance($this->version, $payload);
    }

    public function getContext(string $sid): ServiceContext
    {
        return new ServiceContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.ServiceList]';
    }
}