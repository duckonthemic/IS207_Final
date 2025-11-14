<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuildConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'total_price',
        'note',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BuildConfigItem::class);
    }

    // Methods
    public function calculateTotalPrice(): void
    {
        $this->total_price = $this->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
        $this->save();
    }
}
