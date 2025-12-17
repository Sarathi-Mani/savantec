<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('enquiries', 'kind_attn')) {
                $table->string('kind_attn')->nullable()->after('company_name');
            }
            
            if (!Schema::hasColumn('enquiries', 'mail_id')) {
                $table->string('mail_id')->nullable()->after('kind_attn');
            }
            
            if (!Schema::hasColumn('enquiries', 'phone_no')) {
                $table->string('phone_no', 20)->nullable()->after('mail_id');
            }
            
            if (!Schema::hasColumn('enquiries', 'remarks')) {
                $table->text('remarks')->nullable()->after('phone_no');
            }
            
            if (!Schema::hasColumn('enquiries', 'items')) {
                $table->json('items')->nullable()->after('remarks');
            }
            
            if (!Schema::hasColumn('enquiries', 'issued_date')) {
                $table->dateTime('issued_date')->nullable()->after('quotation_date_time');
            }
            
            if (!Schema::hasColumn('enquiries', 'pop_date')) {
                $table->dateTime('pop_date')->nullable()->after('issued_date');
            }
            
            if (!Schema::hasColumn('enquiries', 'quotation_no')) {
                $table->string('quotation_no', 100)->nullable()->after('pop_date');
            }
        });
    }

    public function down()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            // Remove columns if they exist
            $columns = [
                'kind_attn',
                'mail_id',
                'phone_no',
                'remarks',
                'items',
                'issued_date',
                'pop_date',
                'quotation_no'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('enquiries', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};