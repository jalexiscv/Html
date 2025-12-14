<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ActivityList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Activities';
    }

    public function read(array $options = [], int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    public function stream(array $options = [], int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($options, $limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ActivityPage
    {
        $options = new Values($options);
        $params = Values::of(['FriendlyName' => $options['friendlyName'], 'Available' => $options['available'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ActivityPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ActivityPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ActivityPage($this->version, $response, $this->solution);
    }

    public function create(string $friendlyName, array $options = []): ActivityInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'Available' => Serialize::booleanToString($options['available']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ActivityInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    public function getContext(string $sid): ActivityContext
    {
        return new ActivityContext($this->version, $this->solution['workspaceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.ActivityList]';
    }
}