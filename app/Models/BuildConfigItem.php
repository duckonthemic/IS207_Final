<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildConfigItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'build_config_id',
        'component_type_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    // Relationships
    public function buildConfig(): BelongsTo
    {
        return $this->belongsTo(BuildConfig::class);
    }

    public function componentType(): BelongsTo
    {
        return $this->belongsTo(ComponentType::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getLineTotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}
