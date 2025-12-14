<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class FlexFlowList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/FlexFlows';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): FlexFlowPage
    {
        $options = new Values($options);
        $params = Values::of(['FriendlyName' => $options['friendlyName'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new FlexFlowPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): FlexFlowPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new FlexFlowPage($this->version, $response, $this->solution);
    }

    public function create(string $friendlyName, string $chatServiceSid, string $channelType, array $options = []): FlexFlowInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'ChatServiceSid' => $chatServiceSid, 'ChannelType' => $channelType, 'ContactIdentity' => $options['contactIdentity'], 'Enabled' => Serialize::booleanToString($options['enabled']), 'IntegrationType' => $options['integrationType'], 'Integration.FlowSid' => $options['integrationFlowSid'], 'Integration.Url' => $options['integrationUrl'], 'Integration.WorkspaceSid' => $options['integrationWorkspaceSid'], 'Integration.WorkflowSid' => $options['integrationWorkflowSid'], 'Integration.Channel' => $options['integrationChannel'], 'Integration.Timeout' => $options['integrationTimeout'], 'Integration.Priority' => $options['integrationPriority'], 'Integration.CreationOnMessage' => Serialize::booleanToString($options['integrationCreationOnMessage']), 'LongLived' => Serialize::booleanToString($options['longLived']), 'JanitorEnabled' => Serialize::booleanToString($options['janitorEnabled']), 'Integration.RetryCount' => $options['integrationRetryCount'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new FlexFlowInstance($this->version, $payload);
    }

    public function getContext(string $sid): FlexFlowContext
    {
        return new FlexFlowContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.FlexApi.V1.FlexFlowList]';
    }
}