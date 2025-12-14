<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class QueryOptions
{
    public static function read(string $language = Values::NONE, string $modelBuild = Values::NONE, string $status = Values::NONE, string $dialogueSid = Values::NONE): ReadQueryOptions
    {
        return new ReadQueryOptions($language, $modelBuild, $status, $dialogueSid);
    }

    public static function create(string $tasks = Values::NONE, string $modelBuild = Values::NONE): CreateQueryOptions
    {
        return new CreateQueryOptions($tasks, $modelBuild);
    }

    public static function update(string $sampleSid = Values::NONE, string $status = Values::NONE): UpdateQueryOptions
    {
        return new UpdateQueryOptions($sampleSid, $status);
    }
}

class ReadQueryOptions extends Options
{
    public function __construct(string $language = Values::NONE, string $modelBuild = Values::NONE, string $status = Values::NONE, string $dialogueSid = Values::NONE)
    {
        $this->options['language'] = $language;
        $this->options['modelBuild'] = $modelBuild;
        $this->options['status'] = $status;
        $this->options['dialogueSid'] = $dialogueSid;
    }

    public function setLanguage(string $language): self
    {
        $this->options['language'] = $language;
        return $this;
    }

    public function setModelBuild(string $modelBuild): self
    {
        $this->options['modelBuild'] = $modelBuild;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setDialogueSid(string $dialogueSid): self
    {
        $this->options['dialogueSid'] = $dialogueSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.ReadQueryOptions ' . $options . ']';
    }
}

class CreateQueryOptions extends Options
{
    public function __construct(string $tasks = Values::NONE, string $modelBuild = Values::NONE)
    {
        $this->options['tasks'] = $tasks;
        $this->options['modelBuild'] = $modelBuild;
    }

    public function setTasks(string $tasks): self
    {
        $this->options['tasks'] = $tasks;
        return $this;
    }

    public function setModelBuild(string $modelBuild): self
    {
        $this->options['modelBuild'] = $modelBuild;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.CreateQueryOptions ' . $options . ']';
    }
}

class UpdateQueryOptions extends Options
{
    public function __construct(string $sampleSid = Values::NONE, string $status = Values::NONE)
    {
        $this->options['sampleSid'] = $sampleSid;
        $this->options['status'] = $status;
    }

    public function setSampleSid(string $sampleSid): self
    {
        $this->options['sampleSid'] = $sampleSid;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.UpdateQueryOptions ' . $options . ']';
    }
}