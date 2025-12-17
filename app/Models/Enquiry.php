<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_no',
        'enquiry_date',
        'company_id',
        'company_name',
        'kind_attn',        // ADDED
        'mail_id',          // ADDED
        'phone_no', 
        'qty',        
        'remarks',          // ADDED
        'items',            // ADDED
        'salesman_id',
        'status',
        'quotation_no',
        'pending_remarks',
        'assigned_date_time',
        'purchase_date_time',
        'quotation_date_time',
        'issued_date',      // ADDED
        'pop_date',         // ADDED
        'quotation_no',     // ADDED
        'created_by',
    ];

    protected $casts = [
        'enquiry_date' => 'date',
        'assigned_date_time' => 'datetime',
        'purchase_date_time' => 'datetime',
        'quotation_date_time' => 'datetime',
        'issued_date' => 'datetime',   // ADDED
        'pop_date' => 'datetime',      // ADDED
        'items' => 'array',            // ADDED - This is important for JSON column
    ];

    public function salesman()
    {
        return $this->belongsTo(User::class, 'salesman_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id')
            ->where('type', 'company');
    }
    
    // Helper method to get items count
    public function getItemsCountAttribute()
    {
        return is_array($this->items) ? count($this->items) : 0;
    }
    
    // Helper method to get first item description
    public function getFirstItemDescriptionAttribute()
    {
        if (is_array($this->items) && count($this->items) > 0) {
            return $this->items[0]['description'] ?? null;
        }
        return null;
    }
}