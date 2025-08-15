<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WarehouseItem
 *
 * @property int $id
 * @property string $item_code
 * @property string $name
 * @property string|null $description
 * @property string $category
 * @property int $quantity
 * @property int $min_quantity
 * @property string $unit_price
 * @property string $unit
 * @property string|null $location
 * @property string|null $supplier
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_low_stock
 * @property string $total_value
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereItemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereMinQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem active()
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem lowStock()
 * @method static \Database\Factories\WarehouseItemFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class WarehouseItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'item_code',
        'name',
        'description',
        'category',
        'quantity',
        'min_quantity',
        'unit_price',
        'unit',
        'location',
        'supplier',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'min_quantity' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    /**
     * Check if the item is low on stock.
     *
     * @return bool
     */
    public function getIsLowStockAttribute(): bool
    {
        return $this->quantity <= $this->min_quantity;
    }

    /**
     * Get the total value of the item in stock.
     *
     * @return string
     */
    public function getTotalValueAttribute(): string
    {
        return number_format($this->quantity * (float) $this->unit_price, 2);
    }

    /**
     * Scope a query to only include active items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include low stock items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= min_quantity');
    }
}