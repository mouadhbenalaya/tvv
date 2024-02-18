<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestTypes;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class ApiGetDataSelectResource.
 *
 * @property int $id
 * @property string $title
 * @property boolean $enabled
 */
#[Schema(
    title: 'ApiGetDataSelectResource resource',
    description: 'ApiGetDataSelectResource resource',
    properties: [

        new Property(
            property: 'title',
            type: 'string',
        ),

    ],
    type: 'object'
)]
class ApiGetDataSelectResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        $result =  [
              'title' =>   (\App::getLocale() == 'ar') ? $this->title_ar : $this->title_en ,
              'const' => $this->id,

          ] ;
        return  $result ;
    }
}
