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
	public function up ()
	{
		Schema::create('orders' , function (Blueprint $table) {
			$table->increments('id');
			$table->integer('business_id')->unsigned();
			$table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
			$table->double('amount');
			$table->boolean('assigned')->default(0);
			$table->boolean('paid')->default(0);
			$table->boolean('delivered')->default(0);
			$table->boolean('confirmed')->default(0);
			$table->boolean('canceled')->default(0);
			$table->integer('created_by')->default(0);
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
		Schema::dropIfExists('orders');
	}
}
