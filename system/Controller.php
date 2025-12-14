<?php

namespace Higgs;

use Higgs\HTTP\Exceptions\HTTPException;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use Higgs\Validation\Exceptions\ValidationException;
use Higgs\Validation\ValidationInterface;
use Config\Services;
use Psr\Log\LoggerInterface;

class Controller
{
    protected $helpers = [];
    protected $request;
    protected $response;
    protected $logger;
    protected $forceHTTPS = 0;
    protected $validator;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->request = $request;
        $this->response = $response;
        $this->logger = $logger;
        if ($this->forceHTTPS > 0) {
            $this->forceHTTPS($this->forceHTTPS);
        }
        helper($this->helpers);
    }

    protected function forceHTTPS(int $duration = 31_536_000)
    {
        force_https($duration, $this->request, $this->response);
    }

    protected function cachePage(int $time)
    {
        Higgs::cache($time);
    }

    protected function loadHelpers()
    {
        if (empty($this->helpers)) {
            return;
        }
        helper($this->helpers);
    }

    protected function validate($rules, array $messages = []): bool
    {
        $this->setValidator($rules, $messages);
        return $this->validator->withRequest($this->request)->run();
    }

    private function setValidator($rules, array $messages): void
    {
        $this->validator = Services::validation();
        if (is_string($rules)) {
            $validation = config('Validation');
            if (!isset($validation->{$rules})) {
                throw ValidationException::forRuleNotFound($rules);
            }
            if (!$messages) {
                $errorName = $rules . '_errors';
                $messages = $validation->{$errorName} ?? [];
            }
            $rules = $validation->{$rules};
        }
        $this->validator->setRules($rules, $messages);
    }

    protected function validateData(array $data, $rules, array $messages = [], ?string $dbGroup = null): bool
    {
        $this->setValidator($rules, $messages);
        return $this->validator->run($data, null, $dbGroup);
    }
}