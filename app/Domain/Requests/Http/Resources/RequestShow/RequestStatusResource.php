<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestShow;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class RequestStatusResource.
 *
 * @property int $id
 * @property string $title
 * @property boolean $enabled
 */
#[Schema(
    title: 'RequestStatusResource resource',
    description: 'RequestStatusResource resource',
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
class RequestStatusResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' =>  (\App::getLocale() == 'ar') ? $this->title_ar : $this->title_en ,
            'color' => $this ->code_color

        ];
    }
}
