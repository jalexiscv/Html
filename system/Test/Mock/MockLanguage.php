<?php

namespace Higgs\Test\Mock;

use Higgs\Language\Language;

class MockLanguage extends Language
{
    protected $data;

    public function setData(string $file, array $data, ?string $locale = null)
    {
        $this->language[$locale ?? $this->locale][$file] = $data;
        return $this;
    }

    public function disableIntlSupport()
    {
        $this->intlSupport = false;
    }

    protected function requireFile(string $path): array
    {
        return $this->data ?? [];
    }
}