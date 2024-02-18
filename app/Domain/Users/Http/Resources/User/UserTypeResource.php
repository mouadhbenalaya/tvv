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
 * @property string $name
 * @property string $label
 * @property string $slug
 * @property boolean $can_register
 */
#[Schema(
    title: 'User resource',
    description: 'User resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'name',
            type: 'string',
            default: 'EstablishmentOperator',
        ),
        new Property(
            property: 'slug',
            type: 'string',
            default: 'establishment-operator',
        ),
        new Property(
            property: 'label',
            type: 'string',
            default: 'Establishment Operator',
        ),
        new Property(
            property: 'can_register',
            type: 'boolean',
            default: true,
        ),
    ],
    type: 'object'
)]
class UserTypeResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'label' => __('user_type.'.$this->name),
            'can_register' => (bool)$this->can_register,
        ];
    }
}
