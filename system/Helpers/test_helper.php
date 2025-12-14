<?php

use Higgs\Exceptions\TestException;
use Higgs\Model;
use Higgs\Test\Fabricator;
use Config\Services;

if (!function_exists('fake')) {
    function fake($model, ?array $overrides = null, $persist = true)
    {
        $fabricator = new Fabricator($model);
        if ($overrides) {
            $fabricator->setOverrides($overrides);
        }
        if ($persist) {
            return $fabricator->create();
        }
        return $fabricator->make();
    }
}
if (!function_exists('mock')) {
    function mock(string $className)
    {
        $mockClass = $className::$mockClass;
        $mockService = $className::$mockServiceName ?? '';
        if (empty($mockClass) || !class_exists($mockClass)) {
            throw TestException::forInvalidMockClass($mockClass);
        }
        $mock = new $mockClass();
        if (!empty($mockService)) {
            Services::injectMock($mockService, $mock);
        }
        return $mock;
    }
}