<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the creator of the brand.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get items associated with this brand.
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'brand', 'name');
    }

    /**
     * Scope a query to only include active brands.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include brands created by specific user.
     */
    public function scopeByCreator($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    /**
     * Generate slug from name automatically.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            $brand->slug = \Str::slug($brand->name);
            
            // Ensure slug is unique
            $originalSlug = $brand->slug;
            $count = 1;
            while (static::where('slug', $brand->slug)->exists()) {
                $brand->slug = $originalSlug . '-' . $count++;
            }
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('name')) {
                $brand->slug = \Str::slug($brand->name);
                
                // Ensure slug is unique (excluding current brand)
                $originalSlug = $brand->slug;
                $count = 1;
                while (static::where('slug', $brand->slug)->where('id', '!=', $brand->id)->exists()) {
                    $brand->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }
}