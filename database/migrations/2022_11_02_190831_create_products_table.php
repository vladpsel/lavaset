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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 255);
            $table->string('group', 255);
            $table->integer('category_id')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('alias', 255);
            $table->string('description', 255)->nullable();
            $table->float('price')->nullable();
            $table->float('weight')->nullable();
            $table->integer('parameter')->nullable();
            $table->string('picture', 255)->nullable();
            $table->text('components')->nullable();
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
        Schema::dropIfExists('products');
    }
};
