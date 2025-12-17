<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('item_group', ['single', 'combo', 'bundle'])->default('single');
            $table->string('hsn', 50)->nullable();
            $table->string('barcode', 100)->nullable();
            $table->string('brand', 100)->nullable();
            $table->string('unit', 50)->nullable();
            $table->integer('alert_quantity')->default(0);
            $table->string('category', 100)->nullable();
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('discount', 15, 2)->default(0.00);
            $table->decimal('price', 15, 2)->default(0.00);
            $table->enum('tax_type', ['inclusive', 'exclusive'])->default('exclusive');
            $table->decimal('mrp', 15, 2)->default(0.00);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->decimal('profit_margin', 8, 2)->default(0.00);
            $table->string('sku', 100)->unique()->nullable();
            $table->integer('seller_points')->default(0);
            $table->decimal('purchase_price', 15, 2)->default(0.00);
            $table->decimal('sales_price', 15, 2)->default(0.00);
            $table->integer('opening_stock')->default(0);
            $table->integer('quantity')->default(0);
            $table->string('image')->nullable();
            $table->string('additional_image')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key constraints
            $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index(['name', 'sku', 'barcode']);
            $table->index('company_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}