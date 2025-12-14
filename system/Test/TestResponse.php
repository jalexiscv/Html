<?php

namespace Higgs\Test;

use Higgs\HTTP\RedirectResponse;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use Higgs\I18n\Time;
use Config\Services;
use Exception;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\TestCase;

class TestResponse extends TestCase
{
    protected $request;
    protected $response;
    protected $domParser;

    public function __construct(ResponseInterface $response)
    {
        $this->setResponse($response);
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        $this->domParser = new DOMParser();
        $body = $response->getBody();
        if (is_string($body) && $body !== '') {
            $this->domParser->withString($body);
        }
        return $this;
    }

    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }

    public function request()
    {
        return $this->request;
    }

    public function response()
    {
        return $this->response;
    }

    public function assertStatus(int $code)
    {
        $this->assertSame($code, $this->response->getStatusCode());
    }

    public function assertOK()
    {
        $this->assertTrue($this->isOK(), "{$this->response->getStatusCode()} is not a successful status code, or the Response has an empty body.");
    }

    public function isOK(): bool
    {
        $status = $this->response->getStatusCode();
        if ($status >= 400 || $status < 200) {
            return false;
        }
        return !($status < 300 && empty($this->response->getBody()));
    }

    public function assertNotOK()
    {
        $this->assertFalse($this->isOK(), "{$this->response->getStatusCode()} is an unexpected successful status code, or the Response has body content.");
    }

    public function assertRedirectTo(string $uri)
    {
        $this->assertRedirect();
        $uri = trim(strtolower($uri));
        $redirectUri = strtolower($this->getRedirectUrl());
        $matches = $uri === $redirectUri || strtolower(site_url($uri)) === $redirectUri || $uri === site_url($redirectUri);
        $this->assertTrue($matches, "Redirect URL `{$uri}` does not match `{$redirectUri}`");
    }

    public function assertRedirect()
    {
        $this->assertTrue($this->isRedirect(), 'Response is not a redirect or RedirectResponse.');
    }

    public function isRedirect(): bool
    {
        return $this->response instanceof RedirectResponse || $this->response->hasHeader('Location') || $this->response->hasHeader('Refresh');
    }

    public function getRedirectUrl(): ?string
    {
        if (!$this->isRedirect()) {
            return null;
        }
        if ($this->response->hasHeader('Location')) {
            return $this->response->getHeaderLine('Location');
        }
        if ($this->response->hasHeader('Refresh')) {
            return str_replace('0;url=', '', $this->response->getHeaderLine('Refresh'));
        }
        return null;
    }

    public function assertNotRedirect()
    {
        $this->assertFalse($this->isRedirect(), 'Response is an unexpected redirect or RedirectResponse.');
    }

    public function assertSessionHas(string $key, $value = null)
    {
        $this->assertArrayHasKey($key, $_SESSION, "'{$key}' is not in the current \$_SESSION");
        if ($value === null) {
            return;
        }
        if (is_scalar($value)) {
            $this->assertSame($value, $_SESSION[$key], "The value of '{$key}' ({$value}) does not match expected value.");
        } else {
            $this->assertSame($value, $_SESSION[$key], "The value of '{$key}' does not match expected value.");
        }
    }

    public function assertSessionMissing(string $key)
    {
        $this->assertArrayNotHasKey($key, $_SESSION, "'{$key}' should not be present in \$_SESSION.");
    }

    public function assertHeader(string $key, $value = null)
    {
        $this->assertTrue($this->response->hasHeader($key), "'{$key}' is not a valid Response header.");
        if ($value !== null) {
            $this->assertSame($value, $this->response->getHeaderLine($key), "The value of '{$key}' header ({$this->response->getHeaderLine($key)}) does not match expected value.");
        }
    }

    public function assertHeaderMissing(string $key)
    {
        $this->assertFalse($this->response->hasHeader($key), "'{$key}' should not be in the Response headers.");
    }

    public function assertCookie(string $key, $value = null, string $prefix = '')
    {
        $this->assertTrue($this->response->hasCookie($key, $value, $prefix), "No cookie found named '{$key}'.");
    }

    public function assertCookieMissing(string $key)
    {
        $this->assertFalse($this->response->hasCookie($key), "Cookie named '{$key}' should not be set.");
    }

    public function assertCookieExpired(string $key, string $prefix = '')
    {
        $this->assertTrue($this->response->hasCookie($key, null, $prefix));
        $this->assertGreaterThan(Time::now()->getTimestamp(), $this->response->getCookie($key, $prefix)->getExpiresTimestamp());
    }

    public function assertJSONFragment(array $fragment, bool $strict = false)
    {
        $json = json_decode($this->getJSON(), true);
        $this->assertIsArray($json, 'Response does not have valid json');
        $patched = array_replace_recursive($json, $fragment);
        if ($strict) {
            $this->assertSame($json, $patched, 'Response does not contain a matching JSON fragment.');
        } else {
            $this->assertThat($patched, new IsEqual($json), 'Response does not contain a matching JSON fragment.');
        }
    }

    public function getJSON()
    {
        $response = $this->response->getJSON();
        if ($response === null) {
            return false;
        }
        return $response;
    }

    public function assertJSONExact($test)
    {
        $json = $this->getJSON();
        if (is_object($test)) {
            $test = method_exists($test, 'toArray') ? $test->toArray() : (array)$test;
        }
        if (is_array($test)) {
            $test = Services::format()->getFormatter('application/json')->format($test);
        }
        $this->assertJsonStringEqualsJsonString($test, $json, 'Response does not contain matching JSON.');
    }

    public function getXML()
    {
        return $this->response->getXML();
    }

    public function assertSee(?string $search = null, ?string $element = null)
    {
        $this->assertTrue($this->domParser->see($search, $element), "Do not see '{$search}' in response.");
    }

    public function assertDontSee(?string $search = null, ?string $element = null)
    {
        $this->assertTrue($this->domParser->dontSee($search, $element), "I should not see '{$search}' in response.");
    }

    public function assertSeeElement(string $search)
    {
        $this->assertTrue($this->domParser->seeElement($search), "Do not see element with selector '{$search} in response.'");
    }

    public function assertDontSeeElement(string $search)
    {
        $this->assertTrue($this->domParser->dontSeeElement($search), "I should not see an element with selector '{$search}' in response.'");
    }

    public function assertSeeLink(string $text, ?string $details = null)
    {
        $this->assertTrue($this->domParser->seeLink($text, $details), "Do no see anchor tag with the text {$text} in response.");
    }

    public function assertSeeInField(string $field, ?string $value = null)
    {
        $this->assertTrue($this->domParser->seeInField($field, $value), "Do no see input named {$field} with value {$value} in response.");
    }

    public function __call($function, $params)
    {
        if (method_exists($this->domParser, $function)) {
            return $this->domParser->{$function}(...$params);
        }
    }
}