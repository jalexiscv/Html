<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkersStatisticsContext;
use Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkersStatisticsList;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function iterator_to_array;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class WorkerList extends ListResource
{
    protected $_statistics = null;

    public function __construct(Version $version, string $workspaceSid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workers';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): WorkerPage
    {
        $options = new Values($options);
        $params = Values::of(['ActivityName' => $options['activityName'], 'ActivitySid' => $options['activitySid'], 'Available' => $options['available'], 'FriendlyName' => $options['friendlyName'], 'TargetWorkersExpression' => $options['targetWorkersExpression'], 'TaskQueueName' => $options['taskQueueName'], 'TaskQueueSid' => $options['taskQueueSid'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new WorkerPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): WorkerPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new WorkerPage($this->version, $response, $this->solution);
    }

    public function create(string $friendlyName, array $options = []): WorkerInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'ActivitySid' => $options['activitySid'], 'Attributes' => $options['attributes'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new WorkerInstance($this->version, $payload, $this->solution['workspaceSid']);
    }

    protected function getStatistics(): WorkersStatisticsList
    {
        if (!$this->_statistics) {
            $this->_statistics = new WorkersStatisticsList($this->version, $this->solution['workspaceSid']);
        }
        return $this->_statistics;
    }

    public function getContext(string $sid): WorkerContext
    {
        return new WorkerContext($this->version, $this->solution['workspaceSid'], $sid);
    }

    public function __get(string $name)
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkerList]';
    }
}