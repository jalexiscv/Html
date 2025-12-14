<?php

namespace Twilio;

use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\Response;
use function is_array;
use function min;
use function trim;

abstract class Version
{
    public const MAX_PAGE_SIZE = 1000;
    protected $domain;
    protected $version;

    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
        $this->version = null;
    }

    public function absoluteUrl(string $uri): string
    {
        return $this->getDomain()->absoluteUrl($this->relativeUri($uri));
    }

    public function relativeUri(string $uri): string
    {
        return trim($this->version, '/') . '/' . trim($uri, '/');
    }

    public function request(string $method, string $uri, array $params = [], array $data = [], array $headers = [], string $username = null, string $password = null, int $timeout = null): Response
    {
        $uri = $this->relativeUri($uri);
        return $this->getDomain()->request($method, $uri, $params, $data, $headers, $username, $password, $timeout);
    }

    protected function exception(Response $response, string $header): TwilioException
    {
        $message = '[HTTP ' . $response->getStatusCode() . '] ' . $header;
        $content = $response->getContent();
        if (is_array($content)) {
            $message .= isset($content['message']) ? ': ' . $content['message'] : '';
            $code = isset($content['code']) ? $content['code'] : $response->getStatusCode();
            $moreInfo = $content['more_info'] ?? '';
            $details = $content['details'] ?? [];
            return new RestException($message, $code, $response->getStatusCode(), $moreInfo, $details);
        }
        return new RestException($message, $response->getStatusCode(), $response->getStatusCode());
    }

    public function fetch(string $method, string $uri, array $params = [], array $data = [], array $headers = [], string $username = null, string $password = null, int $timeout = null)
    {
        $response = $this->request($method, $uri, $params, $data, $headers, $username, $password, $timeout);
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 400) {
            throw $this->exception($response, 'Unable to fetch record');
        }
        return $response->getContent();
    }

    public function update(string $method, string $uri, array $params = [], array $data = [], array $headers = [], string $username = null, string $password = null, int $timeout = null)
    {
        $response = $this->request($method, $uri, $params, $data, $headers, $username, $password, $timeout);
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw $this->exception($response, 'Unable to update record');
        }
        return $response->getContent();
    }

    public function delete(string $method, string $uri, array $params = [], array $data = [], array $headers = [], string $username = null, string $password = null, int $timeout = null): bool
    {
        $response = $this->request($method, $uri, $params, $data, $headers, $username, $password, $timeout);
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw $this->exception($response, 'Unable to delete record');
        }
        return $response->getStatusCode() === 204;
    }

    public function readLimits(int $limit = null, int $pageSize = null): array
    {
        if ($limit && $pageSize === null) {
            $pageSize = $limit;
        }
        $pageSize = min($pageSize, self::MAX_PAGE_SIZE);
        return ['limit' => $limit ?: Values::NONE, 'pageSize' => $pageSize ?: Values::NONE, 'pageLimit' => Values::NONE,];
    }

    public function page(string $method, string $uri, array $params = [], array $data = [], array $headers = [], string $username = null, string $password = null, int $timeout = null): Response
    {
        return $this->request($method, $uri, $params, $data, $headers, $username, $password, $timeout);
    }

    public function stream(Page $page, $limit = null, $pageLimit = null): Stream
    {
        return new Stream($page, $limit, $pageLimit);
    }

    public function create(string $method, string $uri, array $params = [], array $data = [], array $headers = [], string $username = null, string $password = null, int $timeout = null)
    {
        $response = $this->request($method, $uri, $params, $data, $headers, $username, $password, $timeout);
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw $this->exception($response, 'Unable to create record');
        }
        return $response->getContent();
    }

    public function getDomain(): Domain
    {
        return $this->domain;
    }

    public function __toString(): string
    {
        return '[Version]';
    }
}