<?php

namespace Twilio\Rest\Api\V2010\Account\Usage\Record;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MonthlyOptions
{
    public static function read(string $category = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE, bool $includeSubaccounts = Values::NONE): ReadMonthlyOptions
    {
        return new ReadMonthlyOptions($category, $startDate, $endDate, $includeSubaccounts);
    }
}

class ReadMonthlyOptions extends Options
{
    public function __construct(string $category = Values::NONE, DateTime $startDate = Values::NONE, DateTime $endDate = Values::NONE, bool $includeSubaccounts = Values::NONE)
    {
        $this->options['category'] = $category;
        $this->options['startDate'] = $startDate;
        $this->options['endDate'] = $endDate;
        $this->options['includeSubaccounts'] = $includeSubaccounts;
    }

    public function setCategory(string $category): self
    {
        $this->options['category'] = $category;
        return $this;
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

    public function setIncludeSubaccounts(bool $includeSubaccounts): self
    {
        $this->options['includeSubaccounts'] = $includeSubaccounts;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadMonthlyOptions ' . $options . ']';
    }
}