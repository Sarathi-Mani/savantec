<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no')->unique();
            $table->date('enquiry_date');
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');
            $table->string('company_name')->nullable();
            $table->foreignId('salesman_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status')->nullable();
             $table->string('quotation_no')->nullable();
            $table->Integer('qty')->nullable();
            $table->dateTime('assigned_date_time')->nullable();
            $table->dateTime('purchase_date_time')->nullable();
            $table->dateTime('quotation_date_time')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('enquiry_date');
            $table->index('status');
            $table->index('company_id');
            $table->index('salesman_id');
            $table->index('created_by');
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('enquiries');
    }
};