<?php

namespace App\Domain\Users\Http\Resources\Permission;

use App;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class PermissionResource.
 *
 * @property int $id
 * @property string $name
 * @property string $name_ar
 * @property string $permission_type
 * @property string $slug
 */
#[Schema(
    title: 'Permission resource',
    description: 'Permission resource',
    properties: [
        new Property(
            property: 'name',
            type: 'string',
            default: 'view_user',
        ),
        new Property(
            property: 'name_ar',
            type: 'string',
            default: 'view_user',
        ),
        new Property(
            property: 'slug',
            type: 'string',
            default: 'view-user',
        ),
    ],
    type: 'object'
)]
class PermissionResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
           'name' => App::getLocale() == 'ar' ? $this->name_ar : $this->name,
            'id' => (int)$this->id,
            //'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
