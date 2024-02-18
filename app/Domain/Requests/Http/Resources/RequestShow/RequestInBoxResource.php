<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestShow;

use App\Domain\Requests\Http\Resources\RequestShow\TypeRequestResource ;
use  App\Domain\Requests\Http\Resources\RequestShow\TemplateRequestDataResource ;
use App\Domain\Users\Http\Resources\User\ProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class RequestInBoxResource.
 *
 * @property int $id
 * @property string $title
 * @property boolean $enabled
 */
#[Schema(
    title: 'RequestType resource',
    description: 'RequestType resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'notes',
            type: 'string',
            default: 1,
        ),

        new Property(
            property: 'created_at',
            type: 'date',
        ),
        new Property(
            property: 'profile',
            ref: '#/components/schemas/TypeRequestResource',
            type: 'object',
        ),
        new Property(
            property: 'request_type',
            ref: '#/components/schemas/TypeRequestResource',
            type: 'object',
        ),
        new Property(
            property: 'request_status',
            ref: '#/components/schemas/RequestStatusResource',
            type: 'object',
        ),

    ],
    type: 'object'
)]
class RequestInBoxResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'notes' => $this->notes,
            'status' =>    (\App::getLocale() == 'ar') ? $this->requestStatus->title_ar : $this->requestStatus->title_en  ,
            'date_request' => $this->created_at->format('Y-m-d'),
            'profile' => $this->profile->user->getFullNameAttribute() ,
            'request_type' => (\App::getLocale() == 'ar') ? $this->requestType->title_ar : $this->requestType->title  ,


        ];
    }
}
