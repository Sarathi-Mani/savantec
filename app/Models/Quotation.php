<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quotation_code',
        'quotation_date',
        'expire_date',
        'status',
        'reference',
        'reference_no',
        'reference_date',
        'payment_terms',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_mobile',
        'contact_person',
        'salesman_id',
        'gst_type',
        'subtotal',
        'other_charges',
        'total_discount',
        'cgst',
        'sgst',
        'igst',
        'round_off',
        'grand_total',
        'total_items',
        'total_quantity',
        'description',
        'customer_message',
        'send_email',
        'company_id',
        'created_by'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'other_charges' => 'decimal:2',
        'total_discount' => 'decimal:2',
        'cgst' => 'decimal:2',
        'sgst' => 'decimal:2',
        'igst' => 'decimal:2',
        'round_off' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'total_quantity' => 'decimal:2',
        'send_email' => 'boolean'
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function salesman()
    {
        return $this->belongsTo(User::class, 'salesman_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
}