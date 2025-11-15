<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecDefinition extends Model
{
    use HasFactory;

    protected $fillable = [
        'component_type_id',
        'name',
        'code',
        'unit',
        'input_type',
        'options',
        'sort_order',
        'is_required',
        'is_filterable',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_filterable' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Quan hệ: một spec definition thuộc về một component type
     */
    public function componentType(): BelongsTo
    {
        return $this->belongsTo(ComponentType::class);
    }

    /**
     * Quan hệ: một spec definition có nhiều product specs
     */
    public function productSpecs(): HasMany
    {
        return $this->hasMany(ProductSpec::class);
    }

    /**
     * Scope: sắp xếp theo thứ tự hiển thị
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
