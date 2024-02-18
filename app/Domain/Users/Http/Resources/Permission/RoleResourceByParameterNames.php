<?php

namespace App\Domain\Users\Http\Resources\Permission;

use App;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\Role;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
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
class RoleResourceByParameterNames extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => App::getLocale() == 'ar' ? $this->name_ar : $this->name,
            'user_type' => $this->user_type_id ? $this->getUserTypeName() : null,
            'department_owner' => $this->department_id ? User::findOrFail($this->department_id)->getFullNameAttribute() : null,
            'slug' => $this->slug,
            'description' => $this->description,
            'permissions' => PermissionResource::collection($this->permissions)->count(),
            'service_permissions' =>  $this->requestPermissionRoles !==  null ? $this->requestPermissionRoles->count() : 0,
        ];
    }

    public function getUserTypeName(): ?string
    {
        if (App::getLocale() == 'ar') {
            return UserType::findOrFail($this->user_type_id)->name_ar;
        }

        return UserType::findOrFail($this->user_type_id)->name;
    }
}
