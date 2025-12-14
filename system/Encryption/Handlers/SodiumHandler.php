<?php

namespace Higgs\Encryption\Handlers;

use Higgs\Encryption\Exceptions\EncryptionException;

class SodiumHandler extends BaseHandler
{
    protected $key = '';
    protected $blockSize = 16;

    public function encrypt($data, $params = null)
    {
        $this->parseParams($params);
        if (empty($this->key)) {
            throw EncryptionException::forNeedsStarterKey();
        }
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        if ($this->blockSize <= 0) {
            throw EncryptionException::forEncryptionFailed();
        }
        $data = sodium_pad($data, $this->blockSize);
        $ciphertext = $nonce . sodium_crypto_secretbox($data, $nonce, $this->key);
        sodium_memzero($data);
        sodium_memzero($this->key);
        return $ciphertext;
    }

    protected function parseParams($params)
    {
        if ($params === null) {
            return;
        }
        if (is_array($params)) {
            if (isset($params['key'])) {
                $this->key = $params['key'];
            }
            if (isset($params['blockSize'])) {
                $this->blockSize = $params['blockSize'];
            }
            return;
        }
        $this->key = (string)$params;
    }

    public function decrypt($data, $params = null)
    {
        $this->parseParams($params);
        if (empty($this->key)) {
            throw EncryptionException::forNeedsStarterKey();
        }
        if (mb_strlen($data, '8bit') < (SODIUM_CRYPTO_SECRETBOX_NONCEBYTES + SODIUM_CRYPTO_SECRETBOX_MACBYTES)) {
            throw EncryptionException::forAuthenticationFailed();
        }
        $nonce = self::substr($data, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $ciphertext = self::substr($data, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $data = sodium_crypto_secretbox_open($ciphertext, $nonce, $this->key);
        if ($data === false) {
            throw EncryptionException::forAuthenticationFailed();
        }
        if ($this->blockSize <= 0) {
            throw EncryptionException::forAuthenticationFailed();
        }
        $data = sodium_unpad($data, $this->blockSize);
        sodium_memzero($ciphertext);
        sodium_memzero($this->key);
        return $data;
    }
}