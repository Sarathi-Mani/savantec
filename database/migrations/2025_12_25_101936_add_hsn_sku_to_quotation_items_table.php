<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::table('quotation_items', function (Blueprint $table) {
        if (!Schema::hasColumn('quotation_items', 'hsn_code')) {
            $table->string('hsn_code', 100)->nullable()->after('description');
        }
        if (!Schema::hasColumn('quotation_items', 'sku')) {
            $table->string('sku', 100)->nullable()->after('hsn_code');
        }
    });
}

public function down()
{
    Schema::table('quotation_items', function (Blueprint $table) {
        $table->dropColumn(['hsn_code', 'sku']);
    });
}
};
