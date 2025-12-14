<?php

namespace Higgs\Test\Mock;

use Config\Security;

class MockSecurityConfig extends Security
{
    public string $tokenName = 'csrf_test_name';
    public string $headerName = 'X-CSRF-TOKEN';
    public string $cookieName = 'csrf_cookie_name';
    public int $expires = 7200;
    public bool $regenerate = true;
    public bool $redirect = false;
    public string $samesite = 'Lax';
    public $excludeURIs = ['http://example.com'];
}