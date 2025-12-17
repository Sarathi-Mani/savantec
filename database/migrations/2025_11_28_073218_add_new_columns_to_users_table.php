<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('name')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('mobile')->after('email')->nullable();
            $table->unsignedBigInteger('company_id')->after('created_by')->nullable();
            
            // Add foreign key constraint if you have a companies table
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            
            // If you want to keep the original name field but split it
            // You can modify the existing name field to be nullable
            $table->string('name')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'mobile', 'company_id']);
            $table->string('name')->nullable(false)->change();
        });
    }
}