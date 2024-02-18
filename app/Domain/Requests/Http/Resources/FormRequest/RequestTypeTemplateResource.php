<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\FormRequest;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class RequestTypeTemplateResource.
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

    ],
    type: 'object'
)]
class RequestTypeTemplateResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,

        ];
    }
}
