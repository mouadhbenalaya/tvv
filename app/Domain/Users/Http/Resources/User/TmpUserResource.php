<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class UserResource.
 *
 * @property int $id
 * @property string $email
 * @property string $validation_token
 * @property string $validated_at
 * @property ?bool $first_validation
 * @property int $user_type_id
 * @property ?int $user_id
 */
#[Schema(
    title: 'Tmp user resource',
    description: 'Tmp user resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'email',
            type: 'string',
            default: 'john.doe@q.agency',
        ),
        new Property(
            property: 'validation_token',
            type: 'string',
            example: 'YtHjLdzT4td9xyaTNCbDoW7XAdKYnGsZA6yvvpyWEKA090Yxc35clSgZJDaHirsO',
        ),
        new Property(
            property: 'validated_at',
            type: 'string',
            example: '2023-01-01',
        ),
        new Property(
            property: 'user_type_id',
            type: 'integer',
            example: 1,
        ),
        new Property(
            property: 'first_validation',
            type: 'boolean',
            example: false,
        ),
        new Property(
            property: 'user_exist',
            type: 'boolean',
            example: true,
        ),
    ],
    type: 'object'
)]
class TmpUserResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'validation_token' => $this->validation_token,
            'validated_at' => $this->validated_at,
            'user_type_id' => $this->user_type_id,
            'first_validation' => $this->first_validation !== null ? (bool)$this->first_validation : null,
            'user_exist' => $this->user_id !== null && $this->user_id !== false,
        ];
    }
}
