<?php

namespace Higgs\Test;
final class PhpStreamWrapper
{
    private static string $content = '';
    public $context;
    private int $position = 0;

    public static function setContent(string $content)
    {
        self::$content = $content;
    }

    public static function register()
    {
        stream_wrapper_unregister('php');
        stream_wrapper_register('php', self::class);
    }

    public static function restore()
    {
        stream_wrapper_restore('php');
    }

    public function stream_open(string $path): bool
    {
        return true;
    }

    public function stream_read(int $count)
    {
        $return = substr(self::$content, $this->position, $count);
        $this->position += strlen($return);
        return $return;
    }

    public function stream_stat()
    {
        return [];
    }

    public function stream_eof(): bool
    {
        return $this->position >= strlen(self::$content);
    }
}