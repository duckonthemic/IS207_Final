<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComponentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'is_required',
        'sort_order',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function buildConfigItems(): HasMany
    {
        return $this->hasMany(BuildConfigItem::class);
    }

    public function specDefinitions(): HasMany
    {
        return $this->hasMany(SpecDefinition::class);
    }

    // Scopes
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
