<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'entity',
        'entity_id',
        'payload_json',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'payload_json' => 'json',
    ];

    public $timestamps = true;
    const UPDATED_AT = null;

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByEntity($query, $entity)
    {
        return $query->where('entity', $entity);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeRecent($query)
    {
        return $query->latest('created_at');
    }
}
