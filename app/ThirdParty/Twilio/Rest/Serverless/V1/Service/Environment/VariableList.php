<?php

namespace Twilio\Rest\Serverless\V1\Service\Environment;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class VariableList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $environmentSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'environmentSid' => $environmentSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Environments/' . rawurlencode($environmentSid) . '/Variables';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): VariablePage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new VariablePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): VariablePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new VariablePage($this->version, $response, $this->solution);
    }

    public function create(string $key, string $value): VariableInstance
    {
        $data = Values::of(['Key' => $key, 'Value' => $value,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new VariableInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['environmentSid']);
    }

    public function getContext(string $sid): VariableContext
    {
        return new VariableContext($this->version, $this->solution['serviceSid'], $this->solution['environmentSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Serverless.V1.VariableList]';
    }
}