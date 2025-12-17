<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            
            // Quotation Information
            $table->string('quotation_code')->unique();
            $table->date('quotation_date');
            $table->date('expire_date')->nullable();
            $table->string('status')->nullable(); // open, closed, po_converted, lost
            $table->string('reference')->nullable();
            $table->string('reference_no')->nullable();
            $table->date('reference_date')->nullable();
            $table->text('payment_terms')->nullable();
            
            // Customer Information
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('contact_person');
            
            // Sales Information
            $table->unsignedBigInteger('salesman_id');
            $table->string('gst_type')->default('cgst_sgst'); // cgst_sgst, igst
            
            // Totals
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('other_charges', 15, 2)->default(0);
            $table->decimal('total_discount', 15, 2)->default(0);
            $table->decimal('cgst', 15, 2)->default(0);
            $table->decimal('sgst', 15, 2)->default(0);
            $table->decimal('igst', 15, 2)->default(0);
            $table->decimal('round_off', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            
            // Summary
            $table->integer('total_items')->default(0);
            $table->decimal('total_quantity', 15, 2)->default(0);
            
            // Additional Information
            $table->text('description')->nullable();
            $table->text('customer_message')->nullable();
            $table->boolean('send_email')->default(false);
            
            // Company and User Tracking
            // Since companies are stored in users table with type='company'
            $table->unsignedBigInteger('company_id'); // This should reference users.id where type='company'
            $table->unsignedBigInteger('created_by');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign Key Constraints
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('salesman_id')->references('id')->on('users')->onDelete('cascade');
            
            // IMPORTANT: company_id references users table, not companies table
            $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index('quotation_code');
            $table->index('customer_id');
            $table->index('salesman_id');
            $table->index('status');
            $table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}