<?php

declare(strict_types=1);

namespace App\Common\Http\Resources;

use App\Domain\Users\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Ramsey\Collection\Collection;

/**
 * Class AuditLogResource.
 *
 * @property int $id
 * @property string $auditable_type
 * @property int $auditable_id
 * @property string $event
 * @property ?User $created_by
 * @property Collection $payload
 * @property string $user_agent
 * @property string $ip_address
 * @property string $referer
 * @property \DateTime $created_at
 */
#[Schema(
    title: 'AuditLog resource',
    description: 'AuditLog resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'auditable_type',
            type: 'string',
            default: 'user',
        ),
        new Property(
            property: 'auditable_id',
            type: 'string',
            default: 1,
        ),
        new Property(
            property: 'created_by',
            ref: '#/components/schemas/UserResource',
            type: 'object',
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
        new Property(
            property: 'user_agent',
            type: 'string',
            default: 'Symfony',
        ),
        new Property(
            property: 'ip_address',
            type: 'string',
            default: '127.0.0.1',
        ),
        new Property(
            property: 'referer',
            type: 'string',
            default: 'http://localhost/docs',
        ),
    ],
    type: 'object'
)]
class AuditLogResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'auditable_type' => $this->auditable_type,
            'auditable_id' => $this->auditable_id,
            'event' => $this->event,
            'payload' => $this->payload,
            'created_by' => $this->created_by,
            'user_agent' => $this->user_agent,
            'ip_address' => $this->ip_address,
            'referer' => $this->referer,
        ];
    }
}
