<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignedsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::create('assigneds' , function (Blueprint $table) {
			$table->increments('id');
			$table->integer('order_id')->unsigned();
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
			$table->integer('business_id')->unsigned();
			$table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
			$table->integer('driver_id')->unsigned();
			$table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		Schema::dropIfExists('assigneds');
	}
}
