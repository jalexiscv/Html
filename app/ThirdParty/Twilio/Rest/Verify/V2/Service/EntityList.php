<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class EntityList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Entities';
    }

    public function create(string $identity): EntityInstance
    {
        $data = Values::of(['Identity' => $identity,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new EntityInstance($this->version, $payload, $this->solution['serviceSid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): EntityPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new EntityPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): EntityPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new EntityPage($this->version, $response, $this->solution);
    }

    public function getContext(string $identity): EntityContext
    {
        return new EntityContext($this->version, $this->solution['serviceSid'], $identity);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.EntityList]';
    }
}