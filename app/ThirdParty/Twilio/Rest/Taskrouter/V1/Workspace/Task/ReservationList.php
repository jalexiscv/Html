<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Task;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ReservationList extends ListResource
{
    public function __construct(Version $version, string $workspaceSid, string $taskSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'taskSid' => $taskSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Tasks/' . rawurlencode($taskSid) . '/Reservations';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ReservationPage
    {
        $options = new Values($options);
        $params = Values::of(['ReservationStatus' => $options['reservationStatus'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ReservationPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ReservationPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ReservationPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ReservationContext
    {
        return new ReservationContext($this->version, $this->solution['workspaceSid'], $this->solution['taskSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.ReservationList]';
    }
}