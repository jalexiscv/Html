<?php

namespace Higgs\Debug\Toolbar\Collectors;

use Higgs\View\RendererInterface;
use Config\Services;

class Events extends BaseCollector
{
    protected $hasTimeline = false;
    protected $hasTabContent = true;
    protected $hasVarData = false;
    protected $title = 'Events';
    protected $viewer;

    public function __construct()
    {
        $this->viewer = Services::renderer();
    }

    public function display(): array
    {
        $data = ['events' => [],];
        foreach (\Higgs\Events\Events::getPerformanceLogs() as $row) {
            $key = $row['event'];
            if (!array_key_exists($key, $data['events'])) {
                $data['events'][$key] = ['event' => $key, 'duration' => ($row['end'] - $row['start']) * 1000, 'count' => 1,];
                continue;
            }
            $data['events'][$key]['duration'] += ($row['end'] - $row['start']) * 1000;
            $data['events'][$key]['count']++;
        }
        foreach ($data['events'] as &$row) {
            $row['duration'] = number_format($row['duration'], 2);
        }
        return $data;
    }

    public function getBadgeValue(): int
    {
        return count(\Higgs\Events\Events::getPerformanceLogs());
    }

    public function icon(): string
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEASURBVEhL7ZXNDcIwDIVTsRBH1uDQDdquUA6IM1xgCA6MwJUN2hk6AQzAz0vl0ETUxC5VT3zSU5w81/mRMGZysixbFEVR0jSKNt8geQU9aRpFmp/keX6AbjZ5oB74vsaN5lSzA4tLSjpBFxsjeSuRy4d2mDdQTWU7YLbXTNN05mKyovj5KL6B7q3hoy3KwdZxBlT+Ipz+jPHrBqOIynZgcZonoukb/0ckiTHqNvDXtXEAaygRbaB9FvUTjRUHsIYS0QaSp+Dw6wT4hiTmYHOcYZsdLQ2CbXa4ftuuYR4x9vYZgdb4vsFYUdmABMYeukK9/SUme3KMFQ77+Yfzh8eYF8+orDuDWU5LAAAAAElFTkSuQmCC';
    }

    protected function formatTimelineData(): array
    {
        $data = [];
        $rows = $this->viewer->getPerformanceData();
        foreach ($rows as $info) {
            $data[] = ['name' => 'View: ' . $info['view'], 'component' => 'Views', 'start' => $info['start'], 'duration' => $info['end'] - $info['start'],];
        }
        return $data;
    }
}