<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestTypes;

use  App\Domain\Requests\Http\Resources\RequestTypes\RequestCategoryResource ;
use App\Domain\Requests\Models\RequestCategory;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class ListRequestTypeResource.
 *
 * @property int $id
 * @property string $title
 * @property boolean $enabled
 */
#[Schema(
    title: 'RequestType resource',
    description: 'User resource',
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
            property: 'title',
            type: 'string',
        ),
        new Property(
            property: 'release_version',
            type: 'string',
        ),

        new Property(
            property: 'request_category_id',
            ref: '#/components/schemas/RequestCategoryResource',
            type: 'object',
        ),
        new Property(
            property: 'release_date',
            type: 'date',
        )
    ],
    type: 'object'
)]
class ListRequestTypeResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {


        $date  = [
            'id' => $this->id,
            'release_version' => $this->release_version   ,
            'release_date' => $this->release_date   ,
            'validator' => $this->validator   ,

            'title' =>   (\App::getLocale() == 'ar') ? $this->title_ar : $this->title ,
            'desc_short' =>    (\App::getLocale() == 'ar') ? $this->desc_short_ar : $this->desc_short_en  ,
            'desc_long' =>   (\App::getLocale() == 'ar') ? $this->desc_long_ar : $this->desc_long_en ,



            'category' => $this->requestCategory !==  null ? new RequestCategoryResource($this->requestCategory) : [] ,

        ] ;

        return  $date ;
    }
}
