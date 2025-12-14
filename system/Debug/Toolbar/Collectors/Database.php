<?php

namespace Higgs\Debug\Toolbar\Collectors;

use Higgs\Database\Query;
use Higgs\I18n\Time;

class Database extends BaseCollector
{
    protected static $queries = [];
    protected $hasTimeline = true;
    protected $hasTabContent = true;
    protected $hasVarData = false;
    protected $title = 'Database';
    protected $connections;

    public function __construct()
    {
        $this->getConnections();
    }

    private function getConnections()
    {
        $this->connections = \Config\Database::getConnections();
    }

    public static function collect(Query $query)
    {
        $config = config('Toolbar');
        $max = $config->maxQueries ?: 100;
        if (count(static::$queries) < $max) {
            $queryString = $query->getQuery();
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            if (!is_cli()) {
                $backtrace = array_slice($backtrace, 2);
            }
            static::$queries[] = ['query' => $query, 'string' => $queryString, 'duplicate' => in_array($queryString, array_column(static::$queries, 'string', null), true), 'trace' => $backtrace,];
        }
    }

    public function display(): array
    {
        $data['queries'] = array_map(static function (array $query) {
            $isDuplicate = $query['duplicate'] === true;
            $firstNonSystemLine = '';
            foreach ($query['trace'] as $index => &$line) {
                if (isset($line['file'])) {
                    $line['file'] = clean_path($line['file']) . ':' . $line['line'];
                    unset($line['line']);
                } else {
                    $line['file'] = '[internal function]';
                }
                if ($firstNonSystemLine === '' && strpos($line['file'], 'SYSTEMPATH') === false) {
                    $firstNonSystemLine = $line['file'];
                }
                if (isset($line['class'])) {
                    $line['function'] = $line['class'] . $line['type'] . $line['function'];
                    unset($line['class'], $line['type']);
                }
                if (strrpos($line['function'], '{closure}') === false) {
                    $line['function'] .= '()';
                }
                $line['function'] = str_repeat(chr(0xC2) . chr(0xA0), 8) . $line['function'];
                $indexPadded = str_pad(sprintf('%d', $index + 1), 3, ' ', STR_PAD_LEFT);
                $indexPadded = preg_replace('/\s/', chr(0xC2) . chr(0xA0), $indexPadded);
                $line['index'] = $indexPadded . str_repeat(chr(0xC2) . chr(0xA0), 4);
            }
            return ['hover' => $isDuplicate ? 'This query was called more than once.' : '', 'class' => $isDuplicate ? 'duplicate' : '', 'duration' => ((float)$query['query']->getDuration(5) * 1000) . ' ms', 'sql' => $query['query']->debugToolbarDisplay(), 'trace' => $query['trace'], 'trace-file' => $firstNonSystemLine, 'qid' => md5($query['query'] . Time::now()->format('0.u00 U')),];
        }, static::$queries);
        return $data;
    }

    public function getBadgeValue(): int
    {
        return count(static::$queries);
    }

    public function getTitleDetails(): string
    {
        $this->getConnections();
        $queryCount = count(static::$queries);
        $uniqueCount = count(array_filter(static::$queries, static fn($query) => $query['duplicate'] === false));
        $connectionCount = count($this->connections);
        return sprintf('(%d total Quer%s, %d %s unique across %d Connection%s)', $queryCount, $queryCount > 1 ? 'ies' : 'y', $uniqueCount, $uniqueCount > 1 ? 'of them' : '', $connectionCount, $connectionCount > 1 ? 's' : '');
    }

    public function isEmpty(): bool
    {
        return empty(static::$queries);
    }

    public function icon(): string
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAADMSURBVEhLY6A3YExLSwsA4nIycQDIDIhRWEBqamo/UNF/SjDQjF6ocZgAKPkRiFeEhoYyQ4WIBiA9QAuWAPEHqBAmgLqgHcolGQD1V4DMgHIxwbCxYD+QBqcKINseKo6eWrBioPrtQBq/BcgY5ht0cUIYbBg2AJKkRxCNWkDQgtFUNJwtABr+F6igE8olGQD114HMgHIxAVDyAhA/AlpSA8RYUwoeXAPVex5qHCbIyMgwBCkAuQJIY00huDBUz/mUlBQDqHGjgBjAwAAACexpph6oHSQAAAAASUVORK5CYII=';
    }

    protected function formatTimelineData(): array
    {
        $data = [];
        foreach ($this->connections as $alias => $connection) {
            $data[] = ['name' => 'Connecting to Database: "' . $alias . '"', 'component' => 'Database', 'start' => $connection->getConnectStart(), 'duration' => $connection->getConnectDuration(),];
        }
        foreach (static::$queries as $query) {
            $data[] = ['name' => 'Query', 'component' => 'Database', 'start' => $query['query']->getStartTime(true), 'duration' => $query['query']->getDuration(), 'query' => $query['query']->debugToolbarDisplay(),];
        }
        return $data;
    }
}