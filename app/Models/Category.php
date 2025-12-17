<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'created_by',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'category', 'name');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeByCreator($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = \Str::slug($category->name);
            
            // Ensure slug is unique
            $originalSlug = $category->slug;
            $count = 1;
            while (static::where('slug', $category->slug)->exists()) {
                $category->slug = $originalSlug . '-' . $count++;
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = \Str::slug($category->name);
                
                // Ensure slug is unique (excluding current category)
                $originalSlug = $category->slug;
                $count = 1;
                while (static::where('slug', $category->slug)->where('id', '!=', $category->id)->exists()) {
                    $category->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }
}