<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemVariantsTable extends Migration
{
    public function up()
    {
        Schema::create('item_variants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
              $table->string('slug')->unique();
            $table->text('description')->nullable();
             $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();$table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_variants');
    }
}