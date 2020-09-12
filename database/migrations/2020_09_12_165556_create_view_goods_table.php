<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_goods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->unsigned()->nullable();
            $table->string('userName')->nullable();
            $table->bigInteger('sellerId')->nullable();
            $table->string('sellerName')->nullable();
            $table->bigInteger('goodId')->nullable();
            $table->string('goodName')->nullable();
            $table->bigInteger('goodViews')->nullable();
            $table->string('cityName')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('countryName')->nullable();
            $table->string('ip')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->string('browserVersion')->nullable();
            $table->string('languages')->nullable();
            $table->string('platform')->nullable();
            $table->string('platformVersion')->nullable();
            $table->string('robot')->nullable();
            
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
        Schema::dropIfExists('view_goods');
    }
}
