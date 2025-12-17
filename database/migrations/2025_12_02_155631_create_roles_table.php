<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191)->unique();
            $table->text('description')->nullable();
            $table->text('permissions')->nullable(); // JSON encoded permissions
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}