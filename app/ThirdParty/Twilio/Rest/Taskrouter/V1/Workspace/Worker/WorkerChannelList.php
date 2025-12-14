<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class WorkerChannelList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid, string $workerSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'workerSid' => $workerSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workers/' . rawurlencode($workerSid) . '/Channels';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): WorkerChannelPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new WorkerChannelPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): WorkerChannelPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new WorkerChannelPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): WorkerChannelContext
    {
        return new WorkerChannelContext($this->version, $this->solution['workspaceSid'], $this->solution['workerSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkerChannelList]';
    }
}