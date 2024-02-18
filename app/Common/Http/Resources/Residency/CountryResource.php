<?php

declare(strict_types=1);

namespace App\Common\Http\Resources\Residency;

use App\Common\Helpers\TranslationHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class UserResource.
 *
 * @property int $id
 * @property string $code_alpha_2
 * @property string $code_alpha_3
 * @property string $code_numeric
 * @property string $name
 */
#[Schema(
    title: 'Country resource',
    description: 'Country resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'code_alpha_2',
            type: 'string',
            default: 'SA',
        ),
        new Property(
            property: 'code_alpha_3',
            type: 'string',
            example: 'SAU',
        ),
        new Property(
            property: 'code_numeric',
            type: 'integer',
            example: 682,
        ),
        new Property(
            property: 'name',
            type: 'string',
            default: 'Saudi Arabia',
        ),
    ],
    type: 'object'
)]
class CountryResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code_alpha_2' => $this->code_alpha_2,
            'code_alpha_3' => $this->code_alpha_3,
            'code_numeric' => $this->code_numeric,
            'name' => TranslationHelper::translateOrFallback('country', $this->name),
        ];
    }
}
