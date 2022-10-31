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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 255);
            $table->integer('group');
            $table->string('title', 255);
            $table->string('alias', 255);
            $table->string('icon', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('keywords', 255)->nullable();
            $table->integer('isVisible')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
