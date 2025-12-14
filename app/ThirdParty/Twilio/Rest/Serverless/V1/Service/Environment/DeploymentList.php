<?php

namespace Twilio\Rest\Serverless\V1\Service\Environment;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class DeploymentList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $environmentSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'environmentSid' => $environmentSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Environments/' . rawurlencode($environmentSid) . '/Deployments';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): DeploymentPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new DeploymentPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): DeploymentPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new DeploymentPage($this->version, $response, $this->solution);
    }

    public function create(array $options = []): DeploymentInstance
    {
        $options = new Values($options);
        $data = Values::of(['BuildSid' => $options['buildSid'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new DeploymentInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['environmentSid']);
    }

    public function getContext(string $sid): DeploymentContext
    {
        return new DeploymentContext($this->version, $this->solution['serviceSid'], $this->solution['environmentSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.DeploymentList]';
    }
}