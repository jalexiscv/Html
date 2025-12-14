<?php

namespace Higgs\I18n;

use Higgs\I18n\Exceptions\I18nException;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use IntlCalendar;
use IntlDateFormatter;
use Locale;
use ReturnTypeWillChange;

trait TimeTrait
{
    protected static $relativePattern = '/this|next|last|tomorrow|yesterday|midnight|today|[+-]|first|last|ago/i';
    protected static $testNow;
    protected $timezone;
    protected $locale;
    protected $toStringFormat = 'yyyy-MM-dd HH:mm:ss';

    public static function today($timezone = null, ?string $locale = null)
    {
        return new self(date('Y-m-d 00:00:00'), $timezone, $locale);
    }

    public static function yesterday($timezone = null, ?string $locale = null)
    {
        return new self(date('Y-m-d 00:00:00', strtotime('-1 day')), $timezone, $locale);
    }

    public static function tomorrow($timezone = null, ?string $locale = null)
    {
        return new self(date('Y-m-d 00:00:00', strtotime('+1 day')), $timezone, $locale);
    }

    public static function createFromDate(?int $year = null, ?int $month = null, ?int $day = null, $timezone = null, ?string $locale = null)
    {
        return static::create($year, $month, $day, null, null, null, $timezone, $locale);
    }

    public static function create(?int $year = null, ?int $month = null, ?int $day = null, ?int $hour = null, ?int $minutes = null, ?int $seconds = null, $timezone = null, ?string $locale = null)
    {
        $year ??= date('Y');
        $month ??= date('m');
        $day ??= date('d');
        $hour = empty($hour) ? 0 : $hour;
        $minutes = empty($minutes) ? 0 : $minutes;
        $seconds = empty($seconds) ? 0 : $seconds;
        return new self(date('Y-m-d H:i:s', strtotime("{$year}-{$month}-{$day} {$hour}:{$minutes}:{$seconds}")), $timezone, $locale);
    }

    public static function createFromTime(?int $hour = null, ?int $minutes = null, ?int $seconds = null, $timezone = null, ?string $locale = null)
    {
        return static::create(null, null, null, $hour, $minutes, $seconds, $timezone, $locale);
    }

    #[ReturnTypeWillChange] public static function createFromFormat($format, $datetime, $timezone = null)
    {
        if (!$date = parent::createFromFormat($format, $datetime)) {
            throw I18nException::forInvalidFormat($format);
        }
        return new self($date->format('Y-m-d H:i:s'), $timezone);
    }

    public static function createFromTimestamp(int $timestamp, $timezone = null, ?string $locale = null)
    {
        $time = new self(gmdate('Y-m-d H:i:s', $timestamp), 'UTC', $locale);
        $timezone ??= 'UTC';
        return $time->setTimezone($timezone);
    }

    #[ReturnTypeWillChange] public function setTimezone($timezone)
    {
        $timezone = $timezone instanceof DateTimeZone ? $timezone : new DateTimeZone($timezone);
        return self::createFromInstance($this->toDateTime()->setTimezone($timezone), $this->locale);
    }

    public static function createFromInstance(DateTimeInterface $dateTime, ?string $locale = null)
    {
        $date = $dateTime->format('Y-m-d H:i:s');
        $timezone = $dateTime->getTimezone();
        return new self($date, $timezone, $locale);
    }

    public function toDateTime()
    {
        $dateTime = new DateTime('', $this->getTimezone());
        $dateTime->setTimestamp(parent::getTimestamp());
        return $dateTime;
    }

    #[ReturnTypeWillChange] public function setTimestamp($timestamp)
    {
        $time = date('Y-m-d H:i:s', $timestamp);
        return self::parse($time, $this->timezone, $this->locale);
    }

    public static function parse(string $datetime, $timezone = null, ?string $locale = null)
    {
        return new self($datetime, $timezone, $locale);
    }

    public static function instance(DateTime $dateTime, ?string $locale = null)
    {
        return self::createFromInstance($dateTime, $locale);
    }

