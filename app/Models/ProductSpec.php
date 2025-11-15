<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'spec_definition_id',
        'value',
    ];

    /**
     * Quan hệ: một product spec thuộc về một product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Quan hệ: một product spec thuộc về một spec definition
     */
    public function specDefinition(): BelongsTo
    {
        return $this->belongsTo(SpecDefinition::class);
    }

    /**
     * Accessor: lấy giá trị đầy đủ với đơn vị
     */
    public function getFormattedValueAttribute(): string
    {
        $value = $this->value;
        $unit = $this->specDefinition->unit ?? '';
        
        return $unit ? "{$value} {$unit}" : $value;
    }
}
