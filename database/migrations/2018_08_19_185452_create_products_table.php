<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::create('products' , function (Blueprint $table) {
			$table->increments('id');
			$table->string('title')->unique();
			$table->string('sku')->unique();
			$table->boolean('available')->default(TRUE);
			$table->float('price');
			$table->integer('qty');
			$table->double('weight');
			$table->text('description');
			$table->integer('category_id')->unsigned();
			$table->softDeletes();
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
		Schema::dropIfExists('products');
	}
}
