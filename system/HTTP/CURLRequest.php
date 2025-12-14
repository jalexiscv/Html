<?php

namespace Higgs\HTTP;

use Higgs\HTTP\Exceptions\HTTPException;
use Config\App;
use Config\CURLRequest as ConfigCURLRequest;
use InvalidArgumentException;

class CURLRequest extends OutgoingRequest
{
    protected $response;
    protected $baseURI;
    protected $config;
    protected $defaultConfig = ['timeout' => 0.0, 'connect_timeout' => 150, 'debug' => false, 'verify' => true,];
    protected $redirectDefaults = ['max' => 5, 'strict' => true, 'protocols' => ['http', 'https',],];
    protected $delay = 0.0;
    private array $defaultOptions;
    private bool $shareOptions;

    public function __construct(App $config, URI $uri, ?ResponseInterface $response = null, array $options = [])
    {
        if (!function_exists('curl_version')) {
            throw HTTPException::forMissingCurl();
        }
        parent::__construct('GET', $uri);
        $this->response = $response;
        $this->baseURI = $uri->useRawQueryString();
        $this->defaultOptions = $options;
        $configCURLRequest = config('CURLRequest');
        $this->shareOptions = $configCURLRequest->shareOptions ?? true;
        $this->config = $this->defaultConfig;
        $this->parseOptions($options);
    }

    protected function parseOptions(array $options)
    {
        if (array_key_exists('baseURI', $options)) {
            $this->baseURI = $this->baseURI->setURI($options['baseURI']);
            unset($options['baseURI']);
        }
        if (array_key_exists('headers', $options) && is_array($options['headers'])) {
            foreach ($options['headers'] as $name => $value) {
                $this->setHeader($name, $value);
            }
            unset($options['headers']);
        }
        if (array_key_exists('delay', $options)) {
            $this->delay = (float)$options['delay'] / 1000;
            unset($options['delay']);
        }
        if (array_key_exists('body', $options)) {
            $this->setBody($options['body']);
            unset($options['body']);
        }
        foreach ($options as $key => $value) {
            $this->config[$key] = $value;
        }
    }

    public function get(string $url, array $options = []): ResponseInterface
    {
        return $this->request('get', $url, $options);
    }

    public function request($method, string $url, array $options = []): ResponseInterface
    {
        $this->parseOptions($options);
        $url = $this->prepareURL($url);
        $method = esc(strip_tags($method));
        $this->send($method, $url);
        if ($this->shareOptions === false) {
            $this->resetOptions();
        }
        return $this->response;
    }

    protected function prepareURL(string $url): string
    {
        if (strpos($url, '://') !== false) {
            return $url;
        }
        $uri = $this->baseURI->resolveRelativeURI($url);
        return URI::createURIString($uri->getScheme(), $uri->getAuthority(), $uri->getPath(), $uri->getQuery(), $uri->getFragment());
    }

    public function send(string $method, string $url)
    {
        $curlOptions = [];
        if (!empty($this->config['query']) && is_array($this->config['query'])) {
            $url .= '?' . http_build_query($this->config['query']);
            unset($this->config['query']);
        }
        $curlOptions[CURLOPT_URL] = $url;
        $curlOptions[CURLOPT_RETURNTRANSFER] = true;
        $curlOptions[CURLOPT_HEADER] = true;
        $curlOptions[CURLOPT_FRESH_CONNECT] = true;
        $curlOptions[CURLOPT_SAFE_UPLOAD] = true;
        $curlOptions = $this->setCURLOptions($curlOptions, $this->config);
        $curlOptions = $this->applyMethod($method, $curlOptions);
        $curlOptions = $this->applyRequestHeaders($curlOptions);
        if ($this->delay > 0) {
            usleep((int)$this->delay * 1_000_000);
        }
        $output = $this->sendRequest($curlOptions);
        $breakString = "\r\n\r\n";
        if (strpos($output, 'HTTP/1.1 100 Continue') === 0) {
            $output = substr($output, strpos($output, $breakString) + 4);
        }
        if (isset($this->config['auth'][2]) && $this->config['auth'][2] === 'digest' && strpos($output, 'WWW-Authenticate: Digest') !== false) {
            $output = substr($output, strpos($output, $breakString) + 4);
        }
        $break = strpos($output, $breakString);
        if ($break !== false) {
            $headers = explode("\n", substr($output, 0, $break));
            $this->setResponseHeaders($headers);
            $body = substr($output, $break + 4);
            $this->response->setBody($body);
        } else {
            $this->response->setBody($output);
        }
        return $this->response;
    }

