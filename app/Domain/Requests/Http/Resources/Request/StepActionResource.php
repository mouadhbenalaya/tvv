<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\Request;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class StepActionResource.
 *
 * @property int $id
 * @property string $title
 */
#[Schema(
    title: 'get Steps Request  resource',
    description: 'get Steps  Request Steps resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),

        new Property(
            property: 'title',
            type: 'string',
        ),


    ],
    type: 'object'
)]
class StepActionResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {


        $date  = [
            'id' => (string) $this->id,
            'title' => (\App::getLocale() == 'ar') ? $this->title_ar : $this->title_en,
            'color' => $this->code_color ,
            

        ] ;

        return  $date ;
    }
}
