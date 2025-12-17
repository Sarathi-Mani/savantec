<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'product_services', function (Blueprint $table){
            $table->float('quantity', 25, 2)->default(0.00)->change();
        }
        );
        Schema::table(
            'invoice_products', function (Blueprint $table){
            $table->float('quantity', 25, 2)->default(0.00)->change();
        }
        );
        Schema::table(
            'proposal_products', function (Blueprint $table){
            $table->float('quantity', 25, 2)->default(0.00)->change();
        }
        );
        Schema::table(
            'bill_products', function (Blueprint $table){
            $table->float('quantity', 25, 2)->default(0.00)->change();
        }
        );
        Schema::table(
            'purchase_products', function (Blueprint $table){
            $table->float('quantity', 25, 2)->default(0.00)->change();
        }
        );
        Schema::table(
            'pos_products', function (Blueprint $table){
            $table->float('quantity', 25, 2)->default(0.00)->change();
        }
        );
        Schema::table(
            'warehouse_products', function (Blueprint $table){
            $table->float('quantity', 25, 2)->default(0.00)->change();
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
            'product_services', function (Blueprint $table){
            $table->dropColumn('quantity');
        }
        );
        Schema::table(
            'invoice_products', function (Blueprint $table){
            $table->dropColumn('quantity');
        }
        );
        Schema::table(
            'proposal_products', function (Blueprint $table){
            $table->dropColumn('quantity');
        }
        );
        Schema::table(
            'bill_products', function (Blueprint $table){
            $table->dropColumn('quantity');
        }
        );
        Schema::table(
            'purchase_products', function (Blueprint $table){
            $table->dropColumn('quantity');
        }
        );
        Schema::table(
            'pos_products', function (Blueprint $table){
            $table->dropColumn('quantity');
        }
        );
        Schema::table(
            'warehouse_products', function (Blueprint $table){
            $table->dropColumn('quantity');
        }
        );
    }
};
