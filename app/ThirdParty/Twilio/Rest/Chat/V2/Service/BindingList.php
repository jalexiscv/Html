<?php

namespace Twilio\Rest\Chat\V2\Service;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class BindingList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Bindings';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): BindingPage
    {
        $options = new Values($options);
        $params = Values::of(['BindingType' => Serialize::map($options['bindingType'], function ($e) {
            return $e;
        }), 'Identity' => Serialize::map($options['identity'], function ($e) {
            return $e;
        }), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new BindingPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): BindingPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new BindingPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): BindingContext
    {
        return new BindingContext($this->version, $this->solution['serviceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Chat.V2.BindingList]';
    }
}