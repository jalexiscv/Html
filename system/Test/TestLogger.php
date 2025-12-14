<?php

namespace Higgs\Test;

use Higgs\Log\Logger;

class TestLogger extends Logger
{
    protected static $op_logs = [];

    public static function didLog(string $level, $message, bool $useExactComparison = true)
    {
        $lowerLevel = strtolower($level);
        foreach (self::$op_logs as $log) {
            if (strtolower($log['level']) !== $lowerLevel) {
                continue;
            }
            if ($useExactComparison) {
                if ($log['message'] === $message) {
                    return true;
                }
                continue;
            }
            if (strpos($log['message'], $message) !== false) {
                return true;
            }
        }
        return false;
    }

    public function log($level, $message, array $context = []): bool
    {
        $logMessage = $this->interpolate($message, $context);
        $trace = debug_backtrace();
        $file = null;
        foreach ($trace as $row) {
            if (!in_array($row['function'], ['log', 'log_message'], true)) {
                $file = basename($row['file'] ?? '');
                break;
            }
        }
        self::$op_logs[] = ['level' => $level, 'message' => $logMessage, 'file' => $file,];
        return parent::log($level, $message, $context);
    }

    public function cleanup($file)
    {
        return clean_path($file);
    }
}