<?php

namespace Twilio\Rest\Preview\Sync\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Preview\Sync\Service\Document\DocumentPermissionContext;
use Twilio\Rest\Preview\Sync\Service\Document\DocumentPermissionList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class DocumentContext extends InstanceContext
{
    protected $_documentPermissions;

    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Documents/' . rawurlencode($sid) . '';
    }

    public function fetch(): DocumentInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new DocumentInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function delete(array $options = []): bool
    {
        $options = new Values($options);
        $headers = Values::of(['If-Match' => $options['ifMatch'],]);
        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }

    public function update(array $data, array $options = []): DocumentInstance
    {
        $options = new Values($options);
        $data = Values::of(['Data' => Serialize::jsonObject($data),]);
        $headers = Values::of(['If-Match' => $options['ifMatch'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);
        return new DocumentInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    protected function getDocumentPermissions(): DocumentPermissionList
    {
        if (!$this->_documentPermissions) {
            $this->_documentPermissions = new DocumentPermissionList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_documentPermissions;
    }

    public function __get(string $name): ListResource
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
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Sync.DocumentContext ' . implode(' ', $context) . ']';
    }
}