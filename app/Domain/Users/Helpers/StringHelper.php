<?php

namespace App\Domain\Users\Helpers;

class StringHelper
{
    public static function convertCamelCaseToUnderscore(string $text): string
    {
        return strtolower((string)preg_replace('/([a-z])([A-Z])/', '$1_$2', $text));
    }
}
