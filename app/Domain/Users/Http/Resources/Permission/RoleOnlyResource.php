<?php

namespace App\Domain\Users\Http\Resources\Permission;

use App\Domain\Users\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class RoleOnlyResource.
 *
 * @property int $id
 * @property string $name
 * @property string $name_ar
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
            property: 'slug',
            type: 'string',
            default: 'admin',
        ),
        new Property(
            property: 'description',
            type: 'string',
            example: 'list of role privileges',
        ),

    ],
    type: 'object'
)]
class RoleOnlyResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => App::getLocale() == 'ar' ? $this->name_ar : $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        //    'permissions' => PermissionResource::collection($this->permissions),
        ];
    }
}
