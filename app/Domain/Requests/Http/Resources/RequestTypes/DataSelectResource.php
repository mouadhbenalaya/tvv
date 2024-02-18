<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestTypes;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class DataSelectResource.
 *
 * @property int $id
 * @property string $title
 * @property boolean $enabled
 */
#[Schema(
    title: 'DataSelectResource resource',
    description: 'User resource',
    properties: [

        new Property(
            property: 'title',
            type: 'string',
        ),

    ],
    type: 'object'
)]
class DataSelectResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        $result =  [
              'title' =>   (\App::getLocale() == 'ar') ? $this->title_ar : $this->title_en ,
              'id' => $this->id,

          ] ;
        return  $result ;
    }
}
