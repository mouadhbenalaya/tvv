<?php

declare(strict_types=1);

namespace Tests\Feature\AuditLog;

use App\Common\Models\AuditLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AuditLogCreateTest extends TestCase
{
    use RefreshDatabase;

    public static function getAuditLogData(): array
    {
        return [
          [422, '{"old":{"first_name": "Mark"}, "new":{"first_name": "John"}']  ,
          [201, '{"old":{"first_name": "Mark"}, "new":{"first_name": "John"}}']
        ];
    }

    #[DataProvider('getAuditLogData')]
    public function testShouldReturn422Or201WhenCreatingAuditLog(int $code, string $payload): void
    {
        $data = [];
        $data['auditable_type'] = 'user';
        $data['auditable_id'] = 1;
        $data['event'] = 'create';
        $data['payload'] = $payload;

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->postJson(self::AUDIT_LOG, $data);

        $response->assertStatus($code);
    }

    public function testShouldReturn201WhenCreatingAuditLogAndCheckingWithUser(): void
    {

        $data = [];
        $data['auditable_type'] = 'user';
        $data['auditable_id'] = $this->user->id;
        $data['event'] = 'test';
        $data['payload'] = '{"old":{"first_name": "Mark"}, "new":{"first_name": "John"}}';

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->postJson(self::AUDIT_LOG, $data);

        /** @var AuditLog $lastLog */
        $lastLog = $this->user->auditLogs()->get()->last();

        $response->assertStatus(201);
        $this->assertEquals('test', $lastLog->event);
    }
}
