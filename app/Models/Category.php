<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'depth',
        'description',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'depth' => 'integer',
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function recursiveChildren(): HasMany
    {
        return $this->children()->with('recursiveChildren');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get all root categories with their children (cached)
     * Cache for 1 hour to reduce database load
     */
    public static function getRootWithChildrenCached()
    {
        return cache()->remember('categories_root_with_children', 3600, function () {
            return self::root()
                ->with(['children' => function($query) {
                    $query->orderBy('name');
                }])
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Clear category cache when categories are modified
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            cache()->forget('categories_root_with_children');
        });

        static::deleted(function () {
            cache()->forget('categories_root_with_children');
        });
    }
}
