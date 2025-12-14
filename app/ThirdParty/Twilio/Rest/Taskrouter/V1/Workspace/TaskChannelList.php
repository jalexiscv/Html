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

class TaskChannelList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/TaskChannels';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): TaskChannelPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new TaskChannelPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): TaskChannelPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new TaskChannelPage($this->version, $response, $this->solution);
    }

    public function create(string $friendlyName, string $uniqueName, array $options = []): TaskChannelInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'UniqueName' => $uniqueName, 'ChannelOptimizedRouting' => Serialize::booleanToString($options['channelOptimizedRouting']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new TaskChannelInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    public function getContext(string $sid): TaskChannelContext
    {
        return new TaskChannelContext($this->version, $this->solution['workspaceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.TaskChannelList]';
    }
}