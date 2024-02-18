<?php

namespace App\Domain\Users\Http\Resources\Permission;

use App;
use App\Domain\Requests\Http\Resources\RequestTypes\RequestPermissionRoleResource;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class UserResource.
 *
 * @property int $id
 * @property string $name
 * @property string $name_ar
 * @property string $user_type_id
 * @property string $department_id
 * @property string $slug
 * @property string $description
 * @property Collection $permissions
 * @method Profile|null currentProfile()
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
            default: 'Admin',
        ),
        new Property(
            property: 'name_ar',
            type: 'string',
            default: 'Admin',
        ),
        new Property(
            property: 'user_type_id',
            type: 'integer',
            default: '1',
        ),
        new Property(
            property: 'department_id',
            type: 'integer',
            default: '1',
        ),
        new Property(
            property: 'slug',
            type: 'string',
            default: 'admin',
        ),
        new Property(
            property: 'description',
            type: 'string',
            example: 'list of role privileges',
        ),
        new Property(
            property: 'permissions',
            ref: '#/components/schemas/PermissionResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class RoleResourceByPermissionObjects extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_ar' => $this->name_ar,
            'user_type' => $this->user_type_id,
            'department_id' => $this->department_id,
            'slug' => $this->slug,
            'description' => $this->description,
            'permissions' => PermissionResource::collection($this->permissions),
            'service_permissions' =>  $this->requestPermissionRoles !==  null
                ? RequestPermissionRoleResource::collection($this->requestPermissionRoles)
                : [],
        ];
    }
}
