<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Authentication;

use App\Common\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Response;

class LogoutController extends Controller
{
    #[Post(
        path: '/api/v1/auth/logout',
        description: 'Logout current user',
        summary: 'Logout user',
        security: [['sanctum' => []]],
        tags: [
            'Authentication',
        ],
        responses: [
            new Response(
                response: 200,
                description: 'Successful operation',
            ),
            new Response(
                response: 400,
                description: 'Bad Request',
            ),
            new Response(
                response: 403,
                description: 'Forbidden',
            ),
            new Response(
                response: 401,
                description: 'Unauthenticated',
            ),
        ],
    )]
    public function __invoke(Request $request): JsonResponse
    {
        auth()->user()?->tokens()->delete();

        return response()->json(['message' => 'User successfully signed out']);
    }
}
