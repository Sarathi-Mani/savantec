<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'invoice_products', function (Blueprint $table){
            $table->double('discount', 25, 2)->default(0.00)->change();
        }
        );
        Schema::table(
            'proposal_products', function (Blueprint $table){
            $table->double('discount', 25, 2)->default(0.00)->change();
        }
        );
        Schema::table(
            'bill_products', function (Blueprint $table){
            $table->double('discount', 25, 2)->default(0.00)->change();
        }
        );
        Schema::table(
            'purchase_products', function (Blueprint $table){
            $table->double('discount', 25, 2)->default(0.00)->change();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'invoice_products', function (Blueprint $table){
            $table->dropColumn('discount');
        }
        );
        Schema::table(
            'proposal_products', function (Blueprint $table){
            $table->dropColumn('discount');
        }
        );
        Schema::table(
            'bill_products', function (Blueprint $table){
            $table->dropColumn('discount');
        }
        );
        Schema::table(
            'purchase_products', function (Blueprint $table){
            $table->dropColumn('discount');
        }
        );
    }
};
