<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Resources\Gender;

use App\Common\Helpers\TranslationHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class GenderResource.
 */
#[Schema(
    title: 'User resource',
    description: 'User resource',
    properties: [
        new Property(
            property: 'key',
            type: 'string',
            default: 'm',
        ),
        new Property(
            property: 'label',
            type: 'string',
            default: 'Male',
        ),
    ],
    type: 'object'
)]
class GenderResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'key' => $this->resource,
            'label' => TranslationHelper::translateOrFallback('gender', $this->resource),
        ];
    }
}
