<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number_1');
            $table->string('phone_number_2')->nullable();
            $table->string('store_name');
            $table->string('store_pics')->nullable();
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('country');
            $table->string('zip');
            // $table->string('business_reg_no');
            // $table->string('business_reg_doc')->nullable();
            // $table->string('tin');
            // $table->string('vat');
            // $table->string('vat_info_doc')->nullable();
            $table->string('company_name');
            $table->string('bank_name');
            $table->string('acct_holder_name');
            $table->string('bank_acct_number');
            // $table->string('bank_code');
            // $table->string('iban');
            // $table->string('swift');
            // $table->string('bank_info');
            // $table->string('api_token')->nullable();

            $table->boolean('active')->default(false);
            $table->string('activation_token')->nullable();

            $table->rememberToken();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sellers');
    }
}
