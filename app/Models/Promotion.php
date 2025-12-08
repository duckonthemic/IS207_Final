<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_order_value',
        'max_discount',
        'usage_limit',
        'usage_per_user',
        'usage_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_per_user' => 'integer',
        'usage_count' => 'integer',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_promotions')
            ->withPivot(['code', 'discount_value'])
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        $now = Carbon::now();
        return $query->active()
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', $now);
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhereRaw('usage_count < usage_limit');
            });
    }

    // Methods

    /**
     * Check if promotion is currently valid
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        // Check start date
        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        // Check expiry date
        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        // Check usage limit
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Check if user can use this promotion
     */
    public function canBeUsedBy(int $userId): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        // Check user usage limit
        $userUsageCount = $this->orders()
            ->where('user_id', $userId)
            ->count();

        return $userUsageCount < $this->usage_per_user;
    }

    /**
     * Calculate discount amount for an order total
     */
    public function calculateDiscount(float $orderTotal): float
    {
        // Check minimum order value
        if ($this->min_order_value && $orderTotal < $this->min_order_value) {
            return 0;
        }

        $discount = 0;

        if ($this->type === 'percentage') {
            $discount = $orderTotal * ($this->value / 100);

            // Apply max discount cap
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
        } else {
            // Fixed amount
            $discount = $this->value;
        }

        // Discount cannot exceed order total
        return min($discount, $orderTotal);
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    /**
     * Get formatted value for display
     */
    public function getFormattedValueAttribute(): string
    {
        if ($this->type === 'percentage') {
            return $this->value . '%';
        }
        return number_format((float) $this->value, 0, ',', '.') . '₫';
    }

    /**
     * Get status label
     */
    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        $now = Carbon::now();

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return 'scheduled';
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return 'expired';
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return 'exhausted';
        }

        return 'active';
    }
}
