<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Resources\User;

use App\Domain\Users\Http\Resources\Permission\RoleResource;
use App\Domain\Users\Models\UserType;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class ProfileResource.
 *
 * @property int $id
 * @property string $employee_number
 * @property string $ad_user_name
 * @property int $department_id
 * @property int $facility_id
 * @property UserType $userType
 */
#[Schema(
    title: 'Profile resource',
    description: 'Profile resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'employee_number',
            type: 'string',
            default: '123',
        ),
        new Property(
            property: 'ad_user_name',
            type: 'string',
            example: 'username',
        ),
        new Property(
            property: 'department_id',
            type: 'int',
            example: '12345',
        ),
        new Property(
            property: 'facility_id',
            type: 'int',
            default: '12345',
        ),
        new Property(
            property: 'user_type',
            ref: '#/components/schemas/UserTypeResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class ProfileResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'employee_number' => $this->employee_number,
            'ad_user_name' => $this->ad_user_name,
            'department_id' => $this->department_id,
            'facility_id' => $this->facility_id,
            'user_type' => new UserTypeResource($this->userType),
            'roles' => RoleResource::collection($this->whenLoaded('roles'))
        ];
    }
}
