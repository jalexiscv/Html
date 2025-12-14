<?php

namespace Higgs\Debug\Toolbar\Collectors;

use Config\Services;

class Timers extends BaseCollector
{
    protected $hasTimeline = true;
    protected $hasTabContent = false;
    protected $title = 'Timers';

    protected function formatTimelineData(): array
    {
        $data = [];
        $benchmark = Services::timer(true);
        $rows = $benchmark->getTimers(6);
        foreach ($rows as $name => $info) {
            if ($name === 'total_execution') {
                continue;
            }
            $data[] = ['name' => ucwords(str_replace('_', ' ', $name)), 'component' => 'Timer', 'start' => $info['start'], 'duration' => $info['end'] - $info['start'],];
        }
        return $data;
    }
}