<?php

namespace App\Common\Helpers;

class TranslationHelper
{
    public static function translateOrFallback(string $key, string $value): string
    {
        $translation = trans(sprintf('%s.%s', $key, $value), ['attribute' => $value]);

        return $translation !== sprintf('%s.%s', $key, $value) ? $translation : $value;
    }
}
