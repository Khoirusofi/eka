<?php

namespace App\Translation;

use Illuminate\Support\Arr;
use Illuminate\Translation\Translator as BaseTranslator;

class Translator extends BaseTranslator
{
    /**
     * @param $key
     * @param array $replace
     * @param $locale
     * @param $fallback
     *
     * @return array|string|null
     */
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $results = parent::get($key, $replace, $locale, $fallback);

        if (!str_contains($key, '.') || $results !== $key) {
            return $results;
        }

        $locale = $locale ?: $this->locale;
        $line = Arr::get($this->loaded['*']['*'][$locale], $key);

        return $this->makeReplacements($line ?: $key, $replace);
    }
}
