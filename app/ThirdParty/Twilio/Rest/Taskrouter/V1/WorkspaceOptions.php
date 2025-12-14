<?php

namespace Twilio\Rest\Taskrouter\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WorkspaceOptions
{
    public static function update(string $defaultActivitySid = Values::NONE, string $eventCallbackUrl = Values::NONE, string $eventsFilter = Values::NONE, string $friendlyName = Values::NONE, bool $multiTaskEnabled = Values::NONE, string $timeoutActivitySid = Values::NONE, string $prioritizeQueueOrder = Values::NONE): UpdateWorkspaceOptions
    {
        return new UpdateWorkspaceOptions($defaultActivitySid, $eventCallbackUrl, $eventsFilter, $friendlyName, $multiTaskEnabled, $timeoutActivitySid, $prioritizeQueueOrder);
    }

    public static function read(string $friendlyName = Values::NONE): ReadWorkspaceOptions
    {
        return new ReadWorkspaceOptions($friendlyName);
    }

    public static function create(string $eventCallbackUrl = Values::NONE, string $eventsFilter = Values::NONE, bool $multiTaskEnabled = Values::NONE, string $template = Values::NONE, string $prioritizeQueueOrder = Values::NONE): CreateWorkspaceOptions
    {
        return new CreateWorkspaceOptions($eventCallbackUrl, $eventsFilter, $multiTaskEnabled, $template, $prioritizeQueueOrder);
    }
}

class UpdateWorkspaceOptions extends Options
{
    public function __construct(string $defaultActivitySid = Values::NONE, string $eventCallbackUrl = Values::NONE, string $eventsFilter = Values::NONE, string $friendlyName = Values::NONE, bool $multiTaskEnabled = Values::NONE, string $timeoutActivitySid = Values::NONE, string $prioritizeQueueOrder = Values::NONE)
    {
        $this->options['defaultActivitySid'] = $defaultActivitySid;
        $this->options['eventCallbackUrl'] = $eventCallbackUrl;
        $this->options['eventsFilter'] = $eventsFilter;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['multiTaskEnabled'] = $multiTaskEnabled;
        $this->options['timeoutActivitySid'] = $timeoutActivitySid;
        $this->options['prioritizeQueueOrder'] = $prioritizeQueueOrder;
    }

    public function setDefaultActivitySid(string $defaultActivitySid): self
    {
        $this->options['defaultActivitySid'] = $defaultActivitySid;
        return $this;
    }

    public function setEventCallbackUrl(string $eventCallbackUrl): self
    {
        $this->options['eventCallbackUrl'] = $eventCallbackUrl;
        return $this;
    }

    public function setEventsFilter(string $eventsFilter): self
    {
        $this->options['eventsFilter'] = $eventsFilter;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setMultiTaskEnabled(bool $multiTaskEnabled): self
    {
        $this->options['multiTaskEnabled'] = $multiTaskEnabled;
        return $this;
    }

    public function setTimeoutActivitySid(string $timeoutActivitySid): self
    {
        $this->options['timeoutActivitySid'] = $timeoutActivitySid;
        return $this;
    }

    public function setPrioritizeQueueOrder(string $prioritizeQueueOrder): self
    {
        $this->options['prioritizeQueueOrder'] = $prioritizeQueueOrder;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.UpdateWorkspaceOptions ' . $options . ']';
    }
}

class ReadWorkspaceOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.ReadWorkspaceOptions ' . $options . ']';
    }
}

class CreateWorkspaceOptions extends Options
{
    public function __construct(string $eventCallbackUrl = Values::NONE, string $eventsFilter = Values::NONE, bool $multiTaskEnabled = Values::NONE, string $template = Values::NONE, string $prioritizeQueueOrder = Values::NONE)
    {
        $this->options['eventCallbackUrl'] = $eventCallbackUrl;
        $this->options['eventsFilter'] = $eventsFilter;
        $this->options['multiTaskEnabled'] = $multiTaskEnabled;
        $this->options['template'] = $template;
        $this->options['prioritizeQueueOrder'] = $prioritizeQueueOrder;
    }

    public function setEventCallbackUrl(string $eventCallbackUrl): self
    {
        $this->options['eventCallbackUrl'] = $eventCallbackUrl;
        return $this;
    }

    public function setEventsFilter(string $eventsFilter): self
    {
        $this->options['eventsFilter'] = $eventsFilter;
        return $this;
    }

    public function setMultiTaskEnabled(bool $multiTaskEnabled): self
    {
        $this->options['multiTaskEnabled'] = $multiTaskEnabled;
        return $this;
    }

    public function setTemplate(string $template): self
    {
        $this->options['template'] = $template;
        return $this;
    }

    public function setPrioritizeQueueOrder(string $prioritizeQueueOrder): self
    {
        $this->options['prioritizeQueueOrder'] = $prioritizeQueueOrder;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.CreateWorkspaceOptions ' . $options . ']';
    }
}