<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestTypes;

use App\Domain\Requests\Models\RequestCategory;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class RequestTypeCategoryResource.
 *
 * @property int $id
 * @property string $title
 * @property boolean $enabled
 */
#[Schema(
    title: 'RequestCategory resource',
    description: 'RequestCategory resource',
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
class RequestTypeCategoryResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {

        $date  = [
            'id' => $this->id,
            'title' => (\App::getLocale() == 'ar') ? $this->title_ar : $this->title_en,
        ] ;

        return  $date ;
    }
}
