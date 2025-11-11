<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order',
        'start_at',
        'end_at',
        'max_usage',
        'usage_count',
        'description',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'max_usage' => 'integer',
        'usage_count' => 'integer',
    ];

    // Relationships
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_promotions')
            ->withPivot('discount_value')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereBetween('start_at', [now(), now()])
            ->where(function ($q) {
                $q->whereNull('max_usage')
                    ->orWhere('usage_count', '<', \DB::raw('max_usage'));
            });
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    // Methods
    public function isValid()
    {
        return now()->between($this->start_at, $this->end_at) &&
               ($this->max_usage === null || $this->usage_count < $this->max_usage);
    }

    public function canUse($orderTotal)
    {
        return $this->isValid() && $orderTotal >= $this->min_order;
    }

    public function calculateDiscount($amount)
    {
        if ($this->type === 'percent') {
            return ($amount * $this->value) / 100;
        }
        return min($this->value, $amount);
    }
}
