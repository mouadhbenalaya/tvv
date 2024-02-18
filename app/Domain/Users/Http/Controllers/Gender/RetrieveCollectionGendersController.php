<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Gender;

use App\Common\Http\Controllers\Controller;
use App\Common\Http\Requests\Search\DefaultSearchRequest;
use App\Domain\Users\Http\Resources\Gender\GenderResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;

class RetrieveCollectionGendersController extends Controller
{
    #[Get(
        path: '/api/v1/genders',
        summary: 'Get list of genders',
        security: [['sanctum' => []]],
        tags: [
            'Genders',
        ],
        parameters: [
            new Parameter(
                name: 'locale',
                description: 'Language locale',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    enum: [
                        'en',
                        'ar',
                    ],
                ),
            ),
        ],
        responses: [
            new Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    type: 'array',
                    items: new Items(
                        ref: '#/components/schemas/GenderResource',
                    ),
                ),
            ),
            new Response(
                response: 400,
                description: 'Bad Request',
            ),
        ],
    )]
    public function __invoke(DefaultSearchRequest $request): ResourceCollection
    {
        return GenderResource::collection(['m', 'f']);
    }
}
