<?php

namespace App\Domain\Users\Http\Controllers\Permission;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Resources\User\ProfileResource;
use App\Domain\Users\Http\Resources\User\ProfileResourceForRoles;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\Role;
use App\Domain\Users\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class RevokeRoleProfileController extends Controller
{
    #[Post(
        path: '/api/v1/users/profiles/{profile}/roles/revoke',
        summary: 'Revoke Role from Profile',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Revoke Role from Profile',
            required: true,
            content: new JsonContent(
                required: [
                    'roles',
                ],
                properties: [
                    new Property(
                        property: 'roles',
                        type: [],
                        example: [1,2],
                    ),
                ],
            ),
        ),
        tags: [
            'Users',
        ],
        parameters: [
            new Parameter(
                name: 'profile',
                description: 'Profile id',
                in: 'path',
                required: true,
                example: 1,
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'Role revoked from profile successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/ProfileResourceForRoles',
                ),
            ),
            new \OpenApi\Attributes\Response(
                response: 400,
                description: 'Bad Request',
            ),
            new \OpenApi\Attributes\Response(
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]
    public function __invoke(Request $request, Profile $profile): JsonResponse
    {
        //$this->authorize('revoke', $profile);

        if ($request->has('roles')) {
            foreach ($request->input('roles') as $role_id) {
                $profile->removeRole(Role::where('id', $role_id)->pluck('name')->first());
            }
        }

        return response()->json(new ProfileResourceForRoles($profile), Response::HTTP_CREATED);
    }
}
