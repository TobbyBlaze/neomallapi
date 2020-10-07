<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('seller_id')->unsigned()->nullable();
            $table->string('seller_name')->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->decimal('originalPrice', 12, 2);
            $table->decimal('price', 12, 2);
            $table->decimal('discount', 3, 2)->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->string('colors')->nullable();
            $table->string('sizes')->nullable();
            $table->bigInteger('views')->nullable();
            $table->string('countryName')->nullable();
            $table->string('cityName')->nullable();
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
