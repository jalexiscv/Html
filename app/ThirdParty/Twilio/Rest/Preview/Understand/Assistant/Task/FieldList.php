<?php

namespace Twilio\Rest\Preview\Understand\Assistant\Task;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class FieldList extends ListResource
{
    public function __construct(Version $version, string $assistantSid, string $taskSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'taskSid' => $taskSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/Tasks/' . rawurlencode($taskSid) . '/Fields';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): FieldPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new FieldPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): FieldPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new FieldPage($this->version, $response, $this->solution);
    }

    public function create(string $fieldType, string $uniqueName): FieldInstance
    {
        $data = Values::of(['FieldType' => $fieldType, 'UniqueName' => $uniqueName,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new FieldInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['taskSid']);
    }

    public function getContext(string $sid): FieldContext
    {
        return new FieldContext($this->version, $this->solution['assistantSid'], $this->solution['taskSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Understand.FieldList]';
    }
}