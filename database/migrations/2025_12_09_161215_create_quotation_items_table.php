<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id');
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->decimal('quantity', 15, 2)->default(0);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->string('discount_type')->default('percent');
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('cgst_rate', 8, 2)->default(0);
            $table->decimal('sgst_rate', 8, 2)->default(0);
            $table->decimal('igst_rate', 8, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
            $table->index('quotation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_items');
    }
} 