<?php

namespace Higgs\Test\Mock;

use Higgs\Cookie\Cookie;
use Higgs\I18n\Time;
use Higgs\Session\Session;

class MockSession extends Session
{
    public $cookies = [];
    public $didRegenerate = false;

    public function regenerate(bool $destroy = false)
    {
        $this->didRegenerate = true;
        $_SESSION['__ci_last_regenerate'] = Time::now()->getTimestamp();
    }

    protected function setSaveHandler()
    {
    }

    protected function startSession()
    {
        $this->setCookie();
    }

    protected function setCookie()
    {
        $expiration = $this->sessionExpiration === 0 ? 0 : Time::now()->getTimestamp() + $this->sessionExpiration;
        $this->cookie = $this->cookie->withValue(session_id())->withExpires($expiration);
        $this->cookies[] = $this->cookie;
    }
}