    public static function setTestNow($datetime = null, $timezone = null, ?string $locale = null)
    {
        if ($datetime === null) {
            static::$testNow = null;
            return;
        }
        if (is_string($datetime)) {
            $datetime = new self($datetime, $timezone, $locale);
        } elseif ($datetime instanceof DateTimeInterface && !$datetime instanceof self) {
            $datetime = new self($datetime->format('Y-m-d H:i:s'), $timezone);
        }
        static::$testNow = $datetime;
    }

    public static function hasTestNow(): bool
    {
        return static::$testNow !== null;
    }

    public function getDay(): string
    {
        return $this->toLocalizedString('d');
    }

    public function toLocalizedString(?string $format = null)
    {
        $format ??= $this->toStringFormat;
        return IntlDateFormatter::formatObject($this->toDateTime(), $format, $this->locale);
    }

    public function getHour(): string
    {
        return $this->toLocalizedString('H');
    }

    public function getMinute(): string
    {
        return $this->toLocalizedString('m');
    }

    public function getSecond(): string
    {
        return $this->toLocalizedString('s');
    }

    public function getDayOfWeek(): string
    {
        return $this->toLocalizedString('c');
    }

    public function getDayOfYear(): string
    {
        return $this->toLocalizedString('D');
    }

    public function getWeekOfMonth(): string
    {
        return $this->toLocalizedString('W');
    }

    public function getWeekOfYear(): string
    {
        return $this->toLocalizedString('w');
    }

    public function getAge()
    {
        return max(0, $this->difference(self::now())->getYears());
    }

    public function difference($testTime, ?string $timezone = null)
    {
        $testTime = $this->getUTCObject($testTime, $timezone);
        $ourTime = $this->getUTCObject($this);
        return new TimeDifference($ourTime, $testTime);
    }

    public function getUTCObject($time, ?string $timezone = null)
    {
        if ($time instanceof self) {
            $time = $time->toDateTime();
        } elseif (is_string($time)) {
            $timezone = $timezone ?: $this->timezone;
            $timezone = $timezone instanceof DateTimeZone ? $timezone : new DateTimeZone($timezone);
            $time = new DateTime($time, $timezone);
        }
        if ($time instanceof DateTime || $time instanceof DateTimeImmutable) {
            $time = $time->setTimezone(new DateTimeZone('UTC'));
        }
        return $time;
    }

    public static function now($timezone = null, ?string $locale = null)
    {
        return new self(null, $timezone, $locale);
    }

    public function getQuarter(): string
    {
        return $this->toLocalizedString('Q');
    }

    public function getDst(): bool
    {
        return $this->format('I') === '1';
    }

    public function getLocal(): bool
    {
        $local = date_default_timezone_get();
        return $local === $this->timezone->getName();
    }

    public function getUtc(): bool
    {
        return $this->getOffset() === 0;
    }

    public function setYear($value)
    {
        return $this->setValue('year', $value);
    }

    protected function setValue(string $name, $value)
    {
        [$year, $month, $day, $hour, $minute, $second] = explode('-', $this->format('Y-n-j-G-i-s'));
        ${$name} = $value;
        return self::create((int)$year, (int)$month, (int)$day, (int)$hour, (int)$minute, (int)$second, $this->getTimezoneName(), $this->locale);
    }

    public function getTimezoneName(): string
    {
        return $this->timezone->getName();
    }

    public function setMonth($value)
    {
        if (is_numeric($value) && ($value < 1 || $value > 12)) {
            throw I18nException::forInvalidMonth($value);
        }
        if (is_string($value) && !is_numeric($value)) {
            $value = date('m', strtotime("{$value} 1 2017"));
        }
        return $this->setValue('month', $value);
    }

    public function setDay($value)
    {
        if ($value < 1 || $value > 31) {
            throw I18nException::forInvalidDay($value);
        }
        $date = $this->getYear() . '-' . $this->getMonth();
        $lastDay = date('t', strtotime($date));
        if ($value > $lastDay) {
            throw I18nException::forInvalidOverDay($lastDay, $value);
        }
        return $this->setValue('day', $value);
    }

