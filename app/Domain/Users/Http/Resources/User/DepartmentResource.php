<?php

namespace App\Domain\Users\Http\Resources\User;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class DepartmentResource.
 *
 * @property int $id
 * @property string $name
 * @property Collection $profiles
 */
#[Schema(
    title: 'Role resource',
    description: 'Role resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'name',
            type: 'string',
            default: 'Security Operations',
        ),
        new Property(
            property: 'profiles',
            ref: '#/components/schemas/ProfileResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class DepartmentResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'profiles' => ProfileResource::collection($this->profiles ?? []),
        ];
    }
}
