<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateUsersTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up ()
		{
			Schema::create ('users', function (Blueprint $table) {
				$table->increments ('id');
				$table->string ('name');
				$table->string ('phone')->unique ();
				$table->string ('password');
				$table->string ('otp')->nullable ();
				$table->string ('avatar')->nullable ();
				$table->boolean ('user')->default (FALSE);
				$table->boolean ('driver')->default (FALSE);
				$table->boolean ('marketer')->default (FALSE);
				$table->boolean ('admin')->default (FALSE);
                $table->boolean('accountant')->default(false)->nullable();
                $table->boolean('production')->default(false)->nullable();
				$table->boolean ('student')->default(FALSE);
				$table->boolean ('validated')->default (FALSE);
				$table->boolean ('verified')->default (false);
				$table->integer ('created_by')->default (0);
				$table->softDeletes ();
				$table->rememberToken ();
				$table->timestamps ();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down ()
		{
			Schema::dropIfExists ('users');
		}
	}
