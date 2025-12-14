<?php

namespace Higgs\Encryption;

use Higgs\Encryption\Exceptions\EncryptionException;

interface EncrypterInterface
{
    public function encrypt($data, $params = null);

    public function decrypt($data, $params = null);
}