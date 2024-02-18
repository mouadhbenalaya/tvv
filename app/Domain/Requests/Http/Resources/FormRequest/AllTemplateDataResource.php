<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\FormRequest;

use App\Domain\Requests\Models\FieldType;
use App\Domain\Requests\Models\TemplateDataField;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class AllTemplateDataResource.
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
            property: 'request_type',
            ref: '#/components/schemas/RequestTypeTemplateResource',
            type: 'object',
        ),

    ],
    type: 'object'
)]
class AllTemplateDataResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'enabled' => $this->enabled,
            'description' =>   (\App::getLocale() == 'ar') ? $this->description_ar : $this->description  ,
            'title' =>   (\App::getLocale() == 'ar') ? $this->title_ar : $this->title  ,
             'request_type' => $this->requestType !==  null ? new RequestTypeTemplateResource($this->requestType) : [] ,
        //   'current_parent' =>  $this->requestType !==  null ?  new TemplateDataResource($this->templateData )  : [] ,
         //  'template_data_field' =>  $this->templateDataField->count() > 0 ?  TemplateDataFieldResource::collection( $this->whenLoaded('templateDataField') ) : []  ,
        ];
    }
}
