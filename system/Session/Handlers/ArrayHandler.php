<?php

namespace Higgs\Session\Handlers;

use ReturnTypeWillChange;

class ArrayHandler extends BaseHandler
{
    protected static $cache = [];

    public function open($path, $name): bool
    {
        return true;
    }

    #[ReturnTypeWillChange] public function read($id)
    {
        return '';
    }

    public function write($id, $data): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function destroy($id): bool
    {
        return true;
    }

    #[ReturnTypeWillChange] public function gc($max_lifetime)
    {
        return 1;
    }
}