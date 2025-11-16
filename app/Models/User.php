<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MODERATOR = 'moderator';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function buildConfigs(): HasMany
    {
        return $this->hasMany(BuildConfig::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    // Methods
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    public function isStaff(): bool
    {
        return $this->isAdmin() || $this->isModerator();
    }

    public function getDefaultAddress()
    {
        return $this->addresses()->where('is_default', true)->first();
    }

    public function getActiveCart()
    {
        return $this->carts()->where('status', 'active')->first();
    }

    public function getOrCreateActiveCart()
    {
        $cart = $this->getActiveCart();
        if (!$cart) {
            $cart = $this->carts()->create(['status' => 'active']);
        }
        return $cart;
    }
}
