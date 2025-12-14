<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class EndUserList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/RegulatoryCompliance/EndUsers';
    }

    public function create(string $friendlyName, string $type, array $options = []): EndUserInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'Type' => $type, 'Attributes' => Serialize::jsonObject($options['attributes']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new EndUserInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): EndUserPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new EndUserPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): EndUserPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new EndUserPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): EndUserContext
    {
        return new EndUserContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Numbers.V2.EndUserList]';
    }
}