<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePanoramaDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('panorama_data', function(Blueprint $table)
		{
			$table->integer('data_id', true);
			$table->integer('dataset_id_FK');
			$table->integer('author_id_FK');
			$table->string('year', 5);
			$table->text('details', 65535);
			$table->string('src', 512);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('panorama_data');
	}

}
