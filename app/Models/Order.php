<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'payment_status',
        'payment_method',
        'status',
        'subtotal',
        'discount',
        'shipping_fee',
        'total',
        'placed_at',
        // Gộp từ OrderAddress
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_phone',
        'shipping_method',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'total' => 'decimal:2',
        'placed_at' => 'datetime',
    ];

    protected $dates = ['placed_at'];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'order_promotions')
            ->withPivot(['code', 'discount_value'])
            ->withTimestamps();
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('placed_at', 'desc');
    }

    // Methods
    public function getTotalDiscount()
    {
        return $this->promotions()->sum('order_promotions.discount_value');
    }

    public function getNetTotal()
    {
        return $this->total - $this->getTotalDiscount();
    }

    /**
     * Accessor for total_amount (alias for total column)
     * For backwards compatibility with views
     */
    public function getTotalAmountAttribute()
    {
        return $this->total;
    }

    /**
     * Accessor for total_discount
     */
    public function getTotalDiscountAttribute()
    {
        return $this->getTotalDiscount();
    }

    /**
     * Apply a promotion to this order
     */
    public function applyPromotion(Promotion $promotion): float
    {
        $subtotal = $this->items->sum(fn($item) => $item->price * $item->quantity);
        $discount = $promotion->calculateDiscount($subtotal);

        if ($discount > 0) {
            $this->promotions()->attach($promotion->id, [
                'code' => $promotion->code,
                'discount_value' => $discount,
            ]);

            $promotion->incrementUsage();
        }

        return $discount;
    }
}

