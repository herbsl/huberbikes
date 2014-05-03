<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeComponentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bike_component', function($table) {
			$table->increments('id');
			$table->integer('bike_id')->unsigned();
			$table->integer('component_id')->unsigned();
			$table->timestamps();
		});

		Schema::table('bike_component', function($table) {
			$table->foreign('bike_id')
				->references('id')->on('bikes')
				->onDelete('cascade');
		});

		Schema::table('bike_component', function($table) {
			$table->foreign('component_id')
				->references('id')->on('components')
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
		Schema::dropIfExists('bike_component');
	}
}
