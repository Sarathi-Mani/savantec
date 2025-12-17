<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilePictureToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if column doesn't exist before adding it
            if (!Schema::hasColumn('users', 'profile_picture')) {
                $table->string('profile_picture')->nullable()->after('email');
            }
            
            // Also check if company_id column exists, add if not
            if (!Schema::hasColumn('users', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable()->after('profile_picture');
                $table->foreign('company_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop the columns if they exist
            if (Schema::hasColumn('users', 'profile_picture')) {
                $table->dropColumn('profile_picture');
            }
            
            if (Schema::hasColumn('users', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }
        });
    }
}