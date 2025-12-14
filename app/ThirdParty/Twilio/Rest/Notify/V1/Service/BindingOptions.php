<?php

namespace Twilio\Rest\Notify\V1\Service;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class BindingOptions
{
    public static function create(array $tag = Values::ARRAY_NONE, string $notificationProtocolVersion = Values::NONE, string $credentialSid = Values::NONE, string $endpoint = Values::NONE): CreateBindingOptions
    {
        return new CreateBindingOptions($tag, $notificationProtocolVersion, $credentialSid, $endpoint);
    }

    public static function read(DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE, array $identity = Values::ARRAY_NONE, array $tag = Values::ARRAY_NONE): ReadBindingOptions
    {
        return new ReadBindingOptions($startDate, $endDate, $identity, $tag);
    }
}

class CreateBindingOptions extends Options
{
    public function __construct(array $tag = Values::ARRAY_NONE, string $notificationProtocolVersion = Values::NONE, string $credentialSid = Values::NONE, string $endpoint = Values::NONE)
    {
        $this->options['tag'] = $tag;
        $this->options['notificationProtocolVersion'] = $notificationProtocolVersion;
        $this->options['credentialSid'] = $credentialSid;
        $this->options['endpoint'] = $endpoint;
    }

    public function setTag(array $tag): self
    {
        $this->options['tag'] = $tag;
        return $this;
    }

    public function setNotificationProtocolVersion(string $notificationProtocolVersion): self
    {
        $this->options['notificationProtocolVersion'] = $notificationProtocolVersion;
        return $this;
    }

    public function setCredentialSid(string $credentialSid): self
    {
        $this->options['credentialSid'] = $credentialSid;
        return $this;
    }

    public function setEndpoint(string $endpoint): self
    {
        $this->options['endpoint'] = $endpoint;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Notify.V1.CreateBindingOptions ' . $options . ']';
    }
}

class ReadBindingOptions extends Options
{
    public function __construct(DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE, array $identity = Values::ARRAY_NONE, array $tag = Values::ARRAY_NONE)
    {
        $this->options['startDate'] = $startDate;
        $this->options['endDate'] = $endDate;
        $this->options['identity'] = $identity;
        $this->options['tag'] = $tag;
    }

    public function setStartDate(DateTime $startDate): self
    {
        $this->options['startDate'] = $startDate;
        return $this;
    }

    public function setEndDate(DateTime $endDate): self
    {
        $this->options['endDate'] = $endDate;
        return $this;
    }

    public function setIdentity(array $identity): self
    {
        $this->options['identity'] = $identity;
        return $this;
    }

    public function setTag(array $tag): self
    {
        $this->options['tag'] = $tag;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Notify.V1.ReadBindingOptions ' . $options . ']';
    }
}