    public function getYear(): string
    {
        return $this->toLocalizedString('y');
    }

    public function getMonth(): string
    {
        return $this->toLocalizedString('M');
    }

    public function setHour($value)
    {
        if ($value < 0 || $value > 23) {
            throw I18nException::forInvalidHour($value);
        }
        return $this->setValue('hour', $value);
    }

    public function setMinute($value)
    {
        if ($value < 0 || $value > 59) {
            throw I18nException::forInvalidMinutes($value);
        }
        return $this->setValue('minute', $value);
    }

    public function setSecond($value)
    {
        if ($value < 0 || $value > 59) {
            throw I18nException::forInvalidSeconds($value);
        }
        return $this->setValue('second', $value);
    }

    public function addSeconds(int $seconds)
    {
        $time = clone $this;
        return $time->add(DateInterval::createFromDateString("{$seconds} seconds"));
    }

    public function addMinutes(int $minutes)
    {
        $time = clone $this;
        return $time->add(DateInterval::createFromDateString("{$minutes} minutes"));
    }

    public function addHours(int $hours)
    {
        $time = clone $this;
        return $time->add(DateInterval::createFromDateString("{$hours} hours"));
    }

    public function addDays(int $days)
    {
        $time = clone $this;
        return $time->add(DateInterval::createFromDateString("{$days} days"));
    }

    public function addMonths(int $months)
    {
        $time = clone $this;
        return $time->add(DateInterval::createFromDateString("{$months} months"));
    }

    public function addYears(int $years)
    {
        $time = clone $this;
        return $time->add(DateInterval::createFromDateString("{$years} years"));
    }

    public function subSeconds(int $seconds)
    {
        $time = clone $this;
        return $time->sub(DateInterval::createFromDateString("{$seconds} seconds"));
    }

    public function subMinutes(int $minutes)
    {
        $time = clone $this;
        return $time->sub(DateInterval::createFromDateString("{$minutes} minutes"));
    }

    public function subHours(int $hours)
    {
        $time = clone $this;
        return $time->sub(DateInterval::createFromDateString("{$hours} hours"));
    }

    public function subDays(int $days)
    {
        $time = clone $this;
        return $time->sub(DateInterval::createFromDateString("{$days} days"));
    }

    public function subMonths(int $months)
    {
        $time = clone $this;
        return $time->sub(DateInterval::createFromDateString("{$months} months"));
    }

    public function subYears(int $years)
    {
        $time = clone $this;
        return $time->sub(DateInterval::createFromDateString("{$years} years"));
    }

    public function toDateString()
    {
        return $this->toLocalizedString('yyyy-MM-dd');
    }

    public function toFormattedDateString()
    {
        return $this->toLocalizedString('MMM d, yyyy');
    }

    public function toTimeString()
    {
        return $this->toLocalizedString('HH:mm:ss');
    }

    public function equals($testTime, ?string $timezone = null): bool
    {
        $testTime = $this->getUTCObject($testTime, $timezone);
        $ourTime = $this->toDateTime()->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s');
        return $testTime->format('Y-m-d H:i:s') === $ourTime;
    }

    public function sameAs($testTime, ?string $timezone = null): bool
    {
        if ($testTime instanceof DateTimeInterface) {
            $testTime = $testTime->format('Y-m-d H:i:s');
        } elseif (is_string($testTime)) {
            $timezone = $timezone ?: $this->timezone;
            $timezone = $timezone instanceof DateTimeZone ? $timezone : new DateTimeZone($timezone);
            $testTime = new DateTime($testTime, $timezone);
            $testTime = $testTime->format('Y-m-d H:i:s');
        }
        $ourTime = $this->toDateTimeString();
        return $testTime === $ourTime;
    }

    public function toDateTimeString()
    {
        return $this->toLocalizedString('yyyy-MM-dd HH:mm:ss');
    }

