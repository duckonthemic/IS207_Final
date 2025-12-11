<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'component_type_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'sku',
        'stock',
        'brand',
        'specifications',
        'image',
        'warranty_months',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock' => 'integer',
        'specifications' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'warranty_months' => 'integer',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function componentType(): BelongsTo
    {
        return $this->belongsTo(ComponentType::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('is_primary', 'desc');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->reviews()->where('status', 'approved');
    }

    public function specs(): HasMany
    {
        return $this->hasMany(ProductSpec::class);
    }

    // Scopes
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    // Accessors
    public function getDisplayPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDisplayPrice()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getAverageRatingAttribute()
    {
        // Use cached/loaded relation if available to avoid N+1
        if ($this->relationLoaded('approvedReviews')) {
            $reviews = $this->approvedReviews;
            return $reviews->count() > 0 ? $reviews->avg('rating') : 0;
        }

        // Fallback to query (but this should be avoided with proper eager loading)
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        // Use withCount if available
        if (array_key_exists('approved_reviews_count', $this->attributes)) {
            return $this->attributes['approved_reviews_count'];
        }

        // Use cached/loaded relation if available to avoid N+1
        if ($this->relationLoaded('approvedReviews')) {
            return $this->approvedReviews->count();
        }

        // Fallback to query
        return $this->approvedReviews()->count();
    }

    public function getDiscountPercentAttribute()
    {
        if ($this->sale_price && $this->price > $this->sale_price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Get the primary image URL for the product
     */
    public function getImageUrlAttribute(): ?string
    {
        // Try to get from images relation first
        if ($this->relationLoaded('images') && $this->images->isNotEmpty()) {
            $primary = $this->images->firstWhere('is_primary', true) ?? $this->images->first();
            return asset($primary->url);
        }
        
        // Query if not loaded
        $image = $this->images()->where('is_primary', true)->first() 
            ?? $this->images()->first();
        
        if ($image) {
            return asset($image->url);
        }
        
        // Fallback to legacy image field
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        
        return null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

