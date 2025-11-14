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
        'total',
        'placed_at',
        // Gộp từ OrderAddress
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_phone',
    ];

    protected $casts = [
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
}
