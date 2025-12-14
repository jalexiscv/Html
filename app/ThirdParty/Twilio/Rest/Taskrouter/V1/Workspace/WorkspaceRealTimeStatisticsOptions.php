<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WorkspaceRealTimeStatisticsOptions
{
    public static function fetch(string $taskChannel = Values::NONE): FetchWorkspaceRealTimeStatisticsOptions
    {
        return new FetchWorkspaceRealTimeStatisticsOptions($taskChannel);
    }
}

class FetchWorkspaceRealTimeStatisticsOptions extends Options
{
    public function __construct(string $taskChannel = Values::NONE)
    {
        $this->options['taskChannel'] = $taskChannel;
    }

    public function setTaskChannel(string $taskChannel): self
    {
        $this->options['taskChannel'] = $taskChannel;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.FetchWorkspaceRealTimeStatisticsOptions ' . $options . ']';
    }
}