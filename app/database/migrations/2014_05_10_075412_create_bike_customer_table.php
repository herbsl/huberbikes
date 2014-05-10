<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bike_customer', function($table) {
			$table->increments('id');
			$table->integer('bike_id')->unsigned();
			$table->integer('customer_id')->unsigned();
			$table->timestamps();
		});

		Schema::table('bike_customer', function($table) {
			$table->foreign('bike_id')
				->references('id')->on('bikes')
				->onDelete('cascade');
		});

		Schema::table('bike_customer', function($table) {
			$table->foreign('customer_id')
				->references('id')->on('customers')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('bike_customer');
	}
}
