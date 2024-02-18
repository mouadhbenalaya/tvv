<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestShow;

use App\Domain\Users\Models\RequestType;
use Illuminate\Http\Resources\Json\JsonResource;
use  App\Domain\Requests\Http\Resources\RequestShow\TemplateRequestDataFieldResource ;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class TemplateRequestDataResource.
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
            property: 'enabled',
            type: 'boolean',
            default: 1,
        ),
        new Property(
            property: 'description',
            type: 'string',
        ),
        new Property(
            property: 'title',
            type: 'string',
        ),
        new Property(
            property: 'template_data_field',
            ref: '#/components/schemas/TemplateRequestDataFieldResource',
            type: 'object',
        ),

    ],
    type: 'object'
)]
class TemplateRequestDataResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'description' =>  (\App::getLocale() == 'ar') ? $this->description_ar : $this->description  ,
            'title' =>  (\App::getLocale() == 'ar') ? $this->title_ar : $this->title    ,
            'requestDataField' =>  $this->requestDataFields->count() > 0 ? TemplateRequestDataFieldResource::collection($this->whenLoaded('requestDataFields')) : []  ,
         ];
    }
}
