<?php

declare(strict_types=1);

namespace App\Common\Http\Resources\Residency;

use App\Common\Helpers\TranslationHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class CityResource.
 *
 * @property int $id
 * @property string $code
 * @property string $name
 */
#[Schema(
    title: 'City resource',
    description: 'City resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'code',
            type: 'string',
            default: '0100',
        ),
        new Property(
            property: 'name',
            type: 'string',
            default: 'Riyadh',
        ),
        new Property(
            property: 'region',
            ref: '#/components/schemas/RegionResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class CityResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => TranslationHelper::translateOrFallback('city', $this->name),
            'region' => new RegionResource($this->whenLoaded('region'))
        ];
    }
}
