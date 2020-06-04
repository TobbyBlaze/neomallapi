<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            
            $table->bigInteger('quantity')->nullable();

            // Information about user
            $table->string('first_name');
            $table->string('last_name');
            $table->string('country');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->bigInteger('subtotal')->nullable();
            $table->bigInteger('total')->nullable();

            // Confirmed order or not
            // $table->string('confirmed')->nullable();

            $table->timestamps();

            // User ID
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade');
            // $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
