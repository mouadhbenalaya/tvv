<?php

namespace App\Domain\Users\Http\Responses;

use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TokenResponse
{
    public function json(User $user, string $token): JsonResponse
    {
        return response()->json([
            'token' => $token,
            'tokenType' => 'Bearer',
            'user' => new UserResource($user->load('profiles')),
        ], Response::HTTP_CREATED);
    }
}
