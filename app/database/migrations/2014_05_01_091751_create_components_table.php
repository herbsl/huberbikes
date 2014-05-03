<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('components', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('type_id')->unsigned();
			$table->timestamps();
		});

		Schema::table('components', function($table) {
			$table->foreign('type_id')
				->references('id')->on('types')
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
		Schema::dropIfExists('components');
	}

}
