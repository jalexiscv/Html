<?php

namespace Twilio\Rest\Video\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class CompositionHookList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/CompositionHooks';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): CompositionHookPage
    {
        $options = new Values($options);
        $params = Values::of(['Enabled' => Serialize::booleanToString($options['enabled']), 'DateCreatedAfter' => Serialize::iso8601DateTime($options['dateCreatedAfter']), 'DateCreatedBefore' => Serialize::iso8601DateTime($options['dateCreatedBefore']), 'FriendlyName' => $options['friendlyName'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new CompositionHookPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): CompositionHookPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new CompositionHookPage($this->version, $response, $this->solution);
    }

    public function create(string $friendlyName, array $options = []): CompositionHookInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'Enabled' => Serialize::booleanToString($options['enabled']), 'VideoLayout' => Serialize::jsonObject($options['videoLayout']), 'AudioSources' => Serialize::map($options['audioSources'], function ($e) {
            return $e;
        }), 'AudioSourcesExcluded' => Serialize::map($options['audioSourcesExcluded'], function ($e) {
            return $e;
        }), 'Resolution' => $options['resolution'], 'Format' => $options['format'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'Trim' => Serialize::booleanToString($options['trim']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new CompositionHookInstance($this->version, $payload);
    }

    public function getContext(string $sid): CompositionHookContext
    {
        return new CompositionHookContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.CompositionHookList]';
    }
}