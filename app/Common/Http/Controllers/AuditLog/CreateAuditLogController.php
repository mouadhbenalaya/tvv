<?php

declare(strict_types=1);

namespace App\Common\Http\Controllers\AuditLog;

use App\Application\Contracts\AuditLogRepository;
use App\Common\Http\Controllers\Controller;
use App\Common\Http\Requests\AuditLogRequest;
use App\Common\Http\Resources\AuditLogResource;
use App\Common\Models\AuditLog;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class CreateAuditLogController extends Controller
{
    public function __construct(
        private readonly AuditLogRepository $auditLogRepository,
    ) {
    }

    #[Post(
        path: '/api/v1/audit-logs',
        summary: 'Create AuditLog resource',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Create AuditLog',
            required: true,
            content: new JsonContent(
                required: ['auditable_type', 'auditable_id', 'event', 'payload'],
                properties: [
                    new Property(
                        property: 'auditable_type',
                        type: 'string',
                        example: 'user',
                    ),
                    new Property(
                        property: 'auditable_id',
                        type: 'integer',
                        example: 1,
                    ),
                    new Property(
                        property: 'event',
                        type: 'string',
                        default: 'create',
                    ),
                    new Property(
                        property: 'payload',
                        type: 'json',
                        example: '{"old":{"employee_number":123},"new":{"employee_number":321}}'
                    ),
                ],
            ),
        ),
        tags: [
            'AuditLog',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'AuditLog created',
                content: new JsonContent(
                    ref: '#/components/schemas/AuditLogResource',
                ),
            ),
            new \OpenApi\Attributes\Response(
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]
    public function __invoke(AuditLogRequest $request): JsonResponse
    {
        $data = $request->getData();
        $data['created_by'] = optional(auth()->user())->id;

        $auditLog = $this->auditLogRepository->store($data);

        return response()->json(new AuditLogResource($auditLog), Response::HTTP_CREATED);
    }
}
