<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('good_id')->unsigned()->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->decimal('price', 12, 2);
            $table->bigInteger('views')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->bigInteger('color')->nullable();
            $table->string('color_image')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
