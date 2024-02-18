<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestTypes;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class RequestPermissionRoleResource.
 *
 * @property int $id
 * @property string $title
 * @property boolean $enabled
 */
#[Schema(
    title: 'RequestPermissionRoleResource resource',
    description: 'User resource',
    properties: [

        new Property(
            property: 'role_id',
            type: 'string',
        ),
        new Property(
            property: 'request_permission_id',
            type: 'string',
        ),

    ],
    type: 'object'
)]
class RequestPermissionRoleResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
           'id' => $this->id,
           'request_permission_id' => $this->request_permission_id,
           'title' => (\App::getLocale() == 'ar') ? $this->requestPermission->title_ar : $this->requestPermission->title_en ,
           'role_id' => $this->role_id,

        ];
    }
}
