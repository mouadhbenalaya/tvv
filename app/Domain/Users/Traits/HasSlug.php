<?php

namespace App\Domain\Users\Traits;

use App\Domain\Users\Helpers\StringHelper;
use Spatie\Sluggable\SlugOptions;

trait HasSlug
{
    use \Spatie\Sluggable\HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function () {
                return StringHelper::convertCamelCaseToUnderscore($this->name);
            })
            ->saveSlugsTo('slug');
    }
}
