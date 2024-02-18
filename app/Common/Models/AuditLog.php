<?php

namespace App\Common\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'payload',
        'user_agent',
        'ip_address',
        'referer',
        'created_by',
        'auditable_type',
        'auditable_id',
    ];

    protected $casts = [
        'payload' => 'collection'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function (AuditLog $auditLog) {

            $request = optional(request());
            $auditLog->ip_address = $request->ip();
            $auditLog->referer = $request->header('referer');
            $auditLog->user_agent = $request->userAgent();
        });
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }
}
