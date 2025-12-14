<?php

namespace Twilio\Rest\Autopilot\V1\Assistant\FieldType;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class FieldValueList extends ListResource
{
    public function __construct(Version $version, string $assistantSid, string $fieldTypeSid)
    {
        parent::__construct($version);
        $this->solution = ['assistantSid' => $assistantSid, 'fieldTypeSid' => $fieldTypeSid,];
        $this->uri = '/Assistants/' . rawurlencode($assistantSid) . '/FieldTypes/' . rawurlencode($fieldTypeSid) . '/FieldValues';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): FieldValuePage
    {
        $options = new Values($options);
        $params = Values::of(['Language' => $options['language'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new FieldValuePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): FieldValuePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new FieldValuePage($this->version, $response, $this->solution);
    }

    public function create(string $language, string $value, array $options = []): FieldValueInstance
    {
        $options = new Values($options);
        $data = Values::of(['Language' => $language, 'Value' => $value, 'SynonymOf' => $options['synonymOf'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new FieldValueInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['fieldTypeSid']);
    }

    public function getContext(string $sid): FieldValueContext
    {
        return new FieldValueContext($this->version, $this->solution['assistantSid'], $this->solution['fieldTypeSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Autopilot.V1.FieldValueList]';
    }
}