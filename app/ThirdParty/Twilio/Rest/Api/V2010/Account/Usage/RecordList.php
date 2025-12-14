<?php

namespace Twilio\Rest\Api\V2010\Account\Usage;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Usage\Record\AllTimeList;
use Twilio\Rest\Api\V2010\Account\Usage\Record\DailyList;
use Twilio\Rest\Api\V2010\Account\Usage\Record\LastMonthList;
use Twilio\Rest\Api\V2010\Account\Usage\Record\MonthlyList;
use Twilio\Rest\Api\V2010\Account\Usage\Record\ThisMonthList;
use Twilio\Rest\Api\V2010\Account\Usage\Record\TodayList;
use Twilio\Rest\Api\V2010\Account\Usage\Record\YearlyList;
use Twilio\Rest\Api\V2010\Account\Usage\Record\YesterdayList;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function iterator_to_array;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class RecordList extends ListResource
{
    protected $_allTime = null;
    protected $_daily = null;
    protected $_lastMonth = null;
    protected $_monthly = null;
    protected $_thisMonth = null;
    protected $_today = null;
    protected $_yearly = null;
    protected $_yesterday = null;

    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Usage/Records.json';
    }

    public function stream(array $options = [], int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($options, $limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function read(array $options = [], int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): RecordPage
    {
        $options = new Values($options);
        $params = Values::of(['Category' => $options['category'], 'StartDate' => Serialize::iso8601Date($options['startDate']), 'EndDate' => Serialize::iso8601Date($options['endDate']), 'IncludeSubaccounts' => Serialize::booleanToString($options['includeSubaccounts']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new RecordPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): RecordPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new RecordPage($this->version, $response, $this->solution);
    }

    protected function getAllTime(): AllTimeList
    {
        if (!$this->_allTime) {
            $this->_allTime = new AllTimeList($this->version, $this->solution['accountSid']);
        }
        return $this->_allTime;
    }

    protected function getDaily(): DailyList
    {
        if (!$this->_daily) {
            $this->_daily = new DailyList($this->version, $this->solution['accountSid']);
        }
        return $this->_daily;
    }

    protected function getLastMonth(): LastMonthList
    {
        if (!$this->_lastMonth) {
            $this->_lastMonth = new LastMonthList($this->version, $this->solution['accountSid']);
        }
        return $this->_lastMonth;
    }

    protected function getMonthly(): MonthlyList
    {
        if (!$this->_monthly) {
            $this->_monthly = new MonthlyList($this->version, $this->solution['accountSid']);
        }
        return $this->_monthly;
    }

    protected function getThisMonth(): ThisMonthList
    {
        if (!$this->_thisMonth) {
            $this->_thisMonth = new ThisMonthList($this->version, $this->solution['accountSid']);
        }
        return $this->_thisMonth;
    }

    protected function getToday(): TodayList
    {
        if (!$this->_today) {
            $this->_today = new TodayList($this->version, $this->solution['accountSid']);
        }
        return $this->_today;
    }

    protected function getYearly(): YearlyList
    {
        if (!$this->_yearly) {
            $this->_yearly = new YearlyList($this->version, $this->solution['accountSid']);
        }
        return $this->_yearly;
    }

    protected function getYesterday(): YesterdayList
    {
        if (!$this->_yesterday) {
            $this->_yesterday = new YesterdayList($this->version, $this->solution['accountSid']);
        }
        return $this->_yesterday;
    }

    public function __get(string $name)
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.RecordList]';
    }
}