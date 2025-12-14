<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class EventList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Events';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): EventPage
    {
        $options = new Values($options);
        $params = Values::of(['EndDate' => Serialize::iso8601DateTime($options['endDate']), 'EventType' => $options['eventType'], 'Minutes' => $options['minutes'], 'ReservationSid' => $options['reservationSid'], 'StartDate' => Serialize::iso8601DateTime($options['startDate']), 'TaskQueueSid' => $options['taskQueueSid'], 'TaskSid' => $options['taskSid'], 'WorkerSid' => $options['workerSid'], 'WorkflowSid' => $options['workflowSid'], 'TaskChannel' => $options['taskChannel'], 'Sid' => $options['sid'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new EventPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): EventPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new EventPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): EventContext
    {
        return new EventContext($this->version, $this->solution['workspaceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.EventList]';
    }
}