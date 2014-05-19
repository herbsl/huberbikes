<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bikes', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->string('description');
			$table->decimal('price', 7, 2);
			$table->decimal('price_offer', 7, 2);
			$table->integer('manufacturer_id')->unsigned();
			$table->integer('year')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::table('bikes', function($table) {
			$table->foreign('manufacturer_id')
				->references('id')->on('manufacturers')
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
		Schema::dropIfExists('bikes');
	}

}
