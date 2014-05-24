<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeImageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bike_image', function($table) {
			$table->increments('id');
			$table->integer('bike_id')->unsigned();
			$table->integer('image_id')->unsigned();
			$table->timestamps();
		});

		Schema::table('bike_image', function($table) {
			$table->foreign('bike_id')
				->references('id')->on('bikes')
				->onDelete('cascade');
		});

		Schema::table('bike_image', function($table) {
			$table->foreign('image_id')
				->references('id')->on('images')
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
		Schema::dropIfExists('bike_image');
	}

}