    public function isBefore($testTime, ?string $timezone = null): bool
    {
        $testTime = $this->getUTCObject($testTime, $timezone)->getTimestamp();
        $ourTime = $this->getTimestamp();
        return $ourTime < $testTime;
    }

    public function isAfter($testTime, ?string $timezone = null): bool
    {
        $testTime = $this->getUTCObject($testTime, $timezone)->getTimestamp();
        $ourTime = $this->getTimestamp();
        return $ourTime > $testTime;
    }

    public function humanize()
    {
        $now = IntlCalendar::fromDateTime(self::now($this->timezone));
        $time = $this->getCalendar()->getTime();
        $years = $now->fieldDifference($time, IntlCalendar::FIELD_YEAR);
        $months = $now->fieldDifference($time, IntlCalendar::FIELD_MONTH);
        $days = $now->fieldDifference($time, IntlCalendar::FIELD_DAY_OF_YEAR);
        $hours = $now->fieldDifference($time, IntlCalendar::FIELD_HOUR_OF_DAY);
        $minutes = $now->fieldDifference($time, IntlCalendar::FIELD_MINUTE);
        $phrase = null;
        if ($years !== 0) {
            $phrase = lang('Time.years', [abs($years)]);
            $before = $years < 0;
        } elseif ($months !== 0) {
            $phrase = lang('Time.months', [abs($months)]);
            $before = $months < 0;
        } elseif ($days !== 0 && (abs($days) >= 7)) {
            $weeks = ceil($days / 7);
            $phrase = lang('Time.weeks', [abs($weeks)]);
            $before = $days < 0;
        } elseif ($days !== 0) {
            $before = $days < 0;
            if (abs($days) === 1) {
                return $before ? lang('Time.yesterday') : lang('Time.tomorrow');
            }
            $phrase = lang('Time.days', [abs($days)]);
        } elseif ($hours !== 0) {
            $phrase = lang('Time.hours', [abs($hours)]);
            $before = $hours < 0;
        } elseif ($minutes !== 0) {
            $phrase = lang('Time.minutes', [abs($minutes)]);
            $before = $minutes < 0;
        } else {
            return lang('Time.now');
        }
        return $before ? lang('Time.ago', [$phrase]) : lang('Time.inFuture', [$phrase]);
    }

    public function getCalendar()
    {
        return IntlCalendar::fromDateTime($this);
    }

    public function __toString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->{$method}();
        }
        return null;
    }

    public function __isset($name): bool
    {
        $method = 'get' . ucfirst($name);
        return method_exists($this, $method);
    }

    public function __wakeup(): void
    {
        $timezone = $this->timezone;
        $this->timezone = new DateTimeZone($timezone);
        parent::__construct($this->date, $this->timezone);
    }

    public function __construct(?string $time = null, $timezone = null, ?string $locale = null)
    {
        $this->locale = $locale ?: Locale::getDefault();
        $time ??= '';
        if ($time === '' && static::$testNow instanceof self) {
            if ($timezone !== null) {
                $testNow = static::$testNow->setTimezone($timezone);
                $time = $testNow->format('Y-m-d H:i:s');
            } else {
                $timezone = static::$testNow->getTimezone();
                $time = static::$testNow->format('Y-m-d H:i:s');
            }
        }
        $timezone = $timezone ?: date_default_timezone_get();
        $this->timezone = $timezone instanceof DateTimeZone ? $timezone : new DateTimeZone($timezone);
        if ($time !== '' && static::hasRelativeKeywords($time)) {
            $instance = new DateTime('now', $this->timezone);
            $instance->modify($time);
            $time = $instance->format('Y-m-d H:i:s');
        }
        parent::__construct($time, $this->timezone);
    }

    protected static function hasRelativeKeywords(string $time): bool
    {
        if (preg_match('/\d{4}-\d{1,2}-\d{1,2}/', $time) !== 1) {
            return preg_match(static::$relativePattern, $time) > 0;
        }
        return false;
    }
}