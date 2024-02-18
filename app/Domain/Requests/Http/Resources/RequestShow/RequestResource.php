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
 * Class RequestResource.
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
class RequestResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'notes' => $this->notes,
            'request_status' =>  $this->requestStatus !==  null ? new RequestStatusResource($this->requestStatus) : [] ,
            'request_date' => $this->created_at,
            'profile' => $this->profile !==  null ? new ProfileResource($this->profile) : [] ,
            'request_type' => $this->requestType !==  null ? new TypeRequestResource($this->requestType) : [] ,
            'requestDatas' => $this->requestDatas !==  null ? TemplateRequestDataResource::collection($this->requestDatas) : [] ,

        ];
    }
}
