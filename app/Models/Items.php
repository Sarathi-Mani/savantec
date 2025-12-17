<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Items extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'item_group',
        'hsn',
        'barcode',
        'brand',
        'unit',
        'alert_quantity',
        'category',
        'description',
        'discount_type',
        'discount',
        'price',
        'tax_type',
        'mrp',
        'company_id',
        'tax_id',
        'profit_margin',
        'sku',
        'seller_points',
        'purchase_price',
        'sales_price',
        'opening_stock',
        'quantity',
        'image',
        'additional_image',
        'created_by'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'mrp' => 'decimal:2',
        'profit_margin' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'sales_price' => 'decimal:2',
        'alert_quantity' => 'integer',
        'seller_points' => 'integer',
        'opening_stock' => 'integer',
        'quantity' => 'integer',
    ];

    /**
     * Get the company that owns the item.
     */
    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    /**
     * Get the tax associated with the item.
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    /**
     * Get the creator of the item.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-item.png');
    }

    /**
     * Get the additional image URL.
     */
    public function getAdditionalImageUrlAttribute()
    {
        if ($this->additional_image) {
            return asset('storage/' . $this->additional_image);
        }
        return null;
    }

    /**
     * Calculate final price after discount
     */
    public function getFinalPriceAttribute()
    {
        $price = $this->price;
        
        if ($this->discount > 0) {
            if ($this->discount_type == 'percentage') {
                $price = $price - ($price * ($this->discount / 100));
            } else {
                $price = $price - $this->discount;
            }
        }
        
        return round($price, 2);
    }

    /**
     * Check if stock is low
     */
    public function getIsLowStockAttribute()
    {
        return $this->quantity <= $this->alert_quantity;
    }

    /**
     * Calculate profit amount
     */
    public function getProfitAmountAttribute()
    {
        return round($this->sales_price - $this->purchase_price, 2);
    }

    /**
     * Scope a query to only include items for the current user.
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('created_by', auth()->id());
    }

    /**
     * Scope a query to search items.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%")
                    ->orWhere('hsn', 'like', "%{$search}%");
    }

    /**
     * Scope a query to filter by company.
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to filter by brand.
     */
    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand);
    }

    /**
     * Update stock quantity
     */
    public function updateStock($quantity)
    {
        $this->quantity += $quantity;
        $this->save();
        return $this;
    }
}