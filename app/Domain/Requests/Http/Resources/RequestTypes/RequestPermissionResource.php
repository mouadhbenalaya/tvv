<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestTypes;

use App\Domain\Requests\Http\Resources\RequestShow\TypeRequestResource ;
use App\Domain\Users\Models\RequestType;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class RequestPermissionResource.
 *
 * @property int $id
 * @property boolean $enabled
 * @property string $description
 * @property string $type_data
 * @property string $title
 * @property RequestType $requestType
 */
#[Schema(
    title: 'TemplateData resource',
    description: 'TemplateData resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),

        new Property(
            property: 'title_ar',
            type: 'string',
        ),

        new Property(
            property: 'request_type',
            ref: '#/components/schemas/TypeRequestResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class RequestPermissionResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {

        /**  structure json response */
        return   [
            'id' => $this->id,
            'title' => (\App::getLocale() == 'ar') ? $this->title_ar : $this->title_en ,


        ] ;
    }



}
