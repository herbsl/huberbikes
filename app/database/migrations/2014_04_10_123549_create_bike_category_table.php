<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bike_category', function($table) {
			$table->increments('id');
			$table->integer('bike_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->timestamps();
		});

		Schema::table('bike_category', function($table) {
			$table->foreign('bike_id')
				->references('id')->on('bikes')
				->onDelete('cascade');
		});

		Schema::table('bike_category', function($table) {
			$table->foreign('category_id')
				->references('id')->on('categories')
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
		Schema::dropIfExists('bike_category');
	}
}
