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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 255);
            $table->string('group', 255);
            $table->string('left', 255)->nullable();
            $table->string('right', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('text', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->string('btn_title', 255)->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('is_visible')->nullable();
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
        Schema::dropIfExists('banners');
    }
};
