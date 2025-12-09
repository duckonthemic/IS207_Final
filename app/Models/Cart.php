<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->where('status', 'ordered');
    }

    // Methods
    public function getTotal()
    {
        // Use loaded items if available to avoid extra query
        if ($this->relationLoaded('items')) {
            return $this->items->sum(function ($item) {
                return $item->price * $item->qty;
            });
        }
        return $this->items()->sum(\DB::raw('price * qty'));
    }

    public function getItemCount()
    {
        // Use loaded items if available to avoid extra query
        if ($this->relationLoaded('items')) {
            return $this->items->sum('qty');
        }
        return $this->items()->sum('qty');
    }
}
