<?php

namespace Twilio\Rest\Autopilot\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class AssistantList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Assistants';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AssistantPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AssistantPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AssistantPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AssistantPage($this->version, $response, $this->solution);
    }

    public function create(array $options = []): AssistantInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'LogQueries' => Serialize::booleanToString($options['logQueries']), 'UniqueName' => $options['uniqueName'], 'CallbackUrl' => $options['callbackUrl'], 'CallbackEvents' => $options['callbackEvents'], 'StyleSheet' => Serialize::jsonObject($options['styleSheet']), 'Defaults' => Serialize::jsonObject($options['defaults']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new AssistantInstance($this->version, $payload);
    }

    public function getContext(string $sid): AssistantContext
    {
        return new AssistantContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.AssistantList]';
    }
}