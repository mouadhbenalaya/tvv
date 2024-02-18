<?php

declare(strict_types=1);

namespace App\Common\Http\Resources\Residency;

use App\Common\Helpers\TranslationHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class RegionResource.
 *
 * @property int $id
 * @property string $code
 * @property string $name
 */
#[Schema(
    title: 'Region resource',
    description: 'Region resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'code',
            type: 'string',
            default: '0001',
        ),
        new Property(
            property: 'name',
            type: 'string',
            default: 'Riyadh Region',
        ),
        new Property(
            property: 'cities',
            ref: '#/components/schemas/CityResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class RegionResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => TranslationHelper::translateOrFallback('region', $this->name),
            'cities' => CityResource::collection($this->whenLoaded('cities'))
        ];
    }
}
