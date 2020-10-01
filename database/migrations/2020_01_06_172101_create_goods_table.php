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
            $table->mediumText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->bigInteger('originalPrice');
            $table->bigInteger('price');
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('quantity')->nullable();
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
