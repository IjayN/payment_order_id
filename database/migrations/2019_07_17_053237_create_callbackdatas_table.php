<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallbackdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callbackdatas', function (Blueprint $table) {
            $table->increments('id');
            $table->string ('MerchantRequestID');
            $table->string ('CheckoutRequestID');
            $table->string ('ResultCode');
            $table->string ('ResultDesc');
            $table->string ('amount');
            $table->string ('MpesaReceiptNumber');
            $table->string ('phone_no');
            $table->string ('order_id');
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
        Schema::dropIfExists('callbackdatas');
    }
}
