<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update free plan to allow unlimited users (-1 means unlimited)
        DB::table('plans')
            ->where('price', 0)
            ->where(function($query) {
                $query->where('name', 'LIKE', '%Free%')
                      ->orWhere('name', 'LIKE', '%free%');
            })
            ->update(['max_users' => -1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert free plan to 5 users limit
        DB::table('plans')
            ->where('price', 0)
            ->where(function($query) {
                $query->where('name', 'LIKE', '%Free%')
                      ->orWhere('name', 'LIKE', '%free%');
            })
            ->update(['max_users' => 5]);
    }
};

