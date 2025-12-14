<?php

namespace Higgs\API;

use Higgs\Format\FormatterInterface;
use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\ResponseInterface;
use Config\Services;

trait ResponseTrait
{
    protected $codes = ['created' => 201, 'deleted' => 200, 'updated' => 200, 'no_content' => 204, 'invalid_request' => 400, 'unsupported_response_type' => 400, 'invalid_scope' => 400, 'temporarily_unavailable' => 400, 'invalid_grant' => 400, 'invalid_credentials' => 400, 'invalid_refresh' => 400, 'no_data' => 400, 'invalid_data' => 400, 'access_denied' => 401, 'unauthorized' => 401, 'invalid_client' => 401, 'forbidden' => 403, 'resource_not_found' => 404, 'not_acceptable' => 406, 'resource_exists' => 409, 'conflict' => 409, 'resource_gone' => 410, 'payload_too_large' => 413, 'unsupported_media_type' => 415, 'too_many_requests' => 429, 'server_error' => 500, 'unsupported_grant_type' => 501, 'not_implemented' => 501,];
    protected $format = 'json';
    protected $formatter;

    protected function respondCreated($data = null, string $message = '')
    {
        return $this->respond($data, $this->codes['created'], $message);
    }

    protected function respond($data = null, ?int $status = null, string $message = '')
    {
        if ($data === null && $status === null) {
            $status = 404;
            $output = null;
        } elseif ($data === null && is_numeric($status)) {
            $output = null;
        } else {
            $status = empty($status) ? 200 : $status;
            $output = $this->format($data);
        }
        if ($output !== null) {
            if ($this->format === 'json') {
                return $this->response->setJSON($output)->setStatusCode($status, $message);
            }
            if ($this->format === 'xml') {
                return $this->response->setXML($output)->setStatusCode($status, $message);
            }
        }
        return $this->response->setBody($output)->setStatusCode($status, $message);
    }

    protected function format($data = null)
    {
        if (is_string($data)) {
            $contentType = $this->response->getHeaderLine('Content-Type');
            $contentType = str_replace('application/json', 'text/html', $contentType);
            $contentType = str_replace('application/', 'text/', $contentType);
            $this->response->setContentType($contentType);
            $this->format = 'html';
            return $data;
        }
        $format = Services::format();
        $mime = "application/{$this->format}";
        if ((empty($this->format) || !in_array($this->format, ['json', 'xml'], true)) && $this->request instanceof IncomingRequest) {
            $mime = $this->request->negotiate('media', $format->getConfig()->supportedResponseFormats, false);
        }
        $this->response->setContentType($mime);
        if (!isset($this->formatter)) {
            $this->formatter = $format->getFormatter($mime);
        }
        if ($mime !== 'application/json') {
            $data = json_decode(json_encode($data), true);
        }
        return $this->formatter->format($data);
    }

    protected function respondDeleted($data = null, string $message = '')
    {
        return $this->respond($data, $this->codes['deleted'], $message);
    }

    protected function respondUpdated($data = null, string $message = '')
    {
        return $this->respond($data, $this->codes['updated'], $message);
    }

    protected function respondNoContent(string $message = 'No Content')
    {
        return $this->respond(null, $this->codes['no_content'], $message);
    }

    protected function failUnauthorized(string $description = 'Unauthorized', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['unauthorized'], $code, $message);
    }

    protected function fail($messages, int $status = 400, ?string $code = null, string $customMessage = '')
    {
        if (!is_array($messages)) {
            $messages = ['error' => $messages];
        }
        $response = ['status' => $status, 'error' => $code ?? $status, 'messages' => $messages,];
        return $this->respond($response, $status, $customMessage);
    }

    protected function failForbidden(string $description = 'Forbidden', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['forbidden'], $code, $message);
    }

    protected function failNotFound(string $description = 'Not Found', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['resource_not_found'], $code, $message);
    }

    protected function failValidationError(string $description = 'Bad Request', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['invalid_data'], $code, $message);
    }

    protected function failValidationErrors($errors, ?string $code = null, string $message = '')
    {
        return $this->fail($errors, $this->codes['invalid_data'], $code, $message);
    }

    protected function failResourceExists(string $description = 'Conflict', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['resource_exists'], $code, $message);
    }

    protected function failResourceGone(string $description = 'Gone', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['resource_gone'], $code, $message);
    }

    protected function failTooManyRequests(string $description = 'Too Many Requests', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['too_many_requests'], $code, $message);
    }

    protected function failServerError(string $description = 'Internal Server Error', ?string $code = null, string $message = ''): ResponseInterface
    {
        return $this->fail($description, $this->codes['server_error'], $code, $message);
    }

    protected function setResponseFormat(?string $format = null)
    {
        $this->format = strtolower($format);
        return $this;
    }
}