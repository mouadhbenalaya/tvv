<?php

declare(strict_types=1);

namespace App\Common\Rules;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\Rule;

use function __;
use function class_exists;

class ClassExists implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return class_exists($value);
    }

    /**
     * Get the validation error message.
     *
     * @return array|string|Translator|Application|null
     */
    public function message(): array|string|Translator|Application|null
    {
        return __('tags.validation.entity_fqcn.class_does_not_exist');
    }
}