    protected function setCURLOptions(array $curlOptions = [], array $config = [])
    {
        if (!empty($config['auth'])) {
            $curlOptions[CURLOPT_USERPWD] = $config['auth'][0] . ':' . $config['auth'][1];
            if (!empty($config['auth'][2]) && strtolower($config['auth'][2]) === 'digest') {
                $curlOptions[CURLOPT_HTTPAUTH] = CURLAUTH_DIGEST;
            } else {
                $curlOptions[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
            }
        }
        if (!empty($config['cert'])) {
            $cert = $config['cert'];
            if (is_array($cert)) {
                $curlOptions[CURLOPT_SSLCERTPASSWD] = $cert[1];
                $cert = $cert[0];
            }
            if (!is_file($cert)) {
                throw HTTPException::forSSLCertNotFound($cert);
            }
            $curlOptions[CURLOPT_SSLCERT] = $cert;
        }
        if (isset($config['verify'])) {
            if (is_string($config['verify'])) {
                $file = realpath($config['ssl_key']) ?: $config['ssl_key'];
                if (!is_file($file)) {
                    throw HTTPException::forInvalidSSLKey($config['ssl_key']);
                }
                $curlOptions[CURLOPT_CAINFO] = $file;
                $curlOptions[CURLOPT_SSL_VERIFYPEER] = 1;
            } elseif (is_bool($config['verify'])) {
                $curlOptions[CURLOPT_SSL_VERIFYPEER] = $config['verify'];
            }
        }
        if ($config['debug']) {
            $curlOptions[CURLOPT_VERBOSE] = 1;
            $curlOptions[CURLOPT_STDERR] = is_string($config['debug']) ? fopen($config['debug'], 'a+b') : fopen('php://stderr', 'wb');
        }
        if (!empty($config['decode_content'])) {
            $accept = $this->getHeaderLine('Accept-Encoding');
            if ($accept) {
                $curlOptions[CURLOPT_ENCODING] = $accept;
            } else {
                $curlOptions[CURLOPT_ENCODING] = '';
                $curlOptions[CURLOPT_HTTPHEADER] = 'Accept-Encoding';
            }
        }
        if (array_key_exists('allow_redirects', $config)) {
            $settings = $this->redirectDefaults;
            if (is_array($config['allow_redirects'])) {
                $settings = array_merge($settings, $config['allow_redirects']);
            }
            if ($config['allow_redirects'] === false) {
                $curlOptions[CURLOPT_FOLLOWLOCATION] = 0;
            } else {
                $curlOptions[CURLOPT_FOLLOWLOCATION] = 1;
                $curlOptions[CURLOPT_MAXREDIRS] = $settings['max'];
                if ($settings['strict'] === true) {
                    $curlOptions[CURLOPT_POSTREDIR] = 1 | 2 | 4;
                }
                $protocols = 0;
                foreach ($settings['protocols'] as $proto) {
                    $protocols += constant('CURLPROTO_' . strtoupper($proto));
                }
                $curlOptions[CURLOPT_REDIR_PROTOCOLS] = $protocols;
            }
        }
        $curlOptions[CURLOPT_TIMEOUT_MS] = (float)$config['timeout'] * 1000;
        $curlOptions[CURLOPT_CONNECTTIMEOUT_MS] = (float)$config['connect_timeout'] * 1000;
        if (!empty($config['form_params']) && is_array($config['form_params'])) {
            $postFields = http_build_query($config['form_params']);
            $curlOptions[CURLOPT_POSTFIELDS] = $postFields;
            $this->setHeader('Content-Length', (string)strlen($postFields));
            $this->setHeader('Content-Type', 'application/x-www-form-urlencoded');
        }
        if (!empty($config['multipart']) && is_array($config['multipart'])) {
            $curlOptions[CURLOPT_POSTFIELDS] = $config['multipart'];
        }
        $curlOptions[CURLOPT_FAILONERROR] = array_key_exists('http_errors', $config) ? (bool)$config['http_errors'] : true;
        if (isset($config['json'])) {
            $json = json_encode($config['json']);
            $this->setBody($json);
            $this->setHeader('Content-Type', 'application/json');
            $this->setHeader('Content-Length', (string)strlen($json));
        }
        if (!empty($config['version'])) {
            if ($config['version'] === 1.0) {
                $curlOptions[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_0;
            } elseif ($config['version'] === 1.1) {
                $curlOptions[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
            } elseif ($config['version'] === 2.0) {
                $curlOptions[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_2_0;
            }
        }
        if (isset($config['cookie'])) {
            $curlOptions[CURLOPT_COOKIEJAR] = $config['cookie'];
            $curlOptions[CURLOPT_COOKIEFILE] = $config['cookie'];
        }
        if (isset($config['user_agent'])) {
            $curlOptions[CURLOPT_USERAGENT] = $config['user_agent'];
        }
        return $curlOptions;
    }

    protected function applyMethod(string $method, array $curlOptions): array
    {
        $method = strtoupper($method);
        $this->method = $method;
        $curlOptions[CURLOPT_CUSTOMREQUEST] = $method;
        $size = strlen($this->body ?? '');
        if ($size > 0) {
            return $this->applyBody($curlOptions);
        }
        if ($method === 'PUT' || $method === 'POST') {
            if ($this->header('content-length') === null && !isset($this->config['multipart'])) {
                $this->setHeader('Content-Length', '0');
            }
        } elseif ($method === 'HEAD') {
            $curlOptions[CURLOPT_NOBODY] = 1;
        }
        return $curlOptions;
    }

    protected function applyBody(array $curlOptions = []): array
    {
        if (!empty($this->body)) {
            $curlOptions[CURLOPT_POSTFIELDS] = (string)$this->getBody();
        }
        return $curlOptions;
    }

    protected function applyRequestHeaders(array $curlOptions = []): array
    {
        if (empty($this->headers)) {
            return $curlOptions;
        }
        $set = [];
        foreach (array_keys($this->headers) as $name) {
            $set[] = $name . ': ' . $this->getHeaderLine($name);
        }
        $curlOptions[CURLOPT_HTTPHEADER] = $set;
        return $curlOptions;
    }

    protected function sendRequest(array $curlOptions = []): string
    {
        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);
        $output = curl_exec($ch);
        if ($output === false) {
            throw HTTPException::forCurlError((string)curl_errno($ch), curl_error($ch));
        }
        curl_close($ch);
        return $output;
    }

    protected function setResponseHeaders(array $headers = [])
    {
        foreach ($headers as $header) {
            if (($pos = strpos($header, ':')) !== false) {
                $title = substr($header, 0, $pos);
                $value = substr($header, $pos + 1);
                $this->response->setHeader($title, $value);
            } elseif (strpos($header, 'HTTP') === 0) {
                preg_match('#^HTTP\/([12](?:\.[01])?) (\d+) (.+)#', $header, $matches);
                if (isset($matches[1])) {
                    $this->response->setProtocolVersion($matches[1]);
                }
                if (isset($matches[2])) {
                    $this->response->setStatusCode((int)$matches[2], $matches[3] ?? null);
                }
            }
        }
    }

    protected function resetOptions()
    {
        $this->headers = [];
        $this->headerMap = [];
        $this->body = null;
        $this->config = $this->defaultConfig;
        $this->parseOptions($this->defaultOptions);
    }

    public function delete(string $url, array $options = []): ResponseInterface
    {
        return $this->request('delete', $url, $options);
    }

    public function head(string $url, array $options = []): ResponseInterface
    {
        return $this->request('head', $url, $options);
    }

    public function options(string $url, array $options = []): ResponseInterface
    {
        return $this->request('options', $url, $options);
    }

    public function patch(string $url, array $options = []): ResponseInterface
    {
        return $this->request('patch', $url, $options);
    }

    public function post(string $url, array $options = []): ResponseInterface
    {
        return $this->request('post', $url, $options);
    }

    public function put(string $url, array $options = []): ResponseInterface
    {
        return $this->request('put', $url, $options);
    }

    public function setAuth(string $username, string $password, string $type = 'basic')
    {
        $this->config['auth'] = [$username, $password, $type,];
        return $this;
    }

    public function setForm(array $params, bool $multipart = false)
    {
        if ($multipart) {
            $this->config['multipart'] = $params;
        } else {
            $this->config['form_params'] = $params;
        }
        return $this;
    }

    public function setJSON($data)
    {
        $this->config['json'] = $data;
        return $this;
    }

    public function getMethod(bool $upper = false): string
    {
        return ($upper) ? strtoupper($this->method) : strtolower($this->method);
    }
}