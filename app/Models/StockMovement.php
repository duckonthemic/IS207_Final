<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'branch_id',
        'type',
        'qty_before',
        'qty_after',
        'note',
    ];

    protected $casts = [
        'qty_before' => 'integer',
        'qty_after' => 'integer',
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    // Scopes
    public function scopeInbound($query)
    {
        return $query->where('type', 'IN');
    }

    public function scopeOutbound($query)
    {
        return $query->where('type', 'OUT');
    }

    public function scopeAdjustments($query)
    {
        return $query->where('type', 'ADJUST');
    }
}
