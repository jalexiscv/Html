<?php

namespace MongoDB\Operation;

use Exception;
use MongoDB\Driver\Exception\RuntimeException;
use MongoDB\Driver\Session;
use Throwable;
use function call_user_func;
use function time;

class WithTransaction
{
    private $callback;
    private $transactionOptions;

    public function __construct(callable $callback, array $transactionOptions = [])
    {
        $this->callback = $callback;
        $this->transactionOptions = $transactionOptions;
    }

    public function execute(Session $session): void
    {
        $startTime = time();
        while (true) {
            $session->startTransaction($this->transactionOptions);
            try {
                call_user_func($this->callback, $session);
            } catch (Throwable $e) {
                if ($session->isInTransaction()) {
                    $session->abortTransaction();
                }
                if ($e instanceof RuntimeException && $e->hasErrorLabel('TransientTransactionError') && !$this->isTransactionTimeLimitExceeded($startTime)) {
                    continue;
                }
                throw $e;
            }
            if (!$session->isInTransaction()) {
                return;
            }
            while (true) {
                try {
                    $session->commitTransaction();
                } catch (RuntimeException $e) {
                    if ($e->getCode() !== 50 && $e->hasErrorLabel('UnknownTransactionCommitResult') && !$this->isTransactionTimeLimitExceeded($startTime)) {
                        continue;
                    }
                    if ($e->hasErrorLabel('TransientTransactionError') && !$this->isTransactionTimeLimitExceeded($startTime)) {
                        continue 2;
                    }
                    throw $e;
                }
                break;
            }
            break;
        }
    }

    private function isTransactionTimeLimitExceeded(int $startTime): bool
    {
        return time() - $startTime >= 120;
    }
}