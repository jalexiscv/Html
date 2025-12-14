<?php

namespace Higgs\Language;

use Config\Services;
use MessageFormatter;

class Language
{
    protected $language = [];
    protected $locale;
    protected $intlSupport = false;
    protected $loadedFiles = [];

    public function __construct(string $locale)
    {
        $this->locale = $locale;
        if (class_exists(MessageFormatter::class)) {
            $this->intlSupport = true;
        }
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale = null)
    {
        if ($locale !== null) {
            $this->locale = $locale;
        }
        return $this;
    }

    public function getLine(string $line, array $args = [])
    {
        if (strpos($line, '.') === false) {
            return $this->formatMessage($line, $args);
        }
        [$file, $parsedLine] = $this->parseLine($line, $this->locale);
        $output = $this->getTranslationOutput($this->locale, $file, $parsedLine);
        if ($output === null && strpos($this->locale, '-')) {
            [$locale] = explode('-', $this->locale, 2);
            [$file, $parsedLine] = $this->parseLine($line, $locale);
            $output = $this->getTranslationOutput($locale, $file, $parsedLine);
        }
        if ($output === null) {
            [$file, $parsedLine] = $this->parseLine($line, 'en');
            $output = $this->getTranslationOutput('en', $file, $parsedLine);
        }
        $output ??= $line;
        return $this->formatMessage($output, $args);
    }

    protected function formatMessage($message, array $args = [])
    {
        if (!$this->intlSupport || $args === []) {
            return $message;
        }
        if (is_array($message)) {
            foreach ($message as $index => $value) {
                $message[$index] = $this->formatMessage($value, $args);
            }
            return $message;
        }
        return MessageFormatter::formatMessage($this->locale, $message, $args);
    }

    protected function parseLine(string $line, string $locale): array
    {
        $file = substr($line, 0, strpos($line, '.'));
        $line = substr($line, strlen($file) + 1);
        if (!isset($this->language[$locale][$file]) || !array_key_exists($line, $this->language[$locale][$file])) {
            $this->load($file, $locale);
        }
        return [$file, $line];
    }

    protected function load(string $file, string $locale, bool $return = false)
    {
        if (!array_key_exists($locale, $this->loadedFiles)) {
            $this->loadedFiles[$locale] = [];
        }
        if (in_array($file, $this->loadedFiles[$locale], true)) {
            return [];
        }
        if (!array_key_exists($locale, $this->language)) {
            $this->language[$locale] = [];
        }
        if (!array_key_exists($file, $this->language[$locale])) {
            $this->language[$locale][$file] = [];
        }
        $path = "Language/{$locale}/{$file}.php";
        $lang = $this->requireFile($path);
        if ($return) {
            return $lang;
        }
        $this->loadedFiles[$locale][] = $file;
        $this->language[$locale][$file] = $lang;
    }

    protected function requireFile(string $path): array
    {
        $files = Services::locator()->search($path, 'php', false);
        $strings = [];
        foreach ($files as $file) {
            if (is_file($file)) {
                $strings[] = require $file;
            }
        }
        if (isset($strings[1])) {
            $string = array_shift($strings);
            $strings = array_replace_recursive($string, ...$strings);
        } elseif (isset($strings[0])) {
            $strings = $strings[0];
        }
        return $strings;
    }

    protected function getTranslationOutput(string $locale, string $file, string $parsedLine)
    {
        $output = $this->language[$locale][$file][$parsedLine] ?? null;
        if ($output !== null) {
            return $output;
        }
        foreach (explode('.', $parsedLine) as $row) {
            if (!isset($current)) {
                $current = $this->language[$locale][$file] ?? null;
            }
            $output = $current[$row] ?? null;
            if (is_array($output)) {
                $current = $output;
            }
        }
        if ($output !== null) {
            return $output;
        }
        $row = current(explode('.', $parsedLine));
        $key = substr($parsedLine, strlen($row) + 1);
        return $this->language[$locale][$file][$row][$key] ?? null;
    }